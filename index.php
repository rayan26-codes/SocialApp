<?php
session_start();

require_once "Helpers/Redirect.php";

$page = $_GET['page'] ?? 'login';

require_once "Controllers/AuthController.php";
$authController = new AuthController();

require_once "Controllers/ProfileController.php";
$ProfileController = new ProfileController();

require_once "Controllers/FriendController.php";
$FriendController = new FriendController();

require_once "Controllers/PostController.php";
$PostController = new PostController();

if($page === 'logout'){
    $auth = new AuthController();
    $auth->Logout();
    exit;
}

if (!isset($_SESSION['user_id']) && !in_array($page, ['login', 'signup'])){
    Redirect("login");
}

if (isset($_POST['signup'])){
   $authController->CreateUser();   
}
elseif (isset($_POST['login'])){
   $authController->Login();
}
elseif (isset($_POST['save_changes'])) {
   $ProfileController->UpdateProfile();
}
elseif(isset($_POST['add_friend'])){
   $FriendController->AddFriend();
}
elseif(isset($_POST['accept_request'])){
   $FriendController->AcceptReq();
}
elseif(isset($_POST['reject_request'])){
   $FriendController->RejectReq();
}
elseif(isset($_POST['remove_friend'])){
   $FriendController->RemoveFriend();
}
elseif(isset($_POST['create_posts'])){
   $PostController->CreatePosts();
}
elseif(isset($_POST['like_post'])){
   $PostController->SetPostReac();
}
elseif(isset($_POST['dislike_post'])){
   $PostController->SetPostReac();
}
elseif(isset($_POST['submit_comment'])){
   $PostController->SetPostComm();
}



if ($page == "signup"){
   include "Views/Signup.php";
}
elseif ($page == "login") {
   include "Views/Login.php";
}
elseif ($page == "home") {
   $PostController->LoadPosts();
}
elseif ($page == "profile") {
   $ProfileController->GetProfile();
}
elseif ($page == "friends") {
   $FriendController->LoadFriends();
}
elseif ($page == "CreatePosts") {
   include "Views/CreatePosts.php";
}
else {
   include "Views/Login.php";
}