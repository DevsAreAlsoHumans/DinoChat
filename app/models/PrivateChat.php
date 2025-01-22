<?php
namespace App\Models;

use App\Core\Database;

class PrivateChat {
    public function getConversation($userId, $receiverId) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT pm.sender_id, pm.receiver_id, pm.content, pm.created_at, u.pseudo AS sender_pseudo
            FROM private_messages pm
            JOIN users u ON pm.sender_id = u.id
            WHERE (pm.sender_id = ? AND pm.receiver_id = ?)
               OR (pm.sender_id = ? AND pm.receiver_id = ?)
            ORDER BY pm.created_at ASC
        ");
        $stmt->execute([$userId, $receiverId, $receiverId, $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function saveMessage($senderId, $receiverId, $content) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO private_messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$senderId, $receiverId, $content]);
    }
}
