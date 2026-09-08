<?php
require_once 'Models/Authmodel.php';

class AuthController{

    private $authModel;

    function __construct(){
        $this->authModel = new AuthModel;
    }

    function CreateUser(){
        if (isset($_POST['signup'])) {
           $Data = [
                'firstname' => $_POST['firstname'] ?? null,
                'lastname'  => $_POST['lastname'] ?? null,
                'email'     => $_POST['email'] ?? null,
                'password'  => $_POST['password'] ?? null,
                'age'       => $_POST['age'] ?? null];

           if (preg_match('/[\s0-9@#$%^&*()!<>]/', $Data['firstname'])) {
               $_SESSION['message']= "Firstname cannot contain special characters.";
               $_SESSION['status'] = "error";
               Redirect("signup");        
             }

           if (preg_match('/[\s0-9@#$%^&*()!<>]/', $Data['lastname'])) {
               $_SESSION['message']= "Lastname cannot contain special characters.";
               $_SESSION['status'] = "error";
               Redirect("signup");          
             }
             
           if (strlen($Data['password']) < 4) {
               $_SESSION['message']= "Password Can not be smaller then 4 characters.";
               $_SESSION['status'] = "error";
               Redirect("signup");          
           }  

           if ($Data['password'] !== $_POST['confirm_password']) {
              $_SESSION['message'] = "Passwords do not match.";
              $_SESSION['status'] = "error";
              Redirect("signup");  
           }

           if ($this->authModel->emailExists($Data)) {
               $_SESSION['message']= "email Already exists.";
               $_SESSION['status'] = "error";
              Redirect("signup");   
           }

           $Result = $this->authModel->CreateUser($Data);

           if ($Result) {
              $_SESSION['message']= "Account Created Successfully.";
              $_SESSION['status'] = "success";
              Redirect("signup");  
           }else {
              $_SESSION['message']= "Account not Created Something Went Wrong.";
              $_SESSION['status'] = "error";
              Redirect("signup");  
           }
        }
    }

    function Login(){
        if(isset($_POST['login'])){
        $Data =['email' => $_POST['email'], 'password' => $_POST['password']];

        $User = $this->authModel->Login($Data['email'], $Data['password']);
        if($User){
            $_SESSION['user_id']= $User['id'];
            $_SESSION['firstname']= $User['firstname'];

           Redirect("home");  
        }
        else {
            $_SESSION['message'] = "Incorrect Email Or Password.";
            $_SESSION['status'] = "error";
            Redirect("login");  
        } 
      }
    }  

    function Logout(){
      session_unset();
      session_destroy();
      Redirect("login");  
    }
}
?>