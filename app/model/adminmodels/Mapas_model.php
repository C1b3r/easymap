<?php
namespace app\model\adminmodels;
use app\classes\Model;
use Illuminate\Pagination\Paginator;
class Mapas_Model extends model
 {
   public $defaultFunction = "getMap",
          $timestamps = false;
   protected $table = 'map',
   $primaryKey = 'id_map',
   $fillable = ['title','configuration','description'];
   
    public function getMap($page = 0,$limit = '')
    {
       if(!empty($limit)){
            $this->limit = $limit;
       }
       if(!is_numeric($page)){
           $page = 0;
       }
        // $this->limit = ( $limit == 0 || !isset($limit)) ? 'null' : $limit;
        // $result = $this->selectPagination("map",$page);  
        //limite, filas a listar, nombre de pagina y página actual
        $result = $this->paginate($this->limit,['*'],'page',$page);
        return $result;

    }
    public function getDataMap($id)
    {
        $results = $this->select('title','configuration','description')
                        ->where('id_map','=',$id)
                        ->first();
        if(!empty($results)){
            return array('id_user'=>$results->id_user ,'name' => $results->name, 'email' => $results->email, 'active'=> $results->active);
        }else{
            return false;
        }
    }

 }
