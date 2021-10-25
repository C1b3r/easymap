<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Admin_Controller extends Controller 
{
	public function __construct() 
	{
		parent::__construct(); //to create view
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
	}

    public function index() 
	{
		
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','');
		$this->checkIfLogin();		   
	}
    public function checkIfLogin()
    {
        if(!isset($_SESSION['admin'])){
			return $this->view->display('admin/login', '' ,true);
		}else{
			return $this->view->display('admin/mainAdmin',null,true);
		}
    }

	public function login()
	{
		if(!isset($_POST['submit']))
		{
			$this->checkIfLogin();
			
		}else{
			if(empty($_POST['email']) || empty($_POST['pass']))
			{
				$this->error();
			}
			if($this->model->logUser($_POST['email'],$_POST['pass']))
			{
				// $this->checkIfLogin();
				$this->redirect('admin');
			}else{
				$this->error();
			}
		}
		
	}


	private function error()
	{
		return $this->view->assign('message','Error')
		->display('admin/login');
	}
}