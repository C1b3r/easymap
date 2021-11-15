<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Controller
{
	protected $isLogin = false; //check if user login
	//If your controller dont have database operation, override in the child with false value
	public $havemodel = true;
	protected $defaultView;
	protected $form;
	protected $session;

    public function __construct() 
	{
		$this->view = new View();
		$this->session = new Session;
	}
	
	public function loadModel($name) 
	{
		$modelName = $name.'_Model';
		$this->model = new $modelName();
	}

	private function form()
	{
		return $this->form = new Form;
	}
		

	public function createForm()
	{
		$this->view->assign('startform',$this->form()->openForm("LoginForm","post",COMPLETE_WEB_PATH."admin/login",0));

	}

	protected function loadAdminView($currentView = 'error')
	{
		//Si no está logeado
		if(!$this->isLogin){
			//cargo el formulario
			$this->createForm();
			$currentView = "admin/login";
		} 
		return $this->view->display($currentView,null,true);
	}

	

	protected function error($view,$mensaje)
	{
		 $this->view->assign('message',$mensaje);
		return $this->loadAdminView($view);
	}

	public function redirect($url) 
	{
		header("Location: ".COMPLETE_WEB_PATH.$url);
		die();
	}
}