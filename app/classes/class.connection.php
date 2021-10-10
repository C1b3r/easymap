<?php 
defined('ROOT_PATH') or exit('Direct access forbidden');

class Connection{
    public $conexion;
    protected $registros;
    
    public function __construct()
    {
      $this->openConnection();
    }
    public function openConnection(){

        try {
            $this->conexion = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS);
              // set the PDO error mode to exception
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //  echo "Connected successfully";
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
        return $this->conexion;   
           
    }
   
    public function closeConnection(){
        $this->conexion = null;
    }

}


