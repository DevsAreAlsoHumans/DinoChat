<?php
namespace App\Models;

use App\Core\Database;

class Chat {
    
    public function getAllMessages() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT users.pseudo, messages.content, messages.created_at 
            FROM messages 
            JOIN users ON messages.user_id = users.id 
            ORDER BY messages.created_at ASC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function saveMessage($userId, $content) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO messages (user_id, content) VALUES (?, ?)");
        $stmt->execute([$userId, $content]);
    }
}
