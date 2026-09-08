<?php
require_once "config/Database.php";

class FriendModel extends Database{

    function GetUsers(){
        $sql = "SELECT ui.id, ui.firstname, ui.profile_pic FROM user_info ui LEFT JOIN friend_requests fr ON ((fr.sender_id= ? AND fr.receiver_id = ui.id) OR (fr.receiver_id= ? AND fr.sender_id = ui.id)) WHERE ui.id != ? AND fr.id IS NULL";

        $values = [ $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'] ];

        $data = $this->Query($sql, "iii", $values);
        return $data;
    }

    function GetStatus(){
        $data = $this->table("friend_req_status")->orderBy("id", "ASC")->Select();
        return $data;
    }

    function AddFriend($Data){
        $user_id = $Data['user_id'];
        $ReceiverId = $Data['receiver_id'];
        $ReqStatus = $this->GetStatus();
        $Data['status'] = $ReqStatus[0]['id'];

        $sql ="SELECT * FROM friend_requests WHERE ((sender_id= ? AND receiver_id= ?) OR (sender_id= ? AND receiver_id= ?)) AND status != ?";

        $values = [$user_id, $ReceiverId, $ReceiverId, $user_id, $ReqStatus[0]['id']];

        $data = $this->Query($sql, "iiiii", $values);
        if(empty($data)) {
          $result = $this->table("friend_requests")->Insert($Data);
           if($result){
             $_SESSION['message']= "Request sent Successfully.";
             $_SESSION['status']= "success";
           }
             Redirect("friends");
        }
    }

    function GetReq(){
        $user_id = $_SESSION['user_id'];
        $ReqStatus = $this->GetStatus();
        $pendingStatus = $ReqStatus[0]["id"];

        $sql ="SELECT fr.id, fr.sender_id, fr.receiver_id, fr.status, ui.firstname FROM friend_requests fr JOIN user_info ui ON fr.sender_id = ui.id WHERE fr.receiver_id= ? AND fr. status= ?";
        $values = [$user_id, $pendingStatus];
        $data = $this->Query($sql, "ii", $values);
        return $data;
    }

    function AcceptReq($Accept){
        $user_id = $_SESSION['user_id'];
        $ReqStatus = $this->GetStatus();

        $pendingStatus = $ReqStatus[0]["id"];
        $acceptedStatus = $ReqStatus[1]["id"];
        $requestId = $Accept['request_id'];

        $conditions1 = ["column" => "id", "value" => $requestId, "op" => "="];
        $conditions2 = ["column" => "receiver_id", "value" => $user_id, "op" => "="];
        $conditions3 = ["column" => "status", "value" => $pendingStatus, "op" => "="];
        $request = $this->table("friend_requests")->where($conditions1)->Andwhere($conditions2)->Andwhere($conditions3)->Select("sender_id");

        if(empty($request)){
          $_SESSION['message'] = "Invalid friend request.";
          $_SESSION['status'] = "error";
          Redirect("friends");
          return; 
        }

        $senderId = $request[0]["sender_id"];

        $data = ['status' => $acceptedStatus];
        $UPconditions1 = ["column" => "id", "value" => $requestId, "op" => "="];
        $UPconditions2 = ["column" => "receiver_id", "value" => $user_id, "op" => "="];
        $UPconditions3 = ["column" => "status", "value" => $pendingStatus, "op" => "="];

        $result = $this->table("friend_requests")->where($UPconditions1)->Andwhere($UPconditions2)->Andwhere($UPconditions3)->Update($data);

      // for two way relation btw friends
        //Relation 1
        $FriendData1 = ["user_id" => $user_id, "friend_id" => $senderId];
        $FriendResult1 = $this->table("friends")->Insert($FriendData1);
        //Relation 2
        $FriendData2 = ["user_id" => $senderId, "friend_id" => $user_id];
        $FriendResult2 = $this->table("friends")->Insert($FriendData2);

        if($FriendResult1 && $FriendResult2){
          $_SESSION['message']= "Request Accepted.";
          $_SESSION['status']= "success";
        }

        Redirect("friends");
    }

    function RejectReq($Reject){
        $conditions = ["column" => "id", "value" => $Reject['request_id'], "op" => "="];
        $result = $this->table("friend_requests")->where($conditions)->Delete();
        if($result){
          $_SESSION['message'] = "Request Deleted.";
          $_SESSION['status']  = "success";
        }
        Redirect("friends");
    }

    function GetFriends(){
        $user_id = $_SESSION['user_id'];

        $sql ="SELECT ui.id, ui.firstname, ui.lastname, ui.profile_pic, f.friend_id, f.user_id FROM user_info ui JOIN friends f ON ui.id = f.friend_id WHERE f.user_id= ?";

        $values = [$user_id];
        $data = $this->Query($sql, "i", $values);
        return $data;
    }

    function RemoveFriend($RemoveFriend){
        $user_id = $_SESSION['user_id'];
        $friendId = $RemoveFriend['friend_id'];
        $ReqStatus = $this->GetStatus();
        $acceptedStatus = $ReqStatus[1]["id"];

        $DeleteFriend ="DELETE FROM friends WHERE (user_id= ? AND friend_id= ?) OR (user_id= ? AND friend_id= ?)";
        $FriendValues = [$user_id, $friendId, $friendId, $user_id];
        $DeleteFriendRes = $this->Execute($DeleteFriend, "iiii", $FriendValues);

        $DeleteFriendReq ="DELETE FROM friend_requests WHERE ((sender_id= ? AND receiver_id= ?) OR (sender_id= ? AND receiver_id= ?)) AND status= ?";
        $ReqValues = [$user_id, $friendId, $friendId, $user_id, $acceptedStatus];
        $DeleteFriendReqRes = $this->Execute($DeleteFriendReq, "iiiii", $ReqValues);

        if($DeleteFriendRes && $DeleteFriendReqRes){
          $_SESSION['message'] = "Freind Removed.";
          $_SESSION['status']  = "success";  
        }
          Redirect("friends");
    }
}
?>