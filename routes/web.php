<?php
use App\Controllers\{PublicController,AdminController};
$admin='/' . $app->config()->get('admin_path');
$app->router->get('/', [PublicController::class,'home']);
$app->router->get('/koleksiyonlar',[PublicController::class,'collections']);
$app->router->get('/koleksiyon/{slug}',[PublicController::class,'collection']);
$app->router->get('/urunler',[PublicController::class,'products']);
$app->router->get('/urun/{slug}',[PublicController::class,'product']);
$app->router->get('/uygulamalarimiz',[PublicController::class,'applications']);
$app->router->get('/uygulama/{slug}',[PublicController::class,'application']);
$app->router->get('/magazamiz',[PublicController::class,'store']);
$app->router->get('/iletisim',[PublicController::class,'contact']);
$app->router->post('/iletisim',[PublicController::class,'submitContact']);
$app->router->get('/teklif-al',[PublicController::class,'contact']);
$app->router->get('/whatsapp',[PublicController::class,'whatsapp']);
$app->router->get($admin.'/login',[AdminController::class,'login']);
$app->router->post($admin.'/login',[AdminController::class,'authenticate']);
$app->router->get($admin.'/logout',[AdminController::class,'logout']);
$app->router->get($admin,[AdminController::class,'dashboard']);
foreach(['homepage','collections','subcollections','products','applications','gallery','media','store','contacts','seo','menus','settings','users','roles','permissions','logs','backup','maintenance'] as $m){$app->router->get($admin.'/'.$m,[AdminController::class,'module']);}
