<?php

namespace toubilib\infra\adapters;

use PDO;

class DatabaseConnection
{
    private static array $connections = [];
    private static array $config = [];

    public static function getConnection(string $database): PDO
    {
        if (!isset(self::$connections[$database])) {
            $config = self::$config[$database] ?? self::buildConfigFromEnv($database);
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

    private static function buildConfigFromEnv(string $database): array
    {
        $prefix = strtoupper($database);
        $host = getenv("{$prefix}_DB_HOST") ?: ($database === 'toubiprat' ? 'toubiprati.db' : $database . '.db');
        $port = (int) (getenv("{$prefix}_DB_PORT") ?: 5432);
        $name = getenv("{$prefix}_DB_NAME") ?: $database;
        $user = getenv("{$prefix}_DB_USER") ?: $database;
        $pass = getenv("{$prefix}_DB_PASS") ?: $database;

        return [
            'host' => $host,
            'port' => $port,
            'database' => $name,
            'username' => $user,
            'password' => $pass,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ];
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
