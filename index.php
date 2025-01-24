<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Database.php';

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/ChatController.php';
require_once __DIR__ . '/app/controllers/PrivateChatController.php';
require_once __DIR__ . '/app/controllers/ReactionController.php';

// Fonction pour obtenir la partie du chemin URI
function getUriPath($uri) {
    return parse_url($uri, PHP_URL_PATH);
}

// Fonction pour envoyer une réponse JSON pour les erreurs 404
function send404() {
    http_response_code(404);
    echo json_encode(['error' => '404 - Page not found']);
    exit();
}

// Fonction pour vérifier l'authentification
function ensureAuthenticated() {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Utilisateur non authentifié']);
        exit();
    }
}

$uri = $_SERVER['REQUEST_URI'];
$path = getUriPath($uri);

// Routes
try {
    if ($path === '/' || $path === '/login') {
        $controller = new App\Controllers\UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->index();
        }
    } elseif ($path === '/register') {
        $controller = new App\Controllers\UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->registerForm();
        }
    } elseif ($path === '/chat') {
        ensureAuthenticated();
        $controller = new App\Controllers\ChatController();
        $controller->globalChat();
    } elseif ($path === '/chat/send') {
        ensureAuthenticated();
        $controller = new App\Controllers\ChatController();
        $controller->sendMessage();
    } elseif ($path === '/chat/messages') {
        ensureAuthenticated();
        $controller = new App\Controllers\ChatController();
        $controller->getMessages();
    } elseif ($path === '/chat/conversations') {
        ensureAuthenticated();
        $controller = new App\Controllers\ChatController();
        $controller->getConversations();
    } elseif (preg_match('#^/chat/private/(\d+)/messages$#', $path, $matches)) {
        ensureAuthenticated();
        $receiverId = intval($matches[1]);
        $controller = new App\Controllers\PrivateChatController();
        $controller->getMessages($receiverId);
    } elseif (preg_match('#^/chat/private/(\d+)/send$#', $path, $matches)) {
        ensureAuthenticated();
        $receiverId = intval($matches[1]);
        $controller = new App\Controllers\PrivateChatController();
        $controller->sendMessage($receiverId);
    } elseif ($path === '/chat/private/search') {
        ensureAuthenticated();
        $controller = new App\Controllers\PrivateChatController();
        $controller->searchUsers();
    } elseif ($path === '/chat/notifications') {
        ensureAuthenticated();
        $controller = new App\Controllers\ChatController();
        $controller->getNotifications();
    } elseif ($path === '/reactions/add') {
        ensureAuthenticated();
        $controller = new App\Controllers\ReactionController();
        $controller->addReaction();
    } elseif (preg_match('#^/reactions/(\d+)$#', $path, $matches)) {
        ensureAuthenticated();
        $messageId = intval($matches[1]); // Sécurise l'ID du message
        $controller = new App\Controllers\ReactionController();
        $controller->getReactions($messageId);
    } elseif (preg_match('#^/chat/private/(\d+)/mark-read$#', $path, $matches)) {
        ensureAuthenticated();
        $receiverId = intval($matches[1]);
        $controller = new App\Controllers\ChatController();
        $controller->markAsRead($receiverId);
    } else {
        send404();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    exit();
}
