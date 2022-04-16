<?php
namespace app\model;
use app\classes\Model;

class Admin_Model extends Model
 {
    public $username;
    protected $table = 'users',
              $primaryKey = 'id_user',
              $fillable = ['email','name','active'];

    public function logUser($data, $fields,$session)
    // public function logUser($email, $pass,$session)
    {
        $fieldData = $this->mapFormColumn($fields,$data);

        //In this case, i dont wont to pass field argument because i need user data
        //In other case you can put null in the field position function or put specific fields
        // $result = $this->select("users",  $fieldData,"active = 1")->fetchObj(false);
        // $usuario = $this->conexion->find('users');
        $usuario = $this->select('name','email','id_user')->where('email', '=', trim($fieldData['email']))
                        ->where('pass','=',$fieldData['pass'])
                        ->where('active','=','1')
                        ->first();
        //Compruebo si                 
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
