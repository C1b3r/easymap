<?php
namespace app\model\adminmodels;

use app\classes\Model;

class Users_Model extends Model
 {
    public $defaultFunction = "getUsuarios";
    protected $table = 'users',
             $primaryKey = 'id_user',
             $fillable = ['email','pass','name','active'];

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
 }
