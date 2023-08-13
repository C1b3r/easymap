<?php
namespace app\controllers\admincontrollers;
use app\classes\Controller;
use app\classes\Session;
use app\model\adminmodels\Mapas_Model;
use app\model\adminmodels\Hotspot_Model;
use Helper;
use Illuminate\Http\Request;
use app\traits\Json_Trait;
use app\classes\Boot;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Mapas_Controller extends Controller 
{
	use Json_Trait;

	protected $defaultView = 'mapsAdmin';
	protected $currentTitle = 'Listado de mapas';
	protected $currentPage = 'mapas'; //for pagination and breadcrumb links


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
		$this->view->assign('secciones',["informacionMapa" => 'Informacion',
						 	"puntosMapa" => 'Puntos del mapa',
						 	"datatable" => 'Listado de puntos de mapas',
							]
						)
						->assign('currentId' , $id);
	
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
		$data = $this->model->getDataMap($request->id);

		$info = $this->loadJSONView('/admin/secciones/','informacionMapa') ?? array('Message' => "error");
		$json = json_encode($info);
		/* Necesito agregarlo después ya que no puedo auto generar la ruta si no tengo el id
		$data['url_dest'] = Helper::$urlGeneration->route('informacionMapa',["id" =>$request->id]);
		*/
		$json_replaced = $this->reemplazarMarcadores($json,$data);
		return $json_replaced;
		
	}

	public function puntosMapa(Request $request)
	{
		header('Content-Type: application/json');
		if(!$request->ajax()){
			return json_encode(array('Message' => "error"));
		} 
		// Crear un array con los datos de reemplazo
		/*$hotspotModel = new Hotspot_Model();
		$data = $hotspotModel->getByMapId($request->id)->toArray();

		$info = $this->loadJSONView('/admin/secciones/','puntosMapa') ?? array('Message' => "error");
		$json = json_encode($info);
		$json_replaced = $this->reemplazarMarcadores($json,$data);*/
		$info = $this->loadJSONView('/admin/secciones/','puntosMapa') ?? array('Message' => "error");
		$json = json_encode($info);
		$json_replaced = $this->reemplazarMarcadores($json,['var_id' => $request->id]);
		return $json_replaced;
		
	}

	public function eliminarPuntosMapa(Request $request)
	{
		header('Content-Type: application/json');
		if(!$request->ajax() && !$request->isMethod('DELETE')){
			return json_encode(array('Message' => "error"));
		} 

		
		$hotspot = new Hotspot_Model();
		if( $hotspot->deleteHotspot($request->id) ){
			return json_encode(['success' => true]);
		}
		return json_encode(['success' => false]);
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

	//Cargar los puntos para volcarlos en un datatable
	public function cargarPuntosMapa(Request $request)
	{
		header('Content-Type: application/json');
		if(!$request->ajax()){
			return json_encode(array('Message' => "error"));
		} 
		$id = $request->id;
		$draw = $request->input('draw');
		$start = $request->input('start');
		$length = $request->input('length');
		$searchValue = $request->input('search.value');
		// Consulta principal utilizando Eloquent
		$query = Hotspot_Model::query()->select('hotspot.id_hotspot','hotspot.latitude','hotspot.longitude','hotspot.id_image','spot.nombre')
								->join('spot', 'hotspot.id_spot', '=', 'spot.id_spot')
								->with('image');

		// Aplicar la búsqueda si se proporciona un valor de búsqueda
		if ($searchValue) {
			$query->where(function ($q) use ($searchValue,$id) {
				// Aquí debes definir las columnas en las que quieres realizar la búsqueda
				$q->where('spot.nombre', 'like', "%{$searchValue}%");
					// ->where('id_map', '=', $id);
					//->orWhere('columna2', 'like', "%{$searchValue}%");
				// ... continuar con las demás columnas si es necesario
			});
		}
	
		// Obtener el número total de registros antes de aplicar la paginación
		$totalRecords = $query->count();
	
		// Aplicar la paginación
		$query->skip($start)->take($length);
	
		// Obtener los datos para la página actual
		$data = $query->get();

		$transformedResults = $data->map(function ($data) {
			if (!isset($data->image)) {
				$data->image_name = 'No image';
				return $data;
			}
			$image_path = ($data->image->ext) ? '' : PUBLIC_WEB_PATH.'images/uploads/' ;
			$data->image_name = '<img  width="80px" src="' . $image_path . $data->image->name . '" alt="' . $data->image->name . '">';
		
			return $data;
		});
	
		// Construir la respuesta en formato JSON
		$jsonData = [
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords, // En este ejemplo, no se realiza ningún filtrado adicional
			"data" => $transformedResults,
		];
	
		// Enviar la respuesta en formato JSON
		return  json_encode($jsonData);

	}

	public function puntoMapa(Request $request)
	{ 
		header('Content-Type: application/json');
		$id = $request->id;
		$query = Hotspot_Model::query()->select('hotspot.id_hotspot','hotspot.latitude','hotspot.longitude','hotspot.id_image','spot.id_spot')
								->join('spot', 'hotspot.id_spot', '=', 'spot.id_spot')
								->where('hotspot.id_hotspot', '=', $id)->first()->toArray();
		return $query; //Lo retorno de esta manera porque el json_encode con la cabecera no me está funcionando
	}

	public function puntomapaUpdate(Request $request)
	{
		// Validación de datos
		$validator = Boot::$app->validator->make($request->all(), [
			'longitude' => 'required|numeric',
			'latitude' => 'required|numeric',
			'id_image' => 'required',
			'mySelect' => 'required',
		]);

		// Si la validación falla, redirige con mensajes de error
		if ($validator->fails()) {
			$this->error('mapa',self::FLASH_ERROR,'flash','No se pudo guardar, compruebe los campos');
			return \Helper::$redirect->back()->withFragment('#datatable');
		}
		try {
			Hotspot_Model::where('id_hotspot',$request->input('id_hotspot'))
					->update(['longitude'=>$request->input('longitude'),
							  'latitude'=>$request->input('latitude'),
							  'id_image'=>$request->input('id_image'),
							  'id_spot'=>$request->input('mySelect'),
								]);
			$this->error('mapa',self::FLASH_SUCCESS,'flash','Se ha guardado con éxito');
		} catch (\Illuminate\Database\QueryException $e) {
			$this->error('mapa',self::FLASH_ERROR,'flash','No se pudo guardar, compruebe los campos');
		}

		return \Helper::$redirect
		->back()->withFragment('#datatable');

	}
	public function guardarPuntosMapa(Request $request)
	{
		// Validación de datos
		$validator = Boot::$app->validator->make($request->all(), [
			'current_map' => 'required',
			'latitud' => 'required|numeric',
			'longitud' => 'required|numeric',
			'img_id' => 'required',
			'informacion' => 'required',
			'selectOption' => 'required',
		]);
		  

		
		 // Si la validación falla, redirige con mensajes de error
		if ($validator->fails()) {
			$this->error('mapa',self::FLASH_ERROR,'flash','No se pudo guardar, compruebe los campos');
			return \Helper::$redirect->back()->withFragment('#puntosMapa');

		}

		$hotspot = new Hotspot_Model;
		$hotspot->id_map =$request->input('current_map');
		$hotspot->latitude = $request->input('latitud');
		$hotspot->longitude = $request->input('longitud');
		$hotspot->id_image = $request->input('img_id');
		$hotspot->id_spot = $request->input('selectOption') ;
		$hotspot->information = $request->input('informacion');
		$hotspot->save();

		$this->error('mapa',self::FLASH_SUCCESS,'flash','Se ha guardado con éxito');

		return \Helper::$redirect
        ->back()->withFragment('#puntosMapa');
        // ->with('success', 'Hotspot guardado correctamente.');

	}

	public function guardarInfoMapa(Request $request)
	{
		// Validación de datos
		$validator = Boot::$app->validator->make($request->all(), [
			'current_map' => 'required',
			'latitud' => 'required|numeric',
			'longitud' => 'required|numeric',
			'titulo' => 'required',
			'description' => 'required',
			'Zoom' => 'required',
			'Proveedor' => 'required',
		]);
		// Si la validación falla, redirige con mensajes de error
		if ($validator->fails()) {
		$this->error('mapa',self::FLASH_ERROR,'flash','No se pudo guardar, compruebe los campos');
		return \Helper::$redirect->back()->withFragment('#informacionMapa');
		}
	
		$model =  $this->model->firstOrNew(['id_map' =>$request->input('current_map')]);
		$model->title = $request->input('titulo');
		$model->configuration = [
			"zoom" => $request->input('Zoom'),
			"provider" => $request->input('Proveedor'),
			"coord" => [
				"lon" => $request->input('latitud'),
				"lat" => $request->input('longitud'),
			],
		];
		$model->description = $request->input('description');
		$model->save();
		

		$this->error('mapa',self::FLASH_SUCCESS,'flash','Se ha guardado con éxito');
		return \Helper::$redirect
        ->back()->withFragment('#informacionMapa');
	}
}