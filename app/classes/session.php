<?php
namespace app\classes;
defined('ROOT_PATH') or exit('Direct access forbidden');
use Illuminate\Database\Capsule\Manager as DB;
class Session 
{

	public function __construct() 
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
    }

    public function checkIfLogin()
    {
        if(isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])){
			return true;
		}
		if(isset($_COOKIE['remember_me'])){
				$token = htmlspecialchars($_COOKIE['remember_me']);

			if ($token && self::token_is_valid($token)) {

				$user = self::find_user_by_token($token);
		
				if ($user) {
					return self::log_user_in($user);
				}
			}
		}

		return false;
		
    }

	public function remember_me($id_user, $day = 30)
	{
		[$selector, $validator, $token] = $this->generate_tokens();

		$actualDate = date('Y-m-d');
		// remove all existing token associated with the user id if date expired
		$this->delete_user_token_by_date($id_user,$actualDate);
	
		// set expiration date
		$expired_seconds = time() + 60 * 60 * 24 * $day;
	
		// insert a token to the database
		$hash_validator = password_hash($validator, PASSWORD_DEFAULT);
		$expiry = date('Y-m-d H:i:s', $expired_seconds);
	
		if ($this->insert_user_token($id_user, $selector, $hash_validator, $expiry)) {
			setcookie('remember_me', $token, $expired_seconds,'/'); //Le agrego el path para poder borrarlo en el cleancookie
		}
	}

	public function log_user_in($user)
	{
		$this->addSession('username',$user['email']);
        $this->addSession('id_user',$user['id_user']);
		return true;
	}

	public function parse_token($token)
	{
		$parts = explode(':', $token);

		if ($parts && count($parts) == 2) {
			return [$parts[0], $parts[1]];
		}
		return null;
	}

	public function token_is_valid($token)
	{ 
		[$selector,$validator] = $this->parse_token($token);

		$tokens = $this->find_user_token_by_selector($selector);
		if (!$tokens) {
			return false;
		}
		
		return password_verify($validator, $tokens['validation_token']);
	}

	/*
	*Solo almacenamos el selector y el validador hasheado
	*/
	public function insert_user_token($id_user, $selector, $validation_token, $date_exp)
	{
		$boolinsert = DB::table('token')->insert([
			'id_user' => $id_user,
			'token' => $selector,
			'validation_token' => $validation_token,
			'date_exp' => $date_exp,
			'active' => 1,
			'type' => 1 //login token
		]);
		return $boolinsert;
	}

	public function find_user_token_by_selector($selector)
	{
		$actualDate = date('Y-m-d');
		$result = [];
		$select = DB::table('token')->select('id_user','token','validation_token','date_exp')->where('token', '=', $selector)->whereDate('date_exp', '>', $actualDate)->get()->toArray();
		if(count($select)>0){
			//Get the first (and only) result
			 $result = ['id_user' => $select[0]->id_user,
			 'token' => $select[0]->token,
			 'validation_token' => $select[0]->validation_token,
			 'date_exp' => $select[0]->date_exp ];
			 return $result;
		}
		return false;
	}
	public function find_user_by_token($token)
	{ 
		[$selector,$validador] = $this->parse_token($token);
		$actualDate = date('Y-m-d');
		$result = [];
		$select = DB::table('users as u')->select('u.id_user','u.email','t.token','t.validation_token','t.date_exp')
									->join('token as t',  'u.id_user', '=', 't.id_user')
									->where('token', '=', $selector)
									->whereDate('date_exp', '>', $actualDate)->get()->toArray();
		if(count($select)>0){
			//Get the first (and only) result
			 $result = ['id_user' => $select[0]->id_user,
			 'email' => $select[0]->email,
			 'token' => $select[0]->token,
			 'validation_token' => $select[0]->validation_token,
			 'date_exp' => $select[0]->date_exp ];
			 return $result;
		}
		return false;
	}

	public function generate_tokens()
	{
		$selector = bin2hex(random_bytes(16));
		$validator = bin2hex(random_bytes(32));
	
		return [$selector, $validator, $selector . ':' . $validator];
	}
	public function addSession($index,$value)
	{
		$_SESSION[$index] = $value;
        return $_SESSION[$index];
	}

	/* */
	public function delete_all_user_token($id_user)
	{
		$deleted = DB::table('token')->where('id_user', '=', $id_user)->delete();
		return $deleted;
	}

	//Cuando necesitemos borrar un token concreto
	public function delete_user_token($id_user,$token)
	{
		[$selector,$validador] = $this->parse_token($token);
		$deleted = DB::table('token')->where('id_user', '=', $id_user)->where('token','=',$selector)->delete();
		return $deleted;
	}
	public function delete_user_token_by_date($id_user,$date_exp)
	{
		$deleted = DB::table('token')->where('id_user', '=', $id_user)->whereDate('date_exp', '<=', $date_exp)->delete();
		return $deleted;
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
		setcookie($cookieName, null, time() - 3600,'/');
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