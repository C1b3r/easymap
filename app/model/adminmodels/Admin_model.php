<?php
class Admin_Model extends model
 {
    public $username;

    public function logUser($email, $pass,$session)
    {
        $passSecured = md5($pass);
        $stmt = $this->db->conexion->prepare("SELECT * FROM ".DB_PREFIX."users WHERE email=:email AND pass=:passSecured");
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("passSecured", $passSecured,PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        //Si tenemos resultados
       $count = $stmt->rowCount();
       
        if($count)
        {
            $this->username = $data->email;
            $session->addSession('username',$this->username);
            $session->addSession('id_user',$data->id_user);// Storing user session value
            return true;
        }
        else
        {
            return false;
        } 
  
    }

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
