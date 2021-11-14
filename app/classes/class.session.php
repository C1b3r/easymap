<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Session 
{

	public function __construct() 
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
    }

    public static function checkIfLogin()
    {//test cookie in future
        if(!isset($_SESSION['id_user'])){
			return false;
		}else{
			return true;
		}
    }

	public function addSession($index,$value)
	{
		$_SESSION[$index] = $value;
        return $_SESSION[$index];
	}

	public static function createCookie()
	{
		            // setcookie(
            //     'username',
            //     $this->username,
            //      time() + 3600 * 24 * 365,
            //      '/',//Para todo el directorio CURRENT_DIRECTORY -- para este solo
            //      CURRENT_DOMAIN,
            //      false, // TLS-only
            //      false  // http-only
            // );
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
		/*
		  session_start();

    $sesionHelper = array_keys($_SESSION);
    foreach ($sesionHelper as $key){
        unset($_SESSION[$key]);
    } */
}