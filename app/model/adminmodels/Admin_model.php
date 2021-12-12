<?php
class Admin_Model extends model
 {
    public $username;

    public function logUser($data, $fields,$session)
    // public function logUser($email, $pass,$session)
    {
        $fieldData = $this->mapFormColumn($fields,$data);
        // $fieldData = array();

        // foreach ($fields as $key => $value) {
        //   if(stripos($value,"encrypt") !== false){
        //     $fieldData[$key] =  md5($data[$key]);   
        //    continue;
        //   }
        //   if(stripos($value,"submit") !== false){
        //    continue;
        //   }
        //   $fieldData[$key] = $data[$key];
        //  }

        //In this case, i dont wont to pass field argument because i need user data
        //In other case you can put null in the field position function or put specific fields
        $result = $this->select("users",  $fieldData,"active = 1")->fetchObj(false);
        if(!empty($result)){
                $this->username = $result->email;
                $session->addSession('username',$this->username);
                $session->addSession('id_user',$result->id_user);// Storing user session value
                return true;
            }
            else
            {
                return false;
            }
    }
    // public function logUser($email, $pass,$session)
    // {
    //     $passSecured = md5($pass);
    //     $stmt = $this->conexion->prepare("SELECT * FROM ".DB_PREFIX."users WHERE email=:email AND pass=:passSecured");
    //     $stmt->bindParam("email", $email,PDO::PARAM_STR);
    //     $stmt->bindParam("passSecured", $passSecured,PDO::PARAM_STR);
    //     $stmt->execute();
    //     $data = $stmt->fetch(PDO::FETCH_OBJ);

    //     //Si tenemos resultados
    //    $count = $stmt->rowCount();
       
    //     if($count)
    //     {
    //         $this->username = $data->email;
    //         $session->addSession('username',$this->username);
    //         $session->addSession('id_user',$data->id_user);// Storing user session value
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     } 
  
    // }

    public function getMap($limit)
    {
        $this->limit = 3;
        $result = $this->select("map", null)->fetchAllArray();   //En este caso, al ser un limit, hacemos un fetchall
        return $result;
    }

 }
