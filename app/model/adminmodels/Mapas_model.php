<?php
class Mapas_Model extends model
 {
   
    public function getMap($limit)
    {
        $stmt = $this->db->conexion->prepare("SELECT * FROM ".DB_PREFIX."map LIMIT :limit");
        $stmt->bindParam("limit", $limit,PDO::PARAM_INT);
        $stmt->execute();
        // $data = $stmt->fetch(PDO::FETCH_ASSOC);
        //$data = array();
        // while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        //     $data[] = $row;
        //  }
        //En este caso, al ser un limit, hacemos un fetchall
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        if($count)
        {
            return $data;
        }else{
            return false;
        }

    }
 }
