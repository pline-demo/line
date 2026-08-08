<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Session;
use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private UserRepository $users)
    {
    }

    public function attempt(string $identity, string $password): bool
    {
        $user = $this->users->findByIdentity($identity);

        if ($user === null || !(bool) $user['is_active']) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        session_regenerate_id(true);
        Session::put('auth.user_id', (int) $user['id']);
        $this->users->markLoggedIn((int) $user['id']);

        return true;
    }

    public function logout(): void
    {
        Session::forget('auth.user_id');
        session_regenerate_id(true);
    }
}
