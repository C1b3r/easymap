<?php
namespace app\controllers\admincontrollers;
use app\classes\Controller;
use app\classes\Session;
use app\model\adminmodels\Mapas_Model;
use Illuminate\Http\Request;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Mapas_Controller extends Controller 
{
	protected $defaultView = 'mapsAdmin';
	protected $currentTitle = 'Listado de mapas';
	protected $currentPage = 'mapas'; //for pagination and breadcrumb links
	public $secciones = ['informacionMapa' => 'Informacion',
						 'puntosMapa' => 'Puntos del mapa',
						];

	public function __construct() 
	{
		parent::__construct(true); //to create view
		 //assing allways the same robots(you can overwrite in assign function)
		$this->view->assign('robots','noindex, nofollow')
					->assign('title', $this->currentTitle)
					->assign('current_page',$this->currentPage);
		$this->model = new Mapas_Model();
		
	}

    public function index() 
	{
		$this->view->pagination = true;
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','');
	
		$maps = $this->model->getMap(); //page 1

		if($maps){
			$this->view->assign('results', $maps);
		}

		$this->view->assign('current_page',$this->currentPage);
		$this->loadAdminView('mapsAdmin');  
	}

	public function edit($id)
	{
		$this->view->assign('secciones',['informacionMapa' => 'Informacion',
						 'puntosMapa' => 'Puntos del mapa',
						]);
		$dataUser = true; // $this->model->getDataMap($id);//page 1
		if($dataUser){
			$this->createCSRF();
			// $this->view->assign('results', $dataUser);
			$this->loadAdminForm('editMapas'); 
		}else{
			return \Helper::$redirect->route('list_maps');
		}	
	}
	// public function page($page = 0)
	// {
	// 	if(!is_numeric($page)){
	// 		new MyException("Not found",'',0);
	// 	}
	// 	$this->index();
	// }

	public function informacionMapa(Request $request)
	{
		header('Content-Type: application/json');
		if(!$request->ajax()){
			return json_encode(array('Message' => "error"));
		}
		
		$info = array(
			"type" => "form",
			"childValues" => array(
			  array(
				"type" => "input",
				"attributes" => array(
				  "name" => "username",
				  "placeholder" => "Enter username"
				)
			  ),
			  array(
				"type" => "input",
				"attributes" => array(
				  "name" => "password",
				  "type" => "password",
				  "placeholder" => "Enter password"
				)
			  )
			)
		  );
		  
		return json_encode($info);
	}
	public function crearmapa()
	{
		$this->view->assign('current_page',$this->currentPage)
					->assign('antecesor_page',array('mapas'=>'mapas')); //para el breadcrum, declaramos un array de url=>nombre
		$this->loadAdminView('mapsAdmin');
	}

	public function tab(){
		$data = array();
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}