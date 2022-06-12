<?php
namespace app\controllers\admincontrollers;
use app\classes\Controller;
use app\classes\Session;
use app\model\adminmodels\Users_Model;
use Illuminate\Support\Facades\Request;
defined('ROOT_PATH') or exit('Direct access forbidden');

class Users_Controller extends Controller 
{
	protected $defaultView = 'usersAdmin';
	protected $currentTitle = 'Listado de usuarios';
	protected $currentPage = 'users';

	public function __construct() 
	{
		parent::__construct(true); //to create view
		//assing allways the same robots(you can overwrite in assign function)
		$this->view->assign('robots','noindex, nofollow')
					->assign('title', $this->currentTitle)
					->assign('current_page',$this->currentPage);
		$this->model = new Users_Model();
		
	}

    public function index() 
	{
		$this->view->pagination = true;
		$this->view->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','');

		$users = $this->model->getUsuarios();//page 1

		if($users){
			$this->view->assign('results', $users);
		}
		$this->loadAdminView('usersAdmin');  
	}

	// todo make global function page
	// public function page($page)
	// {
	// 	$this->view->pagination = true;
	// 	$users = $this->model->getUsuarios($page);

	// 	if($users){
	// 		$this->view->assign('results', $users);
	// 	}

	// 	$this->loadAdminView('usersAdmin'); 

	// }
	
	public function edit($id)
	{
		$this->view->assign('keywords','')
		->assign('description','')
		->assign('other_title','');
		$dataUser = $this->model->getDataUsuario($id);//page 1
		if($dataUser){
			$this->createCSRF();
			$this->view->assign('results', $dataUser);
			$this->loadAdminView('editAdmin'); 
		}else{
			return \Helper::$redirect->route('list_users');
		}	
	}
	public function editSubmit($id)
	{
		$token = $_POST['token'];
		if($this->checkCSRF($token)){
			//success
			if($dataUser = $this->model->changeDataUser($id,$_POST)){
				unset($_SESSION['tokencsrf']);
				$this->createCSRF();
				$this->view->assign('results', $dataUser);
				$this->loadAdminView('editAdmin'); 
			}else{
				$this->error('Cambio contraseña','Mensaje','message','Hubo un error al procesar los datos');
				return \Helper::$redirect->route('edit_user',['id' =>$id]);
			}
			//error
		}
	}

	public function crearmapa()
	{
		$this->view->assign('current_page', $this->currentPage)
					->assign('antecesor_page',array('mapas'=>'mapas')); //para el breadcrum, declaramos un array de url=>nombre
		$this->loadAdminView('mapsAdmin');
	}
}