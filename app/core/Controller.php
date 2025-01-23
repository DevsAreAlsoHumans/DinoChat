<?php
namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    protected function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        $modelClass = "App\\Models\\" . $model;
        return new $modelClass();
    }
}
