<?php
declare(strict_types=1);

namespace App\Services;

use PDO;

final class AuditLogService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function record(?int $actorUserId, string $action, string $description, ?string $subjectType = null, ?int $subjectId = null): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO audit_logs (actor_user_id, action, description, subject_type, subject_id, ip_address, user_agent) VALUES (:actor, :action, :description, :type, :subject, :ip, :agent)');
        $stmt->execute([
            ':actor' => $actorUserId,
            ':action' => $action,
            ':description' => $description,
            ':type' => $subjectType,
            ':subject' => $subjectId,
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
        ]);
    }
}
