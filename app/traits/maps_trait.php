<?php
namespace app\traits;

trait Maps_Trait
{
    public function getLatestMaps($limit)
    {
        // $result = $this->select("map", null)->fetchAllArray();   //En este caso, al ser un limit, hacemos un fetchall
        $result = $this->conectar->conexion->table('map')->take($limit)->orderBy('updated_at', 'DESC')->get();
        return $result;
    }
}