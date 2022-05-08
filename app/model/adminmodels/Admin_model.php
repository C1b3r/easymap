<?php
namespace app\model\adminmodels;
use app\classes\Model;
use app\classes\Boot;

class Admin_Model extends Model
 {
    public $username;
    protected $table = 'users',
              $primaryKey = 'id_user',
              $fillable = ['email','name','active'];
    
    protected $rules = [
		'email' => 'required|email',
		'pass' => 'required',
		'submit' => 'required'
	];

    public function logUser($data,$session)
    {

        $validator = Boot::$app->validator->make($data, $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return false;
        }
  
        $usuario = $this->select('name','email','id_user')->where('email', '=', trim($data['email']))
                        ->where('pass','=',md5($data['pass']))
                        ->where('active','=','1')
                        ->first();
        //Compruebo si recibo un resultado
        if(!empty($usuario)){
                $this->username = $usuario->email;
                $session->addSession('username',$this->username);
                $session->addSession('id_user',$usuario->id_user);// Storing user session value
                return true;
            }
            else
            {
                return false;
            }
    }


    public function getMap($limit)
    {
        $this->limit = 3;
        // $result = $this->select("map", null)->fetchAllArray();   //En este caso, al ser un limit, hacemos un fetchall
        $result = $this->conectar->conexion->table('map')->take($this->limit)->get();
        return $result;
    }

 }
