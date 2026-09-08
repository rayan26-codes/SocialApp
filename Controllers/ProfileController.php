<?php
require_once 'Models/ProfileModel.php';

class ProfileController{
    
    private $ProfileModel;

    function __construct(){
        $this->ProfileModel = new ProfileModel;
    }

    function GetProfile(){
        $ProfileData = $this->ProfileModel->GetProfile($_SESSION['user_id']);
        include 'Views/Profile.php';
    }

    function UpdateProfile(){ 
       if (isset($_POST["save_changes"])) {
         $data =["firstname" => $_POST['firstname'], "lastname" => $_POST['lastname'], "age" => $_POST['age'] ];
         
         if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === 0) {

            $filename=$_FILES['profile_pic']['name'];
            $tmp_name=$_FILES['profile_pic']['tmp_name'];
            $filesize=$_FILES['profile_pic']['size'];

            if (getimagesize($tmp_name) === false) {
                return $_SESSION['isError']= "File is not an image.";
            } 

            if ($filesize > 2 * 1024 * 1024) {
                return $_SESSION['isError']= "File size can not be bigger then 2MB."; 
            }

            $extension= strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed=['jpg','jpeg','png','gif'];
            if (!in_array($extension, $allowed)) {
                return $_SESSION['isError']= "Invalid Image Format.";
            }

            $user_id = $_SESSION['user_id'];
            $newfilename= "userID_" . $user_id . "_" . $filename;
            $folder= "Assets/Profiles/";  

            $uploaded_file= move_uploaded_file($tmp_name, $folder . $newfilename); 
            if ($uploaded_file) {
                $_SESSION['isSuccess']= "Image uploaded successfully.";
                $data["profile_pic"] = $newfilename;
            }
         }
         $Updated = $this->ProfileModel->UpdateProfile($data, $_SESSION['user_id']);
         if($Updated) {
           Redirect("profile");
         }
      } 
   }
}
?>