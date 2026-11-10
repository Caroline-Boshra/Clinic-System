<?php
namespace Clinic;

use PDO;

final class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=localhost;dbname=clinic;charset=utf8mb4',  
                'root',
                '',
                
            );
        }
        return self::$pdo;
    }
}