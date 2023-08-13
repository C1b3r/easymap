<?php
namespace app\model;
use app\classes\Model;
use Illuminate\Pagination\Paginator;
class Imagen_Model extends model
 {
   public $defaultFunction = "getById",
          $timestamps = false;
   protected $table = 'images',
   $primaryKey = 'id_image',
   $fillable = [
    'name',
    'ext',
    ];
   
    public function getById($searchValue)
    {
        return $this->where('id_image','=', "{$searchValue}")->get();
    }
    

 }

 