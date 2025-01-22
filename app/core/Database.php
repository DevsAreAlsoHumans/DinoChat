<?php
namespace App\Core;

use PDO;

class Database {

    // Instance unique de la connexion PDO
    private static $instance;

    // Retourne l'instance PDO unique, connexion à la base de données
    public static function getInstance() {
    }
}
