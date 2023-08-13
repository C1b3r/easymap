<?php
/* Routing */
use app\routing\Request;
use app\routing\Response;
use app\routing\Router;

/* Controllers zone */
use app\controllers\Index_Controller;
use app\controllers\admincontrollers\Admin_Controller;
use app\controllers\admincontrollers\Login_Controller;

$router = $this->router;
// $router = new Router(new Request(), new Response());
// $app->router->get('/', [SiteController::class, 'home']);
$router->get('/',[Index_Controller::class, 'index'])->name('inicio');
$router->get('/login',[Login_Controller::class, 'index'])->name('login');
$router->post('/login',[Login_Controller::class, 'index'])->name('submitLogin');
$router->group(ADMIN_FOLDER,function() use($router){
    $router->get('/',[Admin_Controller::class, 'index'])->name('login');
    $router->get('prueba',[Index_Controller::class, 'index'])->name('prueba');
    $router->get('prueba2',[Index_Controller::class, 'index']);
});

// $router->middleware('adminlogin');