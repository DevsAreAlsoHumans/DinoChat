<?php
session_start();

require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Database.php';

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/ChatController.php';
require_once __DIR__ . '/app/controllers/PrivateChatController.php';

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

// Routes principales
// define('ROUTES', [
//     '/' => 'UserController@index',
//     '/login' => 'UserController@login',
//     '/register' => 'UserController@registerForm',
//     '/chat' => 'ChatController@globalChat',
//     '/chat/send' => 'ChatController@sendMessage',
//     '/chat/messages' => 'ChatController@getMessages',
//     '/chat/private/search' => 'PrivateChatController@searchUsers',
// ]);

// Gestion des routes dynamiques pour le chat privé
// Exemple : /chat/private/{id}/messages ou /chat/private/{id}/send
