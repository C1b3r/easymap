<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Model 
{
	protected $db;
	public $form = [];

	public function __construct() 
	{
		$this->db = new Connection();
    }

	protected function secure($value)
	{
		return trim(strip_tags($value));
	}
	public function prepare($sql) 
	{
		return $this->conexion->prepare($sql);//inutil hasta que herede de conection
	}

	public function select()
	{

	}

	public function selectOneRowBy($table,$by,$param)
	{
		$sql = "SELECT * FROM ".DB_PREFIX.$table." WHERE ".$by."='".$param."'";
	}

	public function __destruct()
	{
		$this->db->closeConnection();
		// echo "conexion cerrada";
	}

}