<?php

use app\controllers\admincontrollers\Admin_Controller;
use Illuminate\Routing\Router;
use app\controllers\Index_Controller;
use Illuminate\Http\RedirectResponse;


// $router->get('/', function () {
//     return 'hello world!';
// })->name('home');

// $router->middleware(['middleware' => 'sesion'])->group(['prefix'=>'admin'],function () use($router){
   // Route::auth();

     // Route::get('/home', 'HomeController@index');
     //ruta a template
//     $router->view('/',[Admin_Controller::class, 'index'])->name('home');
//     $router->get ( '/redirect/{provider}', 'SocialAuthController@redirect' );
//     $router->get ( '/callback/{provider}', 'SocialAuthController@callback' );
// });
// $router->prefix("admin")->group(function () use($router){
//     $router->get('/',[Admin_Controller::class, 'index'])->name('home');
// });
$router->middleware(['middleware' => 'admin'])->prefix("admin")->group(function () use($router){
    // Route::auth();

    // Route::get('/home', 'HomeController@index');
    //ruta a template
    $router->get('/',[Admin_Controller::class, 'index'])->name('home');
});