<?php 
use Illuminate\Database\Capsule\Manager as Capsule;
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
 $capsule = new Capsule;
 $capsule->addConnection([
   'driver' => 'mysql',
   'host' => DB_HOST,
   'database' => DB_NAME,
   'username' => DB_USER,
   'password' => DB_PASS,
   'charset' => DB_CHARSET,
   'collation' => DB_COLLATION,
   'prefix' => DB_PREFIX,
]);

//De manera natural tendrá el default que es la anterior, en esta es un ejemplo con sql server
// $capsule->addConnection([
//     'driver' => 'sqlsrv',
//     'host' => DB_HOST,
//     'database' => DB_NAME,
//     'username' => DB_USER,
//     'password' => DB_PASS,
//     'charset' => utf8,
//     'prefix' => DB_PREFIX,
//  ],'otraconexion');
//Declaro el setAsGlobal para poder usar el connection y ese tipo de funciones que si no, no me funcionaria
//https://stackoverflow.com/questions/51225318/why-does-capsule-in-eloquent-require-setasglobal-method-in-slim

// $capsule->setEventDispatcher(new Dispatcher(new Container)); //no lo consigo hacer funcionar
$capsule->setAsGlobal();
$capsule->bootEloquent();

