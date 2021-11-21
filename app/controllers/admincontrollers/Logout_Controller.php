<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Logout_Controller extends Controller 
{
	public $havemodel = false;

	public function __construct() 
	{
		parent::__construct(); //to create view
	}

    public function index() 
	{
		//Clean cookies --Future, only clean cookies admin(search in array)
		foreach($_COOKIE as  $key => $val)
		{
			Session::cleanCookie($key);
		}

		//Clean session
		Session::cleanSession();

		//Go to front page
		$this->redirect('',false);

	   
	}


}