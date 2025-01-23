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
        $messages = $chatModel->getAllMessages();

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
}
