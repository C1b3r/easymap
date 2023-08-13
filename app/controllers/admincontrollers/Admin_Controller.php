<?php
namespace app\controllers\admincontrollers;
use app\classes\Controller;
use app\model\adminmodels\Admin_Model;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Admin_Controller extends Controller 
{
	
	protected $defaultView = 'mainAdmin';

	public function __construct() 
	{
		parent::__construct(true); //to create view
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
		$this->model = new Admin_Model();
	}

    public function index() 
	{
		
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','')
				   ->assign('current_page','Visión general');

		$maps = $this->model->getLatestMaps(3);

		$this->view->assign('maps', $maps);
		
		$this->loadAdminView($this->defaultView);   
	}
}