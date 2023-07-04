<?php
namespace app\controllers\admincontrollers;
use app\classes\Controller;
use app\classes\Session;
use app\model\adminmodels\Mapas_Model;
use Helper;
use Illuminate\Http\Request;
use app\traits\Json_Trait;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Mapas_Controller extends Controller 
{
	use Json_Trait;

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
		if(!is_numeric($id)){
			return \Helper::$redirect->route('list_maps');
		}
		$this->view->assign('secciones',["informacionMapa/{$id}" => 'Informacion',
						 "puntosMapa/{$id}" => 'Puntos del mapa',
						]);
	
		$this->createCSRF();
		// $this->view->assign('results', $dataUser);
		$this->loadAdminForm('editMapas'); 
		
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
		// Crear un array con los datos de reemplazo
		/*$data = array(
			'var_title' => 'eee',
			'var_descripcion' => 'asdfasdf',
			'var_latitud' => 'sdsd',
			'var_longitud' => 'dd'
		);*/

		$data = $this->model->getDataMap($request->id);

		$info = $this->loadJSONView('/admin/secciones/','informacionMapa') ?? array('Message' => "error");
		$json = json_encode($info);
		$json_replaced = $this->reemplazarMarcadores($json,$data);
		return $json_replaced;
		
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