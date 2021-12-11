<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Error_Controller extends Controller 
{
	public $havemodel = false;
	public $texto500 = 'Nuestros técnicos estan trabajando en arreglar este estropicio';
	public $texto404 = 'Esta página debe estar en otro castillo';

	function __construct() 
	{
		parent::__construct();
	}
	function index($message = '' ,$code = '404') 
	{
		if (!DEBUG_ENVIRONMENT)
		{
			$message = '';
		}
		switch ($code) {
			case '500':
				$message = (empty($message)) ? $this->texto500 : $message;
				$this->view->assign('title','500 internal server error')
						->assign('message',$message)
				   		->assign('other_title','Error interno, no es tu culpa')
						->assign('error_image','tecnicos.jpg');   
				break;
			
			default:
			$message = (empty($message)) ? $this->texto404 : $message;
			$this->view->assign('title','404 not found')
						->assign('message',$message)
				   		->assign('other_title','404 not found');
				break;
		}
		$this->view->assign('robots','noindex, nofollow')
				   ->assign('keywords','error page, page, error, '.$code)
				   ->assign('description','This is error page, not need description')
				   ->display('error');
				   die();
	}
}
