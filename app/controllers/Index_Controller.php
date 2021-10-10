<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Index_Controller extends Controller 
{
	public function index() {
		$this->loadModel('Index');
		
		$this->view->assign('title','asdf')
				   ->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','')
				   ->display('main');
	}
	
}
