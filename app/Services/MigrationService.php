<?php
declare(strict_types=1);

namespace App\Services;

use PDO;
use RuntimeException;

final class MigrationService
{
    public function __construct(private PDO $pdo, private string $path)
    {
    }

    public function migrate(): array
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS migrations (migration VARCHAR(255) PRIMARY KEY, batch INT NOT NULL, executed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        $done = $this->pdo->query('SELECT migration FROM migrations')->fetchAll(PDO::FETCH_COLUMN);
        $files = glob(rtrim($this->path, '/') . '/*.sql') ?: [];
        sort($files, SORT_NATURAL);
        $batch = (int) $this->pdo->query('SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations')->fetchColumn();
        $applied = [];

        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $done, true)) {
                continue;
            }
            $sql = trim((string) file_get_contents($file));
            if ($sql === '') {
                continue;
            }
            try {
                $this->pdo->beginTransaction();
                foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
                    $this->pdo->exec($statement);
                }
                $stmt = $this->pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)');
                $stmt->execute(['migration' => $name, 'batch' => $batch]);
                $this->pdo->commit();
                $applied[] = $name;
            } catch (\Throwable $e) {
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                throw new RuntimeException('Migration failed: ' . $name, 0, $e);
            }
        }
        return $applied;
    }
}
