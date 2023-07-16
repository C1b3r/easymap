<?php
namespace app\model\adminmodels;
use app\classes\Model;
use Illuminate\Pagination\Paginator;
class Hotspot_Model extends model
 {
   public $defaultFunction = "getMap",
          $timestamps = false;
   protected $table = 'hotspot',
   $primaryKey = 'id_hotspot',
   $fillable = [
    'id_map',
    'latitude',
    'longitude',
    'id_image',
    'id_spot',
    'information'
    ];
   
    public function getByMapId($idMap)
    {
        return $this->where('id_map', $idMap)->get();
    }
    

 }

 