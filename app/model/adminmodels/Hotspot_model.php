<?php
namespace app\model\adminmodels;
use app\classes\Model;
use app\model\Imagen_Model;
use app\model\Spot_Model;
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
    
    //Relation
    public function image()
    {
        return $this->belongsTo(Imagen_Model::class, 'id_image', 'id_image'); //id_image interno, id_image de la tabla imagen
    }
    public function spot()
    {
        return $this->belongsTo(Spot_Model::class, 'id_spot', 'id_spot'); //id_spot interno, id_spot de la tabla imagen
    }

    public function deleteHotspot($id)
    {
        try {
            return $this->where('id_hotspot', $id)->delete();
        } catch (\Exception $e) {
            // Manejo de errores
            // return response()->json(['error' => $e->getMessage()], 500);
            return false;
        }
    }

 }

 