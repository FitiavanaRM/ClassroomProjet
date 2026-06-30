<?php

namespace Config;

use PDO;
use PDOException;

class Database 
{
    private static ?PDO $instance = null;

    private static string $host = 'localhost';
    private static string $dbname = 'classroom';
    private static string $user = 'root';
    private static string $pass = '';
    private static string $charset = 'utf8mb4';

    private function __construct() {
    }
    private function __clone() {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s; dbname=%s; charset=%s',
                self::$host,
                self::$dbname,
                self::$charset
            );
            try {
                self::$instance = new PDO($dsn, self::$user, self::$pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            }
            catch (PDOExeption $e) {
                throw new PDOExeption('Connexion Base de Donnée impossible :' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
