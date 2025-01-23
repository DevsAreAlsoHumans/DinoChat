<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            $servername = "localhost";
            $dbname = "";
            $username = "";
            $password = "";

            try {
                self::$instance = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Connection failed: " . $e->getMessage());
                throw new PDOException("Une erreur est survenue lors de la connexion à la base de données.");
            }
        }

        return self::$instance;
    }
}
