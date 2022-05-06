<?php
session_start();
require '../notifications.php';
require '../users.php';


function getNotifactions(){
    $notifactions = getChatNotifactions($_SESSION['userid']);
    $div = "";
    $div .='';
    $div .='<h1>התראות</h1>';
    $div .='<hr class="active-info">';
    $div .='<div class="row m-0"><ul>';
    if(isset($notifactions)){
        foreach($notifactions as $not){
            $div .= '<li><a href="'.$not['link'].'">'.$not['text'].getUserName(substr($not['link'],18))['name'].'</a></li>';
        }    
    }else{
        $div .= '<li><h3>אין כרגע התראות</h3></li>';
    }
    $div .='</ul></div>';
    echo $div;
}



//functionName: "getNotifactions"
if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "getNotifactions"){
        getNotifactions();
    }
}
?>
