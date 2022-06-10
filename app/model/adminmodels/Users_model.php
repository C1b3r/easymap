<?php
namespace app\model\adminmodels;

use app\classes\Model;

class Users_Model extends Model
 {
    public $defaultFunction = "getUsuarios";
    protected $table = 'users',
             $primaryKey = 'id_user',
             $fillable = ['email','pass','name','active'];
    const CREATED_AT = 'date_add';
    const UPDATED_AT = 'date_update';

    public function getUsuarios($page = 0,$limit = '')
    {
        if(!empty($limit)){
            $this->limit = $limit;
       }
       if(!is_numeric($page)){
           $page = 0;
       }
        $result = $this->paginate($this->limit,['id_user','email','name','date_add'],'page',$page); 
        return $result;

    }
    public function getDataUsuario($id)
    {
        $results = $this->select('id_user','name','email','active')
                        ->where('id_user','=',$id)
                        ->first();
        if(!empty($results)){
            return array('id_user'=>$results->id_user ,'name' => $results->name, 'email' => $results->email, 'active'=> $results->active);
        }else{
            return false;
        }
    }
    public function changeDataUser($id,$data)
    {
        //Localizo el modelo
        $user = $this::find($id);
        //Si no existe
        if(!isset($user)){
            return false;
        }
        $shouldSendMail = false;
        //Check if password is not empty
        if(!empty($data['old_pass']) && !empty($data['new_pass']) && !empty($data['confirm_pass'])){
            if($data['new_pass'] !== $data['confirm_pass']){
                return false;
            }
            // $results = $this->select('id_user','name','email','active')
            //     ->where('id_user','=',$id)
            //     ->where('pass','=',md5($data['old_pass']))
            //     ->first();
            $data['new_pass'] = md5($data['new_pass']);
           if(md5($data['old_pass']) === $user->pass){
            $user->pass = $data['new_pass'];
            $shouldSendMail = true;
           }else{
               return false;
           }
        }
        //Validation require name, email, del email si cambia, verificar que es unique, puede darse el caso creo que actualices
        //y si le metes el unique no te permita, tienes que comprobar que es distinto al email de base de datos y solo ahí comprobar que verdaderamente es único
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->active = isset($data['active'])? 1: 0 ;
        //https://stackoverflow.com/questions/42623841/laravel-password-password-confirmation-validation
        //6512bd43d9caa6e02c990b0a82652dca
        //https://stackoverflow.com/questions/17799148/how-to-check-if-a-user-email-already-exist https://stackoverflow.com/questions/28198897/laravel-check-for-unique-rule-without-itself-in-update
        $saved = $user->save();

        if(!$saved){
            return false;
        }else{
            if($shouldSendMail){
                $mail = new \Mail($user->email);
                $mail->setFrom()->setSubject("Cambio de contraseña")->setMessage("Su contraseña ha sido cambiada")->send();
            }
             return array('id_user'=>$id ,'name' =>  $user->name, 'email' => $user->email, 'active'=> $user->active);
        }

    }
    
 }
