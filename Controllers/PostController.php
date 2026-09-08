<?php
require_once "Models/PostModel.php";

class PostController{

     private $PostModel;

    function __construct(){
        $this->PostModel = new PostModel;
    }

    function LoadPosts(){
        if (isset($_POST['all_posts'])) {
            $Filter = "AllPosts";
        }
        elseif (isset($_POST['My_posts'])) {
            $Filter = "MyPosts";
        }
        elseif (isset($_POST['friends_posts'])) {
            $Filter = "FriendsPosts";
        }
        else {
            $Filter = "AllPosts";
        }

        $PostData = $this->PostModel->GetPosts($Filter);
        $Reactions = $this->PostModel->FetchReactions();

        $Posts = [];
        foreach($PostData as $key => $PostDetails){
            $PostDetails['images'] = $this->PostModel->GetPostImages($PostDetails['post_id']);
            $PostDetails['comments'] = $this->PostModel->GetComments($PostDetails['post_id']);

            $PostDetails['CommCount'] = 0;
            foreach($PostDetails['comments'] as $Commkey => $CommValue) {
                $PostDetails['CommCount']++;
            }
                    
            $PostReac = $this->PostModel->GetPostReac($PostDetails['post_id']);

            $PostDetails['LikeCount'] = 0;
            $PostDetails['DislikeCount'] = 0;
            foreach ($PostReac as $Reackey => $Reacvalue) {
                if ($Reacvalue['reaction_id'] == 1) {
                    $PostDetails['LikeCount'] = $Reacvalue['ReacCount'];
                }
                if($Reacvalue['reaction_id'] == 2){
                    $PostDetails['DislikeCount'] = $Reacvalue['ReacCount'];
                }
            }
            $Posts[] = $PostDetails;
        }
        $PostData = $Posts;
    
        include "Views/Home.php";
    }

    function CreatePosts(){
        if(isset($_POST['create_posts'])){
            $Data = [
                 "user_id" => $_SESSION['user_id'],
                 "post_text" => $_POST['post_text']
                                                    ];

            $Images = $_FILES['post_images'] ?? null;
            $PostImages = [];

            if($Images !== null && isset($Images['name'])){
            for($i=0; $i < count($Images["name"]) ; $i++){ 
              $FileName= $Images['name'][$i];
              $TmpName= $Images['tmp_name'][$i];
              $FileSize= $Images['size'][$i];
              $Error= $Images['error'][$i];

              if (!empty($FileName)){
                if ($Error === 0) {
                  if (getimagesize($TmpName) === false) {
                        return $_SESSION['isError']= "File is not an image.";
                        exit;
                    } 

                    if ($FileSize > 2 * 1024 * 1024) {
                        return $_SESSION['isError']= "File size can not be bigger then 2MB."; 
                        exit;
                    }

                    $Extension= strtolower(pathinfo($FileName, PATHINFO_EXTENSION));
                    $Allowed=['jpg','jpeg','png','gif'];
                    if (!in_array($Extension, $Allowed)) {
                        return $_SESSION['isError']= "Invalid Image Format.";
                        exit;
                    }

                    $NewFileName= "userID_" . $_SESSION['user_id'] . "_" . $FileName;
                    $Folder= "Assets/Posts/";

                    $UploadFile= move_uploaded_file($TmpName, $Folder . $NewFileName); 
                    if ($UploadFile) {
                        $PostImages[]= $NewFileName;
                    }
                  }
                }
              }
            }

             $PostId = $this->PostModel->CreatePost($Data);

             if ($PostId) {
                if (!empty($PostImages)) {
                    foreach($PostImages as $Postkey => $Postvalue){
                        $ImageData = [
                            "user_id" => $_SESSION['user_id'],
                            "post_id" => $PostId,
                            "post_image" => $Postvalue
                            ];

                            $this->PostModel->CreatePostImage($ImageData);
                    }
                }
                $_SESSION['isSuccess'] = "Post Created successfully.";
                Redirect("home");
             }
         }  
     }

     function SetPostReac(){
        if(isset($_POST['like_post']) || isset($_POST['dislike_post'])){
            $post_id = $_POST['post_id'];
            $reaction_id = $_POST['reaction_id'];
            $user_id = $_SESSION['user_id'];

            $CurrentReaction = $this->PostModel->CheckPostReaction($user_id, $post_id);

            if(!empty($CurrentReaction)){
                if($CurrentReaction[0]['reaction_id'] == $reaction_id){
                    $this->PostModel->DeletePostReaction($CurrentReaction[0]['id']);
                }
                else{
                    $this->PostModel->UpdatePostReaction($CurrentReaction[0]['id'], $reaction_id);
                }
            }
            else{
                $Data = ["user_id" => $user_id, "post_id" => $post_id, "reaction_id" => $reaction_id];

                $this->PostModel->SetPostReac($Data);
            }
            Redirect("home");
        }
    }

    function SetPostComm(){
        if(isset($_POST['submit_comment'])){
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];
            $comment_text = $_POST['comment_text'];

            $Data = ["user_id" => $user_id, "post_id" => $post_id, "comment" => $comment_text];

            $CommAdded = $this->PostModel->SetPostComm($Data);
            Redirect("home");
        }
    }



}
?>