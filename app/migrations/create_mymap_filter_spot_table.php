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
        $this->conexion::schema()->create('filter_spot', function ( $table) {
            $table->integer('id_filter');
            $table->integer('id_hotspot');
            
            $table->foreign('id_filter', 'filter')->references('id_filter')->on('filter')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_hotspot', 'spot')->references('id_hotspot')->on('hotspot')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
