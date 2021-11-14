<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Validation 
{

	private $secretKey = 'fjd3vkuw#KURefg'; //get from database

	public function __construct() 
	{
		
    }

	 public function validateEmail($email)
	  {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}else{
			return false;
		}
	  }

	  public function checkEmailUnique($email,$table,$db)
	  {
		if(!$email){
			return false;
		} 
		$db->query("SELECT * FROM ".DB_PREFIX.$table." WHERE email=#", $email);
		if($db->numRows() == 0){
			return true;
		}
		return false;
	  }
}