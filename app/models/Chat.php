<?php
namespace App\Models;

use App\Core\Database;

class Chat {
    
    public function getAllMessages($limit = 100, $offset = 0) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT messages.id, users.pseudo, messages.content, messages.created_at 
            FROM messages 
            JOIN users ON messages.user_id = users.id 
            ORDER BY messages.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return array_reverse($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }
    
        


    public function saveMessage($userId, $content) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO messages (user_id, content) VALUES (?, ?)");
        $stmt->execute([$userId, $content]);
    }
}
