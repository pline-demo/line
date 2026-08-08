<?php
namespace App\Services; use App\Core\Session;
final class CsrfService{public static function token():string{if(!Session::get('_csrf')) Session::put('_csrf',bin2hex(random_bytes(32))); return Session::get('_csrf');} public static function verify(?string $t):bool{return is_string($t)&&hash_equals((string)Session::get('_csrf'),$t);} }
