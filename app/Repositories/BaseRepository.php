<?php
namespace App\Repositories;
use App\Core\Application; use PDO;
abstract class BaseRepository { protected PDO $pdo; public function __construct(Application $app){$this->pdo=$app->db()->pdo();} protected function rows(string $sql,array $p=[]):array{$s=$this->pdo->prepare($sql);$s->execute($p);return $s->fetchAll();} protected function row(string $sql,array $p=[]):?array{$s=$this->pdo->prepare($sql);$s->execute($p);$r=$s->fetch();return $r?:null;} protected function exec(string $sql,array $p=[]):bool{$s=$this->pdo->prepare($sql);return $s->execute($p);} }
