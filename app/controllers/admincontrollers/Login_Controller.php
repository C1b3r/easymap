<?php
namespace app\controllers\admincontrollers;

use app\classes\Boot;
use app\classes\Controller;
use app\classes\Session;
use app\model\adminmodels\Admin_Model;
defined('ROOT_PATH') or exit('Direct access forbidden');

class Login_Controller extends Controller 
{
	public $havemodel = false;
    protected $defaultView = 'login';
	
	public function __construct() 
	{
		parent::__construct(true); //to create view
		// $this->loadModel('admin');
		$this->model = new Admin_Model();
		$this->view->assign('robots','noindex, nofollow')->assign('title','Panel de administración'); //assing allways the same robots(you can overwrite in assign function)
	}

	public function index()
	{   
		if(!Session::checkIfLogin()){
			$this->createForm("formLogin");
			$this->loadAdminView('login');
		}else{
			// $this->redirect('admin');
		return \Helper::$redirect->route('Adminhome');
		}
	}

	public function login()
	{
		$data = ['email' => $_POST['email'],
				'pass' => $_POST['pass'],
				'submit' => $_POST['submit'],
				];
		if($this->model->logUser($data,$this->session)){
			if(isset( $_SESSION['desireURI'])){
				$desireUrl = $_SESSION['desireURI'];
				unset($_SESSION['desireURI']);
				return \Helper::$redirect->to($desireUrl);
			}
			return \Helper::$redirect->route('Adminhome');
		}else{
			$this->error('login',self::FLASH_ERROR,'message','Usuario o contraseña incorrectos');
			$this->createForm("formLogin");
			return \Helper::$redirect->route('login');
		}
		// $validador = new Validation('users');
		// $validation = $validador->validateFields($this->loginValidations,$_POST);
		// if(!count($validation)){
		// 	if($this->model->logUser($_POST,$this->loginValidations,$this->session))
		// 	// if($this->model->logUser($_POST['email'],$_POST['pass'],$this->session))
		// 	{
		// 		$this->view->assign('email', $this->model->username);
		// 		//Cargará el index
		// 		$this->redirect('admin');
		// 	}else{
		// 		$this->createForm("formLogin");
			
		// 	}
		// }else{
		// 	$this->createForm("formLogin");
		// 	$this->error('login',self::FLASH_ERROR,'flash',$validation);
	}
}
