<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Login_Controller extends Controller 
{
	public $havemodel = false;
    protected $defaultView = 'login';

	public $loginValidations = [
		'email' => 'required|email|min:2|max:100',
		'pass' => 'required|min:2|max:100',
		'submit' => 'required'
	];
	
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
			$validation = $validador->validateFields($this->loginValidations,$_POST);
			if(!count($validation)){
				if($this->model->logUser($_POST['email'],$_POST['pass'],$this->session))
				{
					$this->view->assign('email', $this->model->username);
					//Cargará el index
					$this->redirect('admin');
				}else{
					$this->error('login',self::FLASH_ERROR,'message','Usuario o contraseña incorrectos');
				}
			}else{
				$this->createForm("formLogin");
				$this->error('login',self::FLASH_ERROR,'flash',$validation);
			 }
		}else{
			if(!$this->isLogin){
				$this->createForm("formLogin");
				$this->loadAdminView('login');
			}else{
				$this->redirect('admin');
			}
			
		}

	}
}