<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Controller
{
	protected $isLogin = false; //check if user login
	//If your controller dont have database operation, override in the child with false value
	public $havemodel = true;
	protected $defaultView;
	protected $formFunction;
	protected $session;

    public function __construct($admin = false) 
	{
		$this->view = new View();
		$this->session = new Session;
		//If only wants show admin view i need to check session
		if($admin){
		  $this->isLogin = Session::checkIfLogin();
		}
	}
	
	public function loadModel($name) 
	{
		$modelName = $name.'_Model';
		$this->model = new $modelName();
	}

	protected function form()
	{
		//All controllers dont need a form, its better to declare here instead on construct(i think)
		return $this->form = new Form;
	}
		

	public function createForm($nameForm)
	{
		$this->formFunction = "form".$nameForm;
		if(!method_exists($this->model,$this->formFunction)){
			return false;
        }
		//Tendre que hacer una consulta a la tabla de configuración para rescatar el secret key para validar el formulario
		//https://www.php.net/manual/en/language.types.string.php#language.types.string.parsing.complex
		$miForm = $this->model->{$this->formFunction}();
		// print_r($this->model->getForm($nameForm));
		$this->view->assign($this->formFunction,$this->form()->makeForm($miForm));

	}

	protected function loadAdminView($currentView = 'error')
	{
		//Si no está logeado
		if(!$this->isLogin){
		
			$currentView = "login";
			if($this->createForm("Login")){ //cargo el formulario
				$this->error($currentView,"No se ha encontrado formulario");	
			}
		} 
		return $this->view->display($currentView,null,true);
	}

	

	protected function error($view,$mensaje)
	{
		 $this->view->assign('message',$mensaje);
		return $this->loadAdminView($view);
	}

	public function redirect($url ,$bckslash = true) 
	{
		// $url = (!str_ends_with($url,"/"))? $url.="/" : $url ; php 8
		if($bckslash): $url = (substr($url, -1) != '/') ? $url.="/" : $url;  endif;

		header("Location: ".COMPLETE_WEB_PATH.$url);
		die();
	}
}