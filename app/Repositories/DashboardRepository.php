<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
final class DashboardRepository{public function stats():array{$db=Database::connection();$tables=['products','collections','subcollections','media','applications','contact_requests'];$out=[];foreach($tables as $table){$out[$table]=(int)$db->query('SELECT COUNT(*) FROM '.$table)->fetchColumn();} $out['active_products']=(int)$db->query("SELECT COUNT(*) FROM products WHERE status='active'")->fetchColumn();return $out;} public function recentActivity():array{$s=Database::connection()->query('SELECT action,description,created_at FROM audit_logs ORDER BY id DESC LIMIT 8');return $s->fetchAll();}}