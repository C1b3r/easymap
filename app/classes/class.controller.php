<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Controller
{
	//If your controller dont have database operation, override in the child with false value
	public $havemodel = true;

    public function __construct() 
	{
		$this->view = new View();
	}
	
	public function loadModel($name) 
	{
		$modelName = $name.'_Model';
		$this->model = new $modelName();
	}

	public function redirect($url) 
	{
		header("Location: ".COMPLETE_WEB_PATH.$url);
		die();
	}
}