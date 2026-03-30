<?php

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {

            $config = require __DIR__ . '/../../config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$pdo = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false, // 🔥 sécurité SQL
                        PDO::ATTR_PERSISTENT => false, // 🔥 peut passer à true en prod
                    ]
                );

            } catch (PDOException $e) {

                // 🔥 debug / prod
                if (defined('APP_DEBUG') && APP_DEBUG) {
                    die('DB Error: ' . $e->getMessage());
                } else {
                    die('Erreur de connexion à la base de données');
                }
            }
        }

        return self::$pdo;
    }

    /*
    |--------------------------------------------------------------------------
    | CLOSE CONNECTION (optionnel)
    |--------------------------------------------------------------------------
    */
    public static function close(): void
    {
        self::$pdo = null;
    }
}