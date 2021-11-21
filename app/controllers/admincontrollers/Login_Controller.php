<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Login_Controller extends Controller 
{
	public $havemodel = false;
    protected $defaultView = 'login';
	
	public function __construct() 
	{
		parent::__construct(true); //to create view
		$this->loadModel('admin');
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
	}

	public function index()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			$validador = new Validation;

			if(!isset($_POST['submit'])) //submit variable
			{
				$this->loadAdminView('/');
			}else{
				if(empty($_POST['email']) || empty($_POST['pass']))
				{
					$this->error('/','Debe rellenar ambos campos');
				}
				if($this->model->logUser($_POST['email'],$_POST['pass'],$this->session))
				{
					$this->view->assign('email', $this->model->username);
					//Cargará el index
					$this->redirect('admin');
				}else{
					$this->error('/','Usuario y contraseña incorrectos');
				}
			}
		}else{
			if(!$this->isLogin){
				$this->loadAdminView('login');
			}else{
				$this->redirect('admin');
			}
			
		}
		
		function test(){
			$array = array("form" => [],  
			"fields" => []);
$form = $array['form'];

array_push($form,"pepe","perez");


print_r($form);
		}
	}
}