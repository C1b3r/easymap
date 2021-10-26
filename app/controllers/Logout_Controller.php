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
		   $this->cleanCookie($key);
		}

		//Clean session
		$this->cleanSession();

		//Go to front page
		$this->redirect('');
		/*
		  session_start();

    $sesionHelper = array_keys($_SESSION);
    foreach ($sesionHelper as $key){
        unset($_SESSION[$key]);
    } */
	   
	}

	public static function cleanCookie($cookieName)
	{
		//Clean cookie value and set empty
		unset($_COOKIE[$cookieName]);
		setcookie($cookieName, '', time() - 3600,'/');
	}
	public static function cleanSession()
	{
		session_destroy();
	}
}