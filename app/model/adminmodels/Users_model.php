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
        //Check if password is not empty
        if(!empty($data['old_pass']) && !empty($data['new_pass']) && !empty($data['confirm_pass'])){
            if($data['new_pass'] !== $data['confirm_pass']){
                return false;
            }
            // $results = $this->select('id_user','name','email','active')
            //     ->where('id_user','=',$id)
            //     ->where('pass','=',md5($data['old_pass']))
            //     ->first();

           if($data['old_pass'] !== $user->pass){
            $user->pass = $data['new_pass'];
           }else{
               return false;
           }
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->active = isset($data['active'])? 1: 0 ;
        //https://stackoverflow.com/questions/42623841/laravel-password-password-confirmation-validation
        //6512bd43d9caa6e02c990b0a82652dca
        $saved = $user->save();

        if(!$saved){
            return false;
        }else{
             return array('id_user'=>$id ,'name' =>  $user->name, 'email' => $user->email, 'active'=> $user->active);
        }

    }
    
 }
