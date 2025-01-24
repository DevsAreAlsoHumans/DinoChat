<?php
namespace App\Controllers;

use App\Core\Controller;

class ReactionController extends Controller {
    public function addReaction() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $messageId = $data['message_id'] ?? null;
        $emoji = $data['emoji'] ?? null;
        $userId = $_SESSION['user']['id'];

        if (!$messageId || !$emoji) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
            return;
        }

        $reactionModel = $this->model('Reaction');
        $reactionModel->addReaction($messageId, $userId, $emoji);

        echo json_encode(['success' => true]);
    }

    public function getReactions($messageId) {
        header('Content-Type: application/json');

        try {
            $reactionModel = $this->model('Reaction');
            $reactions = $reactionModel->getReactions($messageId);

            foreach ($reactions as &$reaction) {
                $reaction['created_at'] = date('c', strtotime($reaction['created_at']));
            }

            echo json_encode(['success' => true, 'reactions' => $reactions]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getPseudoByUserId($userId) {
        $userModel = $this->model('User');
        return $userModel->getPseudoByUserId($userId);
    }
    
}
