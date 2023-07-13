<?php

use app\controllers\admincontrollers\Admin_Controller;
use app\controllers\admincontrollers\Login_Controller;
use app\controllers\admincontrollers\Logout_Controller;
use app\controllers\admincontrollers\Mapas_Controller;
use app\controllers\admincontrollers\Users_Controller;

/*use Illuminate\Http\Response;
$router->get('/home', function () use($router){
  // return (new Response('Hello World', 200))
  //               ->header('Content-Type', 'text/plain'); 

  // return $router->response("hola")->header('Content-Type', 'text/plain'); //esto no funciona porque no viene del router, viene del response
  // return "hola";
});
*/
//esto es un ejemplo, se usa el response para generar una nueva respuesta y puedes agregarle el tipo https://laravel.com/docs/5.1/responses#json-response
/*$router->get('/home', function (){
  // return ['name' => 'Abigail', 'state' => 'CA']; //esto devuelve un json directamente https://stackoverflow.com/questions/34178670/call-to-undefined-method-illuminate-http-responsejson-in-laravel5 https://stackoverflow.com/questions/40537415/how-to-return-json-response-in-laravel
  //no puedo usar el helper response() porque solo esta para laravel, tengo que importar el response y retornar ese new response
 
});
*/
/* //desde la versión 10 no se permiten funciones anónimas
 $router->name('home2')->get('/', function () {
     return 'hello world!';
 }); 
*/

// $router->middleware(['middleware' => 'sesion'])->group(['prefix'=>'admin'],function () use($router){
   // Route::auth();

     // Route::get('/home', 'HomeController@index');
     //ruta a template
//     $router->view('/',[Admin_Controller::class, 'index'])->name('home');
//     $router->get ( '/redirect/{provider}', 'SocialAuthController@redirect' );
//     $router->get ( '/callback/{provider}', 'SocialAuthController@callback' );
// });
// $router->name('hometest')->get('/test',[Mapas_Controller::class, 'informacionMapa']);

// $router->get('/pruebaMigration/{nombre}', ['app\migrations\Migration', 'ejecuta']);


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

    //Users
    $router->name('list_users')->get('/users',[Users_Controller::class, 'index']);
    $router->name('edit_user')->get('/users/edit/{id}',[Users_Controller::class, 'edit']);
    $router->name('edit_user_post')->post('/users/edit/{id}',[Users_Controller::class, 'editSubmit']);

    //Maps
    $router->name('list_maps')->get('/mapas',[Mapas_Controller::class, 'index']);
    $router->name('list_maps_page')->get('/mapas/page/{page}',[Mapas_Controller::class, 'index']);
    $router->name('edit_map')->get('/mapas/edit/{id}',[Mapas_Controller::class, 'edit']);
    $router->name('informacionMapa')->get('/informacionMapa/{id}',[Mapas_Controller::class, 'informacionMapa']);
    $router->name('puntosmapa')->get('/puntosMapa/{id}',[Mapas_Controller::class, 'puntosMapa']);
    $router->name('cargarPuntos')->post('/cargarPuntos/{id}',[Mapas_Controller::class, 'cargarPuntos']);
});
