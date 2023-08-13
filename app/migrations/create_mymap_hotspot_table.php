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
        $this->conexion::schema()->create('hotspot', function ( $table) {
            $table->integer('id_hotspot')->primary();
            $table->integer('id_map');
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->integer('id_image')->nullable();
            $table->integer('id_spot');
            $table->string('information', 500);
            
            $table->foreign('id_image', 'map_image')->references('id_image')->on('images')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_spot', 'map_spot')->references('id_spot')->on('spot')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_map', 'hotspot')->references('id_map')->on('map')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
