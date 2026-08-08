<?php
return static function (PDO $pdo): void {
    $now = date('Y-m-d H:i:s');
    $roles = [['Super Admin','super-admin'], ['Admin','admin']];
    foreach ($roles as [$name, $slug]) {
        $pdo->prepare('INSERT IGNORE INTO roles (name, slug, created_at, updated_at) VALUES (?, ?, ?, ?)')->execute([$name,$slug,$now,$now]);
    }
    $permissions = ['dashboard.view','collections.view','collections.create','collections.edit','collections.delete','subcollections.view','subcollections.create','subcollections.edit','subcollections.delete','products.view','products.create','products.edit','products.delete','applications.view','applications.create','applications.edit','applications.delete','media.view','media.upload','media.delete','homepage.manage','store.manage','contact_requests.view','contact_requests.manage','seo.manage','menus.manage','settings.manage','admins.view','admins.create','admins.edit','admins.disable','admins.password','logs.view','system.backup','system.maintenance'];
    $stmt = $pdo->prepare('INSERT IGNORE INTO permissions (name, slug, created_at, updated_at) VALUES (?, ?, ?, ?)');
    foreach ($permissions as $permission) { $stmt->execute([$permission, $permission, $now, $now]); }
    $users = [
        ['@perlinaadmin', null, 'perlinalog', 0, 'admin'],
        ['perlinacihan', null, 'cihan0691', 1, 'super-admin'],
    ];
    $roleId = $pdo->prepare('SELECT id FROM roles WHERE slug = ?');
    $userInsert = $pdo->prepare('INSERT IGNORE INTO users (username,email,password,is_active,is_super_admin,created_at,updated_at) VALUES (?, ?, ?, 1, ?, ?, ?)');
    $userId = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $assign = $pdo->prepare('INSERT IGNORE INTO user_roles (user_id,role_id) VALUES (?,?)');
    foreach ($users as [$username,$email,$password,$super,$role]) {
        $userInsert->execute([$username,$email,password_hash($password,PASSWORD_DEFAULT),$super,$now,$now]);
        $userId->execute([$username]); $uid=(int)$userId->fetchColumn();
        $roleId->execute([$role]); $rid=(int)$roleId->fetchColumn();
        $assign->execute([$uid,$rid]);
    }
};
