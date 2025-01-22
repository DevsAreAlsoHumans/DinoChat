<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {

    public function register($data) {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("INSERT INTO users (email, pseudo, password) VALUES (?, ?, ?)");
            $stmt->execute([
                $data['email'], 
                $data['pseudo'], 
                password_hash($data['password'], PASSWORD_BCRYPT)
            ]);
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new \Exception("Cette adresse email ou ce pseudo est déjà utilisé.");
            }
            throw new \Exception("Une erreur est survenue : " . $e->getMessage());
        }
    }

    public function authenticate($email, $password) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function searchUsersByName($query) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, pseudo FROM users WHERE pseudo LIKE ? LIMIT 10");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
