<?php
function Redirect($page){
    header("Location: index.php?page=". $page);
    exit;
}
?>