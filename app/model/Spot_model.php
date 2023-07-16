<?php
namespace app\model\adminmodels;
use app\classes\Model;
use Illuminate\Pagination\Paginator;
class Spot_Model extends model
 {
   public $defaultFunction = "getByName",
          $timestamps = false;
   protected $table = 'spot',
   $primaryKey = 'id_spot',
   $fillable = [
    'nombre',
    'descripcion',
    'id_image'
    ];
   
    public function getByName($searchValue)
    {
        return $this->where('nombre','like', "%{$searchValue}%")->get();
    }
    

 }

 