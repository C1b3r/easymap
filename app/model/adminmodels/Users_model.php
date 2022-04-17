<?php
namespace app\model\adminmodels;

use app\classes\Model;

class Users_Model extends Model
 {
    public $defaultFunction = "getUsuarios";

    public function getUsuarios($page = 1,$limit = '')
    {
        //TODO: hacer un select complejo con inner joins
        if(!empty($limit)){
             $this->limit = $limit;
        }
       
         //In this case, we use limit clause,use fetchall. If you want test one specific, replace null for ('mi_field' => value)
        // $result = $this->select("users", null)->fetchAllArray();  
        $result = $this->selectPagination("users",$page);  

        
        return $result;

    }
 }
