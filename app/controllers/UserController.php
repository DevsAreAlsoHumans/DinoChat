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
                $_SESSION['register_error'] = 'Tous les champs sont requis.';
                header('Location: /register');
                exit();
            }
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['register_error'] = 'Adresse e-mail invalide.';
                header('Location: /register');
                exit();
            }
    
            $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/';
            if (!preg_match($passwordRegex, $password)) {
                $_SESSION['register_error'] = 'Le mot de passe doit contenir au moins : 12 caractères, une majuscule, une minuscule, un chiffre, un caractère spécial.';
                header('Location: /register');
                exit();
            }

            try {
                $userModel = $this->model('User');
                $userModel->register([
                    'email' => $email,
                    'pseudo' => $pseudo,
                    'password' => $password,
                ]);
    
                $_SESSION['success_message'] = 'Inscription réussie. Connectez-vous !';
                header('Location: /login');
                exit();
            } catch (\Exception $e) {
                $_SESSION['register_error'] = $e->getMessage();
                header('Location: /register');
                exit();
            }
        }
    
        $this->view('user/register');
    }
    
    
}
