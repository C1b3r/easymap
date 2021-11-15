<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Login_Controller extends Controller 
{
	public $havemodel = false;
	protected $defaultView = 'admin/login';

	public function __construct() 
	{
		parent::__construct(); //to create view
		$this->loadModel('admin');
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)

	}

	public function index()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$validador = new Validation;

		
		if(!isset($_POST['submit']))
		{
			 $this->loadAdminView();
		}else{
			if(empty($_POST['email']) || empty($_POST['pass']))
			{
				$this->error('admin/','Debe rellenar ambos campos');
			}
			if($this->model->logUser($_POST['email'],$_POST['pass'],$this->session))
			{
				$this->view->assign('email', $this->model->username);
				//Cargará el index
				$this->redirect('admin');
			}else{
				$this->error('admin/','Usuario y contraseña incorrectos');
			}
		}
		}else{
			$this->error('admin/',''); //Si no ha hecho un submit, que simplemente muestre la pagina principal de admin,al no tener iniciada la sesión, mostrará el login
		}
		
		
	}


	public function mapas()
	{

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