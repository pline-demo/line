<?php
namespace App\Services;
final class ValidationService{public function contact(array $d):array{$e=[]; if(strlen(trim($d['full_name']??''))<3)$e['full_name']='Ad soyad en az 3 karakter olmalıdır.'; if(!preg_match('/^[0-9 +()\-]{8,20}$/',$d['phone']??''))$e['phone']='Geçerli bir telefon girin.'; if(($d['email']??'')&&!filter_var($d['email'],FILTER_VALIDATE_EMAIL))$e['email']='E-posta geçersiz.'; if(strlen(trim($d['message']??''))<10)$e['message']='Mesaj en az 10 karakter olmalıdır.'; return $e;}}
