<?php
namespace App\Services; use App\Core\Application;
final class MaintenanceService{public function __construct(private Application $app){} public function enabled():bool{try{$s=array_column($this->app->db()->pdo()->query('SELECT setting_value,setting_key FROM settings')->fetchAll(),'setting_value','setting_key');return ($s['maintenance_mode']??'0')==='1';}catch(\Throwable){return false;}}}
