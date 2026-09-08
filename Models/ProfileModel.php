<?php
require_once 'config/Database.php';

class ProfileModel extends Database{

     function GetProfile($id){
        $condition = ["column" => "id", "value" => $id , "op" => "="];
        $data = $this->table("user_info")->where($condition)->Select();
        return $data;
     }

     function UpdateProfile($data, $id){
      $condition = ["column" => "id", "value" => $id , "op" => "="];
      return $this->table("user_info")->where($condition)->Update($data); 
     }
}
?>