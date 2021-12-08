<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Validation 
{

	private $secretKey = 'fjd3vkuw#KURefg'; //get from database TODO
	protected $table = '';
	public function __construct($table = '') 
	{
		$this->table = $table;
    }

	public function validateFields($rules,$post)
	{
		$errors = [];

		if(is_array($post)){
			foreach($rules as $fieldName=>$value){

				$fieldRules = explode("|", $value);
				foreach($fieldRules as $rule){
					$ruleValue = $this->_getRuleSuffix($rule);
					$rule = $this->_removeRuleSuffix($rule);

					if($rule == "required" && $this->isEmptyFieldRequired($post, $fieldName)){
						$errors[$fieldName]['required'] = "El campo ". $this->_removeUnderscore(ucfirst($fieldName)) . " es obligatorio";
					}

					if($rule == "email" && ! $this->isEmailValid($post, $fieldName)){
						$errors[$fieldName]['email'] = "El campo ". $this->_removeUnderscore(ucfirst($fieldName)) . " no es válido";
					}

					if($rule == "min" &&  $this->isLessThanMin($post, $fieldName, $ruleValue)){
						$errors[$fieldName]['max'] = "El campo ". $this->_removeUnderscore(ucfirst($fieldName)) . " es menor de " . $ruleValue . " caracteres de la longitud mínima.";
					}

					if($rule == "max" &&  $this->isMoreThanMax($post, $fieldName, $ruleValue)){
						$errors[$fieldName]['max'] = "El campo ". $this->_removeUnderscore(ucfirst($fieldName)) . " tiene más de " . $ruleValue . " caracteres de la longitud máxima";
					}

					if($rule == "unique" && ! $this->isRecordUnique($post, $fieldName, $ruleValue)){
						$errors[$fieldName]['unique'] = "El registro ".  $this->_removeUnderscore(ucfirst($fieldName)) . " ya existe";
					}
				}
			}
		}
		return $errors;
	
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

	  public function isEmptyFieldRequired($input, $fieldName) 
	  {
		  return $input[$fieldName] == "" || empty($input[$fieldName]);
	  }
  
	  public function isLessThanMin($input, $fieldName, $value) 
	  {
		  return strlen($input[$fieldName]) < $value; 
	  }
  
	  public function isMoreThanMax($input, $fieldName, $value) 
	  {
		  return strlen($input[$fieldName]) > $value;
	  }
  
	  public function isRecordUnique($input, $fieldName, $fieldDatabase) 
	  {	
		  //For unique fields, we need defined as unique:nameoffieldindatabase in the string
		  // Connect to database
		  $stmt = new Model();
		 $cantidad = $stmt->checkOneRow($this->table,$fieldDatabase,$input[$fieldName]);	

		 if(!$cantidad || $cantidad == 0){
			 //if not cuantity, false or if $cantidad =0 not exist
			 return true;
		 }else{
			 return false;
		 }
		
	  }
  
	  public function isEmailValid($input, $fieldName) 
	  {
		  $email = $input[$fieldName];
  
		  if(!empty($email) || $email != ""):
			  return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
		  else:
			  return TRUE;
		  endif;
	  }
  
  
	  public function _removeUnderscore($string) 
	  {
		  return str_replace("_", " ", $string);
	  }
  
	  public function _removeRuleSuffix($string) 
	  {
		  $arr = explode(":", $string);
  
		  return $arr[0];
	  }
  
	  public function _getRuleSuffix($string) 
	  {
		  $arr = explode(":", $string);
  
		  return isset($arr[1])?$arr[1]:null;
	  }
}