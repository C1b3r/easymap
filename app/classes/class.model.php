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

	public function getForm($nameForm)
    {
        /* get_class($this) i want to get the name of class dinamically and execute later with this
        call_user_func_array(array($this->object,'method'), array($arg1, $arg2));  
        */
        call_user_func(array(get_class($this),"form".$nameForm));
       return $this->form[$nameForm];
    }
	
	public function __destruct()
	{
		$this->db->closeConnection();
		// echo "conexion cerrada";
	}

}