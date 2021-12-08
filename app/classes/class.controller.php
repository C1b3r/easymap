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
		$this->view->assign($nameForm,$this->form()->renderForm($nameForm));
	}

	protected function loadAdminView($currentView = 'error')
	{
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
		if($bckslash): $url = (substr($url, -1) != '/') ? $url.="/" : $url;  endif;

		header("Location: ".COMPLETE_WEB_PATH.$url);
		die();
	}
}