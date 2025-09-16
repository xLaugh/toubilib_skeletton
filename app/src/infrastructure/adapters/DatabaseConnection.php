<?php

namespace toubilib\infra\adapters;

use PDO;

class DatabaseConnection
{
    private static array $connections = [];
    private static array $config;

    public static function init(array $config): void
    {
        self::$config = $config;
    }

    public static function getConnection(string $database): PDO
    {
        if (!isset(self::$connections[$database])) {
            if (!isset(self::$config[$database])) {
                throw new \InvalidArgumentException("Configuration for database '{$database}' not found");
            }

            $config = self::$config[$database];
            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
            
            self::$connections[$database] = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options']
            );
        }

        return self::$connections[$database];
    }

    public static function closeConnection(string $database): void
    {
        if (isset(self::$connections[$database])) {
            self::$connections[$database] = null;
            unset(self::$connections[$database]);
        }
    }

    public static function closeAllConnections(): void
    {
        foreach (self::$connections as $database => $connection) {
            self::closeConnection($database);
        }
    }
}
