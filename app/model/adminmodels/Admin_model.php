<?php
namespace app\model\adminmodels;
use app\classes\Model;
use app\classes\Boot;
use app\traits\Maps_Trait;

class Admin_Model extends Model
 {
    use Maps_Trait;
    public $username;
    protected $table = 'users',
              $primaryKey = 'id_user',
              $fillable = ['email','name','active'];
    
    protected $rules = [
		'email' => 'required|email',
		'pass' => 'required',
		'submit' => 'required'
	];

    public function logUser($data,$session,$remember = false)
    {

        $validator = Boot::$app->validator->make($data, $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return false;
        }
  
        $usuario = $this->select('name','email','id_user','pass')->where('email', '=', trim($data['email']))
                        ->where('active','=','1')
                        ->first();
        //Compruebo si recibo un resultado
        if(!empty($usuario)){
            if (password_verify($data['pass'],$usuario->pass ))
            {
                $this->username = $usuario->email;
                $session->addSession('username',$this->username);
                $session->addSession('id_user',$usuario->id_user);// Storing user session value
                if($remember){
                    $session->remember_me($usuario->id_user,365);
                }

                return true;
            } else{
                return false;
            }
        }else
        {
            return false;
        }
    }




 }
