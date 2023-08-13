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
        $this->conexion::schema()->create('token', function ($table) {
            $table->bigInteger('id_token')->primary();
            $table->bigInteger('id_user');
            $table->string('token', 200)->index('token');
            $table->string('validation_token', 200)->nullable();
            $table->dateTime('date_exp')->comment("token expiration date");
            $table->boolean('active')->default(0);
            $table->tinyInteger('type');
            
            $table->foreign('id_user', 'user_token')->references('id_user')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}