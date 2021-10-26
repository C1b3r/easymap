<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Error_Controller extends Controller 
{
	public $havemodel = false;

	function __construct() 
	{
		parent::__construct();
	}
	function index($message = '') 
	{
		if (!DEBUG_ENVIRONMENT)
		{
			$message = '';
		}
		$this->view->assign('title','404 not found')
				   ->assign('robots','noindex, nofollow')
				   ->assign('keywords','')
				   ->assign('description','')
				   ->assign('message','')
				   ->assign('other_title','')
				   ->display('error');
	}
}
