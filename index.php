<?php
session_start();

require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Database.php';

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/ChatController.php';
require_once __DIR__ . '/app/controllers/PrivateChatController.php';

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

// Routes
if ($uri === '/' || $uri === '/login') {
    $controller = new App\Controllers\UserController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    } else {
        $controller->index();
    }
} elseif ($uri === '/register') {
    $controller = new App\Controllers\UserController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->registerForm();
    }
} elseif ($uri === '/chat') {
    $controller = new App\Controllers\ChatController();
    $controller->globalChat();
} elseif ($uri === '/chat/send') {
    $controller = new App\Controllers\ChatController();
    $controller->sendMessage();
} elseif ($uri === '/chat/messages') {
    $controller = new App\Controllers\ChatController();
    $controller->getMessages();
} elseif (preg_match('#^/chat/private/(\d+)/messages$#', $uri, $matches)) {
    $receiverId = $matches[1];
    $controller = new App\Controllers\PrivateChatController();
    $controller->getMessages($receiverId);
} elseif (preg_match('#^/chat/private/(\d+)/send$#', $uri, $matches)) {
    $receiverId = $matches[1];
    $controller = new App\Controllers\PrivateChatController();
    $controller->sendMessage($receiverId);
} elseif ($uri === '/chat/private/search') {
    $controller = new App\Controllers\PrivateChatController();
    $controller->searchUsers();
} else {
    http_response_code(404);
    echo "404 - Page not found.";
}
