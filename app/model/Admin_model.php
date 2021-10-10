<?php
class Admin_Model extends model
 {
    public function logUser($email, $pass)
    {
        $passSecured = md5($pass);
        $stmt = $this->db->conexion->prepare("SELECT * FROM ".DB_PREFIX."users WHERE email=:email AND pass=:passSecured");
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("passSecured", $passSecured,PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
    //    if ($stmt->fetchColumn() > 0) 
    //    { 
    //     $_SESSION['admin'] = $data->id; // Storing user session value
    //     return true;
    //    }else{
    //     return false;
    //    }
       
       $count = $stmt->rowCount();
       
        if($count)
        {
            $_SESSION['admin'] = $data->id_user; // Storing user session value
            return true;
        }
        else
        {
            return false;
        } 
  
    }
 }
