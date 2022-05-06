<?php
include ('./controlers/users.php');

if (isset($_GET['userId'])) {
    $userid = $_GET['userId'];
    $img = getUserData("picture", $userid)['picture'];
    if($img){
        echo '<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>';
    }
}

?>
