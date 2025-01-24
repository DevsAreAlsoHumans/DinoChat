<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Reaction {
    public function addReaction($messageId, $userId, $emoji) {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("SELECT COUNT(*) FROM reactions WHERE message_id = ? AND user_id = ? AND emoji = ?");
            $stmt->execute([$messageId, $userId, $emoji]);
            $reactionExists = $stmt->fetchColumn();

            if ($reactionExists > 0) {
                return;
            }

            $stmt = $db->prepare("INSERT INTO reactions (message_id, user_id, emoji, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$messageId, $userId, $emoji]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la réaction : " . $e->getMessage());
            throw new \Exception("Erreur lors de l'ajout de la réaction.");
        }
    }

    public function getReactions($messageId) {
        $db = Database::getInstance();

        try {
            $stmt = $db->prepare("
                SELECT user_id, emoji, created_at
                FROM reactions
                WHERE message_id = ?
            ");
            $stmt->execute([$messageId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réactions : " . $e->getMessage());
            throw new \Exception("Erreur lors de la récupération des réactions.");
        }
    }
}
