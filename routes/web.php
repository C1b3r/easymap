<?php
/* Routing */
use app\routing\Request;
use app\routing\Response;
use app\routing\Router;

/* Controllers zone */
use app\controllers\Index_Controller;
use app\controllers\admincontrollers\Admin_Controller;

$router = $this->router;
// $router = new Router(new Request(), new Response());
// $app->router->get('/', [SiteController::class, 'home']);
$router->get('/',[Index_Controller::class, 'index'],'porciono')->name('inicio');
$router->group(
    
);
$router->get(ADMIN_FOLDER,[Admin_Controller::class, 'index'])->name('login');
// $router->middleware('adminlogin');