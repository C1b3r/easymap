<?php
namespace app\model\adminmodels;
use app\classes\Model;
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
        //limite, filas a listar, nombre de pagina y página actual https://stackoverflow.com/questions/44077438/laravel-eloquent-pagination-control-page-number-with-route
        $result = $this->paginate($this->limit,['*'],'page',$page);
        return $result;

    }
 }
