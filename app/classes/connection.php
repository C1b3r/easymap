<?php 
namespace app\classes;
defined('ROOT_PATH') or exit('Direct access forbidden');
use Illuminate\Database\Capsule\Manager as Capsule;
class Connection{
    public $conexion;
    protected $registros;
    
    public function __construct()
    {
      $this->openConnection();
    }
    public function openConnection(){

        try {
          //Probamos a intentar una conexión, si no puede hacer este método, no funcionará
          Capsule::getPDO();
          $this->conexion = Capsule::connection('default');
            // $this->conexion = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);
              // set the PDO error mode to exception
            // $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //  echo "Connected successfully";
          } catch(\PDOException $e) {
            new MyException("Connection failed: ". $e->getMessage(),basename($e->getFile()),1);
          }
        return $this->conexion;   
           
    }
   
    public function closeConnection(){
        $this->conexion = null;
    }

}


