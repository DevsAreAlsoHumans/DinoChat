<?php

use App\Controllers\UserController;
use App\Controllers\ChatController;

return function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'App\\Controllers\\UserController@index');
    $r->addRoute('GET', '/user/login', 'App\\Controllers\\UserController@index');
    $r->addRoute('POST', '/user/login', 'App\\Controllers\\UserController@login');
    $r->addRoute('GET', '/user/register', 'App\\Controllers\\UserController@register');
    $r->addRoute('POST', '/user/register', 'App\\Controllers\\UserController@register');

    $r->addRoute('GET', '/chat/global', 'App\\Controllers\\ChatController@globalChat');
};
