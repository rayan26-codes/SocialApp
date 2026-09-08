<?php
require_once "Models/FriendModel.php";

class FriendController{

    private $FriendModel;

    function __construct(){
        $this->FriendModel = new FriendModel;
    }

    function LoadFriends(){
        $UserData = $this->FriendModel->GetUsers();
        $ReqData  = $this->FriendModel->GetReq();
        $FriendsList = $this->FriendModel->GetFriends();
        include "Views/Friends.php";
    }

    function AddFriend(){
        if(isset($_POST['add_friend'])) {
           $Data = ["receiver_id" => $_POST['receiver_id'], "sender_id" => $_SESSION['user_id']]; 
           $this->FriendModel->AddFriend($Data);
        }
    }

    function GetReq(){
        $data = $this->FriendModel->GetReq();
        return $data;
    }

    function AcceptReq(){ 
        if(isset($_POST['accept_request'])){
          $Accept = ['request_id' => $_POST['request_id']];
          $this->FriendModel->AcceptReq($Accept);
        }
    }

    function RejectReq(){
        if(isset($_POST['reject_request'])){
          $Reject = ["request_id" => $_POST['request_id']];  
          $this->FriendModel->RejectReq($Reject);
        }
    } 

    function GetFriends(){
        $data = $this->FriendModel->GetFriends();
        return $data;
    }

    function RemoveFriend(){
        if(isset($_POST['remove_friend'])){
          $RemoveFriend = ["friend_id" => $_POST['friend_id']];  
          $this->FriendModel->RemoveFriend($RemoveFriend);
        }
    }

}

?>