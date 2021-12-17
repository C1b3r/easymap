<?php
class Mapas_Model extends model
 {
   public $defaultFunction = "getMap";

    public function getMap($page = 1,$limit = '')
    {
        if(!empty($limit)){
            $this->limit = $limit;
       }
        // $this->limit = ( $limit == 0 || !isset($limit)) ? 'null' : $limit;
        $result = $this->selectPagination("map",$page);  
        return $result;

    }
 }
