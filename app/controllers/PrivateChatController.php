<?php
namespace App\Controllers;

use App\Core\Controller;

class PrivateChatController extends Controller {
    public function getMessages($receiverId) {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non authentifié.']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $chatModel = $this->model('PrivateChat');
        $messages = $chatModel->getConversation($userId, $receiverId);

        echo json_encode($messages);
    }

    public function sendMessage($receiverId) {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non authentifié.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $content = $data['message'] ?? '';

        if (empty($content)) {
            http_response_code(400);
            echo json_encode(['error' => 'Message vide.']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $chatModel = $this->model('PrivateChat');
        $chatModel->saveMessage($userId, $receiverId, $content);

        echo json_encode(['success' => true]);
    }

    public function searchUsers() {
        $query = $_GET['query'] ?? '';
    
        if (empty($query)) {
            http_response_code(400);
            echo json_encode(['error' => 'Query parameter is missing']);
            return;
        }
    
        $userModel = $this->model('User');
        $results = $userModel->searchUsersByName($query);
    
        header('Content-Type: application/json');
        echo json_encode($results);
    }
    
}
