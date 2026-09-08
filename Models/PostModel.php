<?php
require_once "config/Database.php";

class PostModel extends Database{

    function GetPosts($filter = ""){
        $user_id = $_SESSION['user_id'];

        if ($filter == "MyPosts") {
             $sql = "SELECT p.post_id, p.post_text, ui.firstname, ui.lastname, ui.profile_pic FROM posts p LEFT JOIN user_info ui ON p.user_id = ui.id WHERE p.user_id = $user_id ORDER BY p.post_id DESC";
        }
        elseif($filter == "FriendsPosts"){
              $sql = "SELECT p.post_id, p.post_text, ui.firstname, ui.lastname, ui.profile_pic FROM posts p LEFT JOIN user_info ui ON p.user_id = ui.id INNER JOIN friends f ON f.friend_id = p.user_id WHERE f.user_id = '$user_id' ORDER BY p.post_id DESC";
        }
        else{
            $sql = "SELECT p.post_id, p.post_text, ui.firstname, ui.lastname, ui.profile_pic FROM posts p LEFT JOIN user_info ui ON p.user_id = ui.id ORDER BY p.post_id DESC";
        }
        
        $data = $this->Query($sql);
        return $data;
    }

    function GetPostImages($PostId){
        $condition = ['column' => "post_id", "value" => $PostId, "op" => "="];
        $Data = $this->table("post_images")->where($condition)->Select("post_image");
        return $Data;
    }

    function CreatePost($Data){
        $InsertId = $this->table("posts")->Insert($Data, true);
        return $InsertId;
    }

    function CreatePostImage($Data){
        $PostImage = $this->table("post_images")->Insert($Data);
        return $PostImage;
    }

    function FetchReactions(){
        $Reac = $this->table("reactions")->orderBy("id", "ASC")->Select();
        return $Reac;
    }

    function SetPostReac($Data){
        $Response = $this->table("post_responses")->Insert($Data);
        return $Response;
    }
    
    function CheckPostReaction($user_id, $post_id){
        $condition = ["column" => "user_id", "value" => $user_id, "op" => "="];
        $condition2 = ["column" => "post_id", "value" => $post_id, "op" => "="];

        $Data = $this->table("post_responses")->where($condition)->Andwhere($condition2)->Select("id, reaction_id");
        return $Data;
    }

    function UpdatePostReaction($id, $reaction_id){
        $Data = ["reaction_id" => $reaction_id];
        $condition = ['column' => "id", "value" => $id, "op" => "="];

        $Result = $this->table("post_responses")->where($condition)->Update($Data);
        return $Result;
    }

    function DeletePostReaction($id){
       $condition = ['column' => "id", "value" => $id, "op" => "="];

        $Result = $this->table("post_responses")->where($condition)->Delete();
        return $Result;
    }

    function GetPostReac($post_id){
        $sql = "SELECT reaction_id, COUNT(*) AS ReacCount FROM post_responses WHERE post_id = ? GROUP BY reaction_id";
        $values = [$post_id];
        $PostReac = $this->Query($sql, "i", $values);
        return $PostReac;
    }

    function SetPostComm($Data){
         $CommAdded = $this->table("comments")->Insert($Data);
         return $CommAdded;
    }

    function GetComments($post_id){
        $sql = "SELECT ui.id,ui.firstname,ui.lastname, ui.profile_pic,c.comment,c.post_id FROM comments c JOIN user_info ui ON ui.id = c.user_id WHERE c.post_id = ? ORDER BY c.id DESC";
        $values = [$post_id];
        $data = $this->Query($sql, "i", $values);
        return $data;
    }
    
}

?>