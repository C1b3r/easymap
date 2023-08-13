<?php
namespace app\model\adminmodels;
use app\classes\Model;
use Illuminate\Pagination\Paginator;
class Mapas_Model extends model
 {
   public $defaultFunction = "getMap",
          $timestamps = true;
   protected $table = 'map',
   $primaryKey = 'id_map',
   $fillable = ['title','configuration','description'];
   protected $casts = [
    'configuration' => 'array',
   ];
   
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
            [$latitud,$longitud,$zoom,$proveedor] = $this->getConfiguration($results->configuration);
            return array('var_title'=>$results->title ,
                        'var_descripcion' => $results->description, 
                        'var_latitud' => $latitud, 
                        'var_longitud'=> $longitud,
                        'var_zoom' => $zoom, 
                        'var_proveedor'=> $proveedor,
                        'var_id'=> $id
                    );
        }else{
            return false;
        }
    }

    public function getConfiguration($json)
    {
        $data = $json;
        $latitud = '';
        $longitud = '';
        if(isset($data['coord'])){
            $latitud = $data['coord']['lat'];
            $longitud = $data['coord']['lon'] ;
        }
        $zoom = $data['zoom'] ?? '';
        $proveedor = $data['provider'] ?? '';
        return [$latitud, $longitud,$zoom,$proveedor];
        /*ejemplo
           {
            "zoom": 6,
            "provider" : "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            "coord":{
                    "lon":-8.396,
                    "lat":43.3713
                } 
        }
        */
    }

 }

 