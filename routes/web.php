<?php
use Illuminate\Routing\Router;
use app\controllers\Index_Controller;
use Illuminate\Http\RedirectResponse;

// $router->get('/', function () {
//     return 'hello world!';
// })->name('home');
$router->name('inicio')->get('/' , [Index_Controller::class,'index']);