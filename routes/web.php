<?php
use Illuminate\Routing\Router;
use app\controllers\Index_Controller;
use Illuminate\Http\RedirectResponse;

// $router->get('/', function () {
//     return 'hello world!';
// })->name('home');
$router->get('/' , [Index_Controller::class,'index'])->name('inicio');