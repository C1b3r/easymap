<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Mapas_Controller extends Controller 
{
	protected $defaultView = 'admin/mapsAdmin';


	public function __construct() 
	{
		parent::__construct(true); //to create view
		$this->view->assign('robots','noindex, nofollow')->assign('title','Listado de mapas'); //assing allways the same robots(you can overwrite in assign function)
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
		$this->view->assign('current_page','Listado de mapas');
		$this->loadAdminView('admin/mapsAdmin');  
	}


	public function crearmapa()
	{
		$this->view->assign('current_page','Listado de mapas')
					->assign('antecesor_page',array('mapas'=>'mapas')); //para el breadcrum, declaramos un array de url=>nombre
		$this->loadAdminView('admin/mapsAdmin');
	}
}