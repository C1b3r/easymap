<?php
class Mapas_Model extends model
 {
   
    public function getMap($limit)
    {
        $this->limit = $limit;
        $result = $this->select("map", null)->fetchAllArray();  
         //En este caso, al ser un limit, hacemos un fetchall,si quieres testear uno concreto, sustituye null por array('id_map' => 3)
        return $result;

    }
 }
