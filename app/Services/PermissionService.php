<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use RuntimeException;

final class PermissionService
{
    public function __construct(private UserRepository $users)
    {
    }

    public function allows(int $userId, string $permission): bool
    {
        $user = $this->users->findById($userId);
        if ($user === null || !(bool) $user['is_active']) return false;
        if ((bool) $user['is_super_admin']) return true;
        return $this->users->hasPermission($userId, $permission);
    }

    public function require(int $userId, string $permission): void
    {
        if (!$this->allows($userId, $permission)) {
            throw new RuntimeException('Forbidden', 403);
        }
    }
}
