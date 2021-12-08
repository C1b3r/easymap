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
	const FLASH_ERROR = 'danger';
	const FLASH_WARNING = 'warning';
	const FLASH_INFO = 'info';
	const FLASH_SUCCESS = 'success';

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
		// $this->formFunction = "form".$nameForm;
		// if(!method_exists($this->model,$this->formFunction)){
		// 	return false;
        // }
		//Tendre que hacer una consulta a la tabla de configuración para rescatar el secret key para validar el formulario
		//https://www.php.net/manual/en/language.types.string.php#language.types.string.parsing.complex
		// $miForm = $this->model->{$this->formFunction}(); //escapamos el nombre de la función para llamarla de manera dinámica
		// print_r($this->model->getForm($nameForm));
		$this->view->assign($nameForm,$this->form()->renderForm($nameForm));

	}

	protected function loadAdminView($currentView = 'error')
	{
		//Si no está logeado
		if(!$this->isLogin){
		
			$currentView = "login";
			if($this->createForm("formLogin")){ //cargo el formulario
				$this->error($currentView,self::FLASH_ERROR,'message',"No se ha encontrado formulario");	
			}
		} 
		return $this->view->display($currentView,null,true);
	}

	

	protected function error($view,$format, $type, $mensaje)
	{
		if($type == "flash"){
			Helper::setFlash("danger","formulario",$mensaje);
		}else{
			$this->view->assign('message',array('type'=> $format, 'mensaje'=>$mensaje));
		}
		
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