<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Admin_Controller extends Controller 
{
    public function index() {
		
		$this->view->assign('title','Panel de administración')
				   ->assign('keywords','')
				   ->assign('description','')
				   ->assign('other_title','')
				   ->display('admin/mainAdmin');
	}
    public function test()
    {
        echo "aa";
    }
}