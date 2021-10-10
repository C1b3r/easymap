<?php 
defined('ROOT_PATH') or exit('Direct access forbidden');


class InitController {

    public $location = [];

    public function __construct($url)
	{
		//Clean / at the end of the url if exist and create array
		$this->location = explode('/',trim($url, '/'));
	}
	public function error()
	{
		$controller = new Error_Controller();
		$controller->index();
		return false;
	}
	public function load()
	{
	
		if (empty($this->location[0]))
		{	
			$controller = new Index_Controller();
			$controller->index();
			return $this;
			//return current object
		}

		$controller_name = ucwords($this->location[0]);
		$class_name = $controller_name.'_Controller';
		
		//find controller
		$file = CONTROLLER_PATH . $class_name . '.php';
		if (!file_exists($file)) throw new MyException('Controller not found',1);
		
		$controller = new $class_name;
		$controller->loadModel($controller_name);
		// calling methods
		if (!empty($this->location[1]) && !empty($this->location[2]))
		{
			$controller_method = $this->location[1];
			$controller_options = $this->location[2];
			
			if (method_exists($controller, $controller_method)) 
			{
				$controller->{$controller_method}($controller_options);
			} 
			else throw new MyException('Controller method not found',1);
		} 
		else 
		{
			if (!empty($this->location[1]))
			{
				$method_option = $this->location[1];
				if (method_exists($controller, $method_option)) 
				{
					$controller->{$method_option}();
				}
				else 
				{
					$controller->index($method_option);
				}
			}
			else 
			{
				$controller->index();
			}
		}
	}
}