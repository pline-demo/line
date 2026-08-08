<?php

namespace App\Core;

use PDO;

final class Database
{
    private ?PDO $pdo = null;
    public function __construct(private Config $config) {}
    public function pdo(): PDO
    {
        if ($this->pdo) return $this->pdo;
        $db = $this->config->get('db');
        $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset={$db['charset']}";
        return $this->pdo = new PDO($dsn, $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
