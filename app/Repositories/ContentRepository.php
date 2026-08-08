<?php
namespace App\Repositories;
final class ContentRepository extends BaseRepository{
 public function settings():array{return array_column($this->rows('SELECT setting_value, setting_key FROM settings'),'setting_value','setting_key');}
 public function store():array{return $this->row('SELECT * FROM store LIMIT 1')??[];}
 public function menu(string $loc):array{return $this->rows('SELECT mi.* FROM menu_items mi JOIN menus m ON m.id=mi.menu_id WHERE m.location=? AND mi.status="active" ORDER BY mi.sort_order,id',[$loc]);}
 public function sections():array{return $this->rows('SELECT * FROM homepage_sections WHERE status="active" ORDER BY sort_order,id');}
 public function collections(bool $featured=false):array{return $this->rows('SELECT * FROM collections WHERE status="active"'.($featured?' AND featured=1':'').' ORDER BY sort_order,id');}
 public function collection(string $slug):?array{return $this->row('SELECT * FROM collections WHERE slug=? AND status="active"',[$slug]);}
 public function subcollections(?int $collectionId=null,bool $featured=false):array{$sql='SELECT s.*, c.name collection_name, c.slug collection_slug FROM subcollections s JOIN collections c ON c.id=s.collection_id WHERE s.status="active"';$p=[]; if($collectionId){$sql.=' AND s.collection_id=?';$p[]=$collectionId;} if($featured){$sql.=' AND s.featured=1';}$sql.=' ORDER BY s.sort_order,s.id';return $this->rows($sql,$p);}
 public function products(bool $featured=false):array{return $this->rows('SELECT p.*, c.name collection_name,c.slug collection_slug,s.name subcollection_name FROM products p JOIN collections c ON c.id=p.collection_id LEFT JOIN subcollections s ON s.id=p.subcollection_id WHERE p.status="active"'.($featured?' AND p.featured=1':'').' ORDER BY p.sort_order,p.id');}
 public function product(string $slug):?array{return $this->row('SELECT p.*, c.name collection_name,c.slug collection_slug FROM products p JOIN collections c ON c.id=p.collection_id WHERE p.slug=? AND p.status="active"',[$slug]);}
 public function productImages(int $id):array{return $this->rows('SELECT * FROM product_images WHERE product_id=? ORDER BY sort_order,id',[$id]);}
 public function applications(bool $featured=false):array{return $this->rows('SELECT * FROM applications WHERE status="active"'.($featured?' AND featured=1':'').' ORDER BY sort_order,id');}
 public function application(string $slug):?array{return $this->row('SELECT * FROM applications WHERE slug=? AND status="active"',[$slug]);}
 public function saveContact(array $d):void{$this->exec('INSERT INTO contact_requests(full_name,phone,email,subject,message,related_type,related_id,status,created_at) VALUES(?,?,?,?,?,?,?,"new",NOW())',[$d['full_name'],$d['phone'],$d['email'],$d['subject'],$d['message'],$d['related_type']??null,$d['related_id']??null]);}
 public function logWhatsapp(string $context,string $message):void{$this->exec('INSERT INTO whatsapp_logs(context,message,ip,user_agent,created_at) VALUES(?,?,?,?,NOW())',[$context,$message,$_SERVER['REMOTE_ADDR']??'',$_SERVER['HTTP_USER_AGENT']??'']);}
}
