<?php
namespace app\migrations;
use app\classes\Boot;
use app\classes\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
class Migration {
    public $conexion;
    /* 
    //no puedo usar el construct si lo llamo desde el routing       
    public function __construct($migration)
     {
         $this->$migration;
     }
    */

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
        $this->conexion::schema()->create('addd', function ($table) {
            $table->integer('id_map')->primary();
            $table->string('title');
            $table->text('configuration');
            $table->dateTime('date_add');
            $table->text('description')->nullable();
        });
    }
}
