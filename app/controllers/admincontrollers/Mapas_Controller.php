<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Mapas_Controller extends Controller 
{
	protected $defaultView = 'mapsAdmin';
	protected $currentTitle = 'Listado de mapas';
	protected $currentPage = 'mapas';


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
			$maps = $this->model->getMap(); //page 1

			if($maps){
				$this->view->assign('results', $maps);
			}

		}
		$this->view->assign('current_page',$this->currentPage);
		$this->loadAdminView('mapsAdmin');  
	}
	// public function page($page = 0)
	// {
	// 	if(!is_numeric($page)){
	// 		new MyException("Not found",'',0);
	// 	}
	// 	$this->index();
	// }

	public function crearmapa()
	{
		$this->view->assign('current_page',$this->currentPage)
					->assign('antecesor_page',array('mapas'=>'mapas')); //para el breadcrum, declaramos un array de url=>nombre
		$this->loadAdminView('mapsAdmin');
	}
}