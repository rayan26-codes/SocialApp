<?php
require_once 'config/Database.php';

class AuthModel extends Database{
    function CreateUser($Data){
        $Data['password'] = password_hash($Data['password'], PASSWORD_DEFAULT);
        return $this->table("user_info")->Insert($Data);
    }

    function emailExists($data){
        $conditions = ["column" => "email", "value" => $data['email'] , "op" => "="];
        $Data = $this->table("user_info")->where($conditions)->Select();
        if(!empty($Data)){
          return true;
        }else{
          return false;
        }
    }

     function Login($email, $password){
        $conditions = ["column" => "email", "value" => $email , "op" => "="];
        $user = $this->table("user_info")->where($conditions)->Select();
            if(!empty($user)){
              if(password_verify($password, $user[0]['password'])){
                return $user[0];
              }
            }  
                return false;
         }
     }
?>