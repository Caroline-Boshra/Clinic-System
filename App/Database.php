<?php

namespace App;
use PDO;

class Database
{
    private PDO $connection;

    private static ?Database $instance = null;

    private function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";

        $this->connection = new PDO(
            $dsn,
            $config['username'],
            $config['password']
        );
    }

    public static function getInstance(array $config):Database
    {
        if (self::$instance === null) {
            self::$instance = new Database($config);
        }

        return self::$instance;
    }
    public function getConnection(): PDO
{
    return $this->connection;
}
}