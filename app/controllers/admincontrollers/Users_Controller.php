<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Users_Controller extends Controller 
{
	protected $defaultView = 'usersAdmin';
	protected $currentTitle = 'Listado de usuarios';
	protected $currentPage = 'users';

	public function __construct() 
	{
		parent::__construct(true); //to create view
		//assing allways the same robots(you can overwrite in assign function)
		$this->view->assign('robots','noindex, nofollow')
					->assign('title', $this->currentTitle)
					->assign('current_page',$this->currentPage);
		$this->isLogin = Session::checkIfLogin();
		
	}

    public function index() 
	{
		$this->view->pagination = true;
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','');
		if($this->isLogin)
		{
			$users = $this->model->getUsuarios();//page 1

			if($users){
				$this->view->assign('results', $users);
			}

		}
		$this->loadAdminView('usersAdmin');  
	}

	// todo make global function page
	// public function page($page)
	// {
	// 	$this->view->pagination = true;
	// 	$users = $this->model->getUsuarios($page);

	// 	if($users){
	// 		$this->view->assign('results', $users);
	// 	}

	// 	$this->loadAdminView('usersAdmin'); 

	// }


	public function crearmapa()
	{
		$this->view->assign('current_page', $this->currentPage)
					->assign('antecesor_page',array('mapas'=>'mapas')); //para el breadcrum, declaramos un array de url=>nombre
		$this->loadAdminView('mapsAdmin');
	}
}