<?php
namespace app\migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
class Migration {
    public $conexion;
 
    public function ejecuta($nombre)
    {
        if (method_exists($this,$nombre)) {
            $this->conexion = new Capsule;
            $this->conexion::getPDO();
            $this->conexion::connection('default');
            try {
                $this->$nombre();
            } catch (\Throwable $th) {
                echo $th." probablemente ya exista";
            }
            return "Se ejecutó la migración";
        } else {
            return "function {$nombre} not exist";
        }
    }

    public function addd()
    {
        // Ejecuta la migración 'up'
        /* lo meto dentro de una variable y declaro un nuevo capsule para esto
         Capsule::getPDO(); 
         Capsule::connection('default');
        */
        $this->conexion::schema()->create('users', function ( $table) {
            $table->bigInteger('id_user')->primary();
            $table->string('email', 100)->index('email');
            $table->string('pass');
            $table->string('name', 100);
            $table->dateTime('date_add');
            $table->dateTime('date_update');
            $table->boolean('active')->default(0);
        });
    }
}