<?php
namespace app\classes;

use app\classes\Form;
// use app\classes\Helper;
use app\classes\MyException;
use app\classes\Session;
use app\classes\View;
use app\model\adminmodels\Admin_Model;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Controller
{

	//If your controller dont have database operation, override in the child with false value
	public $havemodel = true;
	public $secciones = null;
	protected $defaultView;
	protected $formFunction;
	protected $session;
	const FLASH_ERROR = 'danger';
	const FLASH_WARNING = 'warning';
	const FLASH_INFO = 'info';
	const FLASH_SUCCESS = 'success';
	public $pagination = 1;

    public function __construct($admin = false) 
	{
		$this->view = new View();
		$this->session = Boot::$app->session;
		$this->createCSRF();
	}
	
	public function loadModel($name) 
	{
		$modelName = $name.'_Model';
		$this->model = new $modelName();
	}

	protected function form()
	{
		//All controllers dont need a form, its better to declare here instead on construct(i think)
		return $this->form = new Form;
	}
		
	//Deprecated
	public function createForm($nameForm)
	{
		//If it has been declared in an edit createform
		if(!isset($this->form)){
			$this->view->assign($nameForm,$this->form()->renderForm($nameForm));
		}else{
			$this->view->assign($nameForm,$this->form->renderForm($nameForm));
		}
		
	}

	protected function loadAdminView($currentView = 'error')
	{
		return $this->view->display($currentView,null,true);
	}

	protected function loadAdminForm($currentView = 'error')
	{
		return $this->view->display("forms/".$currentView,null,true);
	}

	
	/* Format is for div message class
	View in flash is for name of the element */
	protected function error($view,$format, $type, $mensaje)
	{
		if($type == "flash"){
			\Helper::setFlash($format,$view,$mensaje);
		}else{
			$this->view->assign('message',array('type'=> $format, 'mensaje'=>$mensaje));
		}
		
		// return $this->loadAdminView($view);
	}

	public function page($page = 1)
	{
		if(!is_numeric($page)){
			new MyException("Not found",'',0);
		}
		//escape model property to call function and pass parameters
		$results = $this->model->{$this->model->defaultFunction}($page);

		if($results){
			
			$this->view->pagination = true; //To indicates the pagination navbar
			$this->view->assign('results', $results);//To pass data to the view
		}

		$this->loadAdminView($this->defaultView);
		// print_r($result);
	}

	public function createCSRF() : void
	{
		if(!isset($_SESSION['tokencsrf'] ) || empty($_SESSION['tokencsrf'] )){
			$_SESSION['tokencsrf'] = bin2hex(random_bytes(32));
		}
	}
	public function checkCSRF($token)
	{
		if (!empty($token) && hash_equals($_SESSION['tokencsrf'], $token)) {
			return true;
		}else{
			// return 405 http status code
			header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
			exit;
		}
	}

	// public function edit($request = '')
	// {
	// 	//To get the form dynamically,get the parent controller
	// 	$realClassName = get_class($this);
	// 	//Separate in array
	// 	$className = explode("_",$realClassName);
	// 	$nameForm = "edit".$className[0];
	// 	$this->view->assign('nameForm', $nameForm);
	// 	//For breadcrum  in header
	// 	$this->view->assign('precedent_page',"Editar ".$className[0]);
	// 	$this->view->assign('previous_page_link',$className[0]);
	// 	/* Declaro la vista, esto irá a editAdmin y como lo otro va a una clase hija que es un formulario, si necesito pasarle contenido al formulario tengo que declararselo en el form */
	// 	$this->form()->assign('secciones',$this->secciones);
	// 	// print_r(strtolower($className[0]));
	// 	$this->createForm($nameForm);
	// 	return $this->loadAdminView("editAdmin");

	// }

	public function redirect($url ,$bckslash = true) 
	{
		if($bckslash): $url = (substr($url, -1) != '/') ? $url.="/" : $url;  endif;

		header("Location: ".COMPLETE_WEB_PATH.$url);
		die();
	}
}