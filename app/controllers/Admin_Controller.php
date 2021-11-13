<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Admin_Controller extends Controller 
{
	private $isLogin = false; //check if user login
	private $defaultView = 'admin/login';

	public function __construct() 
	{
		parent::__construct(); //to create view
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
		$this->isLogin = $this->checkIfLogin();

	}

    public function index() 
	{
		
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','')
				   ->assign('current_page','Visión general');
		if($this->isLogin)
		{
			$maps = $this->model->getMap(2);

			if($maps){
				$this->view->assign('maps', $maps);
			}

		}
		$this->loadAdminView('admin/mainAdmin');   
	}
    public function checkIfLogin()
    {//test cookie in future
        if(!isset($_SESSION['admin'])){
			return false;
		}else{

			return true;
		}
    }
	
	protected function loadAdminView($currentView = 'admin/login')
	{
		//Si no está logeado
		if(!$this->isLogin){
			$currentView = $this->defaultView;
		}
		return $this->view->display($currentView,null,true);
	}

	// private function dashboard($boolean = false)
	// {
	// 	if($boolean){
	// 		$maps = $this->model->getMap(2);
	// 		if($maps){
	// 			$this->view->assign('maps', $maps);
	// 		}
			
	// 		return $this->view->display('admin/mainAdmin',null,true);
	// 	}else{
	// 		return $this->view->display('admin/login', '' ,true);
	// 	}
	// }

	public function login()
	{
		if(!isset($_POST['submit']))
		{
			 $this->index();  
		}else{
			if(empty($_POST['email']) || empty($_POST['pass']))
			{
				$this->error();
			}
			if($this->model->logUser($_POST['email'],$_POST['pass']))
			{
				$this->view->assign('email', $this->model->username);
				//Cargará el index
				$this->redirect('admin');
			}else{
				$this->error();
			}
		}
		
	}


	private function error()
	{
		return $this->view->assign('message','Error')
		->display('admin/login',null,true);
	}

	public function mapas()
	{
		$this->loadAdminView('admin/mapsAdmin');
	}
}