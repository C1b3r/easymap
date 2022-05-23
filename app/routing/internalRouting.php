<?php

use app\controllers\admincontrollers\Admin_Controller;
use app\controllers\admincontrollers\Login_Controller;
use app\controllers\admincontrollers\Logout_Controller;
use app\controllers\admincontrollers\Mapas_Controller;
use app\controllers\admincontrollers\Users_Controller;

// $router->name('home2')->get('/', function () {
//     return 'hello world!';
// });

// $router->middleware(['middleware' => 'sesion'])->group(['prefix'=>'admin'],function () use($router){
   // Route::auth();

     // Route::get('/home', 'HomeController@index');
     //ruta a template
//     $router->view('/',[Admin_Controller::class, 'index'])->name('home');
//     $router->get ( '/redirect/{provider}', 'SocialAuthController@redirect' );
//     $router->get ( '/callback/{provider}', 'SocialAuthController@callback' );
// });
$router->prefix(ADMIN_FOLDER)->group(function () use($router){
  $router->name('login')->get('/login',[Login_Controller::class, 'index']);
  $router->name('loginpost')->post('/login',[Login_Controller::class, 'login']);
});
//Necesito definirlo al principio porque si no en el action de easymap\vendor\illuminate\routing\RouteCollection.php addLookups no aparece

$router->middleware(['middleware' => 'admin'])->prefix(ADMIN_FOLDER)->group(function () use($router){
    // Route::auth();

    // Route::get('/home', 'HomeController@index');
    //ruta a template
    $router->name('logout')->get('/logout',[Logout_Controller::class,'index']);
    $router->name('Adminhome')->get('/',[Admin_Controller::class, 'index']);
    $router->name('list_users')->get('/users',[Users_Controller::class, 'index']);
    $router->name('list_maps')->get('/mapas/{page?}',[Mapas_Controller::class, 'index']);
});