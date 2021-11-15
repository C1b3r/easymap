<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Admin_Controller extends Controller 
{
	
	protected $defaultView = 'admin/mainAdmin';

	public function __construct() 
	{
		parent::__construct(); //to create view
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
		$this->isLogin = Session::checkIfLogin();
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
}