<?php
namespace App\Controllers;

use App\Core\Controller;

class ChatController extends Controller {

    public function globalChat() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
        $this->view('chat/global');
    }

    public function getMessages() {
        $chatModel = $this->model('Chat');
        $messages = $chatModel->getAllMessages(100, 0);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $message = $data['message'] ?? null;
            $userId = $_SESSION['user']['id'] ?? null;

            if ($message && $userId) {
                $chatModel = $this->model('Chat');
                $chatModel->saveMessage($userId, $message);

                echo json_encode(['success' => true]);
                return;
            }

            echo json_encode(['success' => false, 'error' => 'Message invalide ou utilisateur non authentifié.']);
        }
    }

    public function getConversations() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non authentifié.']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $chatModel = $this->model('PrivateChat');
        $conversations = $chatModel->getConversations($userId);

        header('Content-Type: application/json');
        echo json_encode($conversations);
    }

    public function getNotifications() {
        if (!isset($_SESSION['user'])) {
            error_log("Session utilisateur non détectée.");
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non authentifié.']);
            return;
        }
        try {
            $userId = $_SESSION['user']['id'];
            $chatModel = $this->model('PrivateChat');
            $notifications = $chatModel->getUnreadMessages($userId);
    
            header('Content-Type: application/json');
            echo json_encode($notifications);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur serveur: ' . $e->getMessage()]);
        }
    }
    
    public function markAsRead($receiverId) {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non authentifié.']);
            return;
        }
    
        try {
            $userId = $_SESSION['user']['id'];
            $chatModel = $this->model('PrivateChat');
            $chatModel->markMessagesAsRead($userId, $receiverId);
    
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
        }
    }
    
    
}
