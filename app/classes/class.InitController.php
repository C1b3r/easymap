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
		$controller->index("Controlador no encontrado",404);
		return false;
	}
	public function load()
	{
		$indexAdmin = 0;
	
		if (empty($this->location[$indexAdmin]))
		{	
			$controller = new Index_Controller();
			$controller->index();
			return $this;
			//return current object
		}

		if(ucwords($this->location[$indexAdmin]) === ucwords(ADMIN_FOLDER)){
			if(!Session::checkIfLogin()){
				$controller = new Login_Controller();
				$controller->index();
				return $this;
		
			}
			//Comprobamos si en /admin/ esta vacio para cargar la vista principal de administrador
			if(empty($this->location[$indexAdmin+1])){

				$controller = new Admin_Controller();
				
				// if(empty($controller->model)){
				$controller->loadModel(ucwords($this->location[$indexAdmin])); //controller_name
				// };
				$controller->index();
				return $this;
			}
			//Cargamos ahora los controladores del admin para que sea /admin/controlador
			$indexAdmin = 1;
			$controller_name = ucwords($this->location[$indexAdmin]);
			$class_name = $controller_name.'_Controller';
			$file = CONTROLLER_ADMIN_PATH . $class_name . '.php';
			
		}else{
			$controller_name = ucwords($this->location[$indexAdmin]);
			$class_name = $controller_name.'_Controller';
			$file = CONTROLLER_PATH . $class_name . '.php';
		}
		
		
		//find controller
		if (!file_exists($file)) throw new MyException('Controller load not found',__FUNCTION__,0);
		
		$controller = new $class_name;

		if($controller->havemodel){
			$controller->loadModel($controller_name);
		}
		
		// calling methods
		if (!empty($this->location[$indexAdmin+1]) && !empty($this->location[$indexAdmin+2]))
		{
			$controller_method = $this->location[$indexAdmin+1];
			$controller_options = $this->location[$indexAdmin+2];
			
			if (method_exists($controller, $controller_method)) 
			{
				$controller->{$controller_method}($controller_options);
			} 
			else throw new MyException('Controller method not found',__FUNCTION__,0);
		} 
		else 
		{
			if (!empty($this->location[$indexAdmin+1]))
			{
				$method_option = $this->location[$indexAdmin+1];
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