<?php
namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller {

    public function index() {
        $this->view('user/login');
    }

    public function registerForm() {
        $this->view('user/register');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if (empty($email) || empty($password)) {
                echo "<div style='color: red; text-align: center;'>Veuillez remplir tous les champs.</div>";
                $this->view('user/login');
                return;
            }

            $userModel = $this->model('User');
            $user = $userModel->authenticate($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                header('Location: /chat');
                exit();
            } else {
                echo "<div style='color: red; text-align: center;'>Email ou mot de passe incorrect.</div>";
            }
        }

        $this->view('user/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $pseudo = $_POST['pseudo'] ?? null;
            $password = $_POST['password'] ?? null;

            if (empty($email) || empty($pseudo) || empty($password)) {
                echo "<div style='color: red; text-align: center;'>Tous les champs sont requis.</div>";
                $this->view('user/register');
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div style='color: red; text-align: center;'>Adresse e-mail invalide.</div>";
                $this->view('user/register');
                return;
            }

            $userModel = $this->model('User');
            try {
                $userModel->register([
                    'email' => $email,
                    'pseudo' => $pseudo,
                    'password' => $password,
                ]);

                header('Location: /login');
                exit();
            } catch (\Exception $e) {
                echo "<div style='color: red; text-align: center;'>{$e->getMessage()}</div>";
            }
        }

        $this->view('user/register');
    }
}
