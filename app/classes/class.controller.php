<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Controller{

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