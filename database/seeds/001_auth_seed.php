<?php
declare(strict_types=1);

use PDO;

return static function (PDO $pdo): void {
    $now = date('Y-m-d H:i:s');
    $roles = ['super-admin' => 'Super Admin', 'admin' => 'Admin'];
    foreach ($roles as $slug => $name) {
        $stmt = $pdo->prepare('INSERT IGNORE INTO roles (name, slug, created_at, updated_at) VALUES (:name, :slug, :now, :now)');
        $stmt->execute(compact('name', 'slug', 'now'));
    }
    $permissions = ['dashboard.view','collections.view','collections.create','collections.edit','collections.delete','subcollections.view','subcollections.create','subcollections.edit','subcollections.delete','products.view','products.create','products.edit','products.delete','applications.view','applications.create','applications.edit','applications.delete','media.view','media.upload','media.delete','homepage.manage','store.manage','contact_requests.view','contact_requests.manage','seo.manage','menus.manage','settings.manage','admins.view','admins.create','admins.edit','admins.disable','admins.password','logs.view','system.backup','system.maintenance'];
    $insertPermission = $pdo->prepare('INSERT IGNORE INTO permissions (name, slug, created_at, updated_at) VALUES (:name, :slug, :now, :now)');
    foreach ($permissions as $permission) {
        $insertPermission->execute(['name' => $permission, 'slug' => $permission, 'now' => $now]);
    }
    $users = [
        ['username' => '@perlinaadmin', 'password' => 'perlinalog', 'super' => 0, 'role' => 'admin'],
        ['username' => 'perlinacihan', 'password' => 'cihan0691', 'super' => 1, 'role' => 'super-admin'],
    ];
    $insertUser = $pdo->prepare('INSERT IGNORE INTO users (username, password, is_active, is_super_admin, created_at, updated_at) VALUES (:username, :password, 1, :super, :now, :now)');
    foreach ($users as $user) {
        $insertUser->execute(['username' => $user['username'], 'password' => password_hash($user['password'], PASSWORD_DEFAULT), 'super' => $user['super'], 'now' => $now]);
        $uid = (int) $pdo->prepare('SELECT id FROM users WHERE username = :username')->execute(['username' => $user['username']]);
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username'); $stmt->execute(['username' => $user['username']]); $userId = (int) $stmt->fetchColumn();
        $stmt = $pdo->prepare('SELECT id FROM roles WHERE slug = :slug'); $stmt->execute(['slug' => $user['role']]); $roleId = (int) $stmt->fetchColumn();
        $pdo->prepare('INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)')->execute(['user_id' => $userId, 'role_id' => $roleId]);
    }
    $pdo->exec('INSERT IGNORE INTO role_permissions (role_id, permission_id) SELECT r.id, p.id FROM roles r CROSS JOIN permissions p WHERE r.slug = "admin"');
};
