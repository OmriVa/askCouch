<?php
//session_start();
require ('./controlers/posts.php');
require ('./controlers/users.php');

function leaderBox($title,$href,$idArray,$titleArray){
    $div ='';
    $div .= '<div class="col-12 col-sm-6 col-lg-12 m-0 p-0">';
    $div .= '<div class="row m-0 p-1">';
    $div .= '<h2 class="d-flex mx-1 px-1 w-100 font-weight-bold " style="border-bottom:1.5px solid #ff790c">'.$title.'</h2>';
    //$div .= '<hr class="active-info m-0 p-0">';
    for($i=0;$i<5;$i++){
        $temp = 0.65 - $i *0.12;
        $div .= '<div class="col-12 d-flex flex-row  m-0 p-1">';
        $div .= '<div class="p-2" style="background:rgba(255, 114, 0, '.$temp.')">';
        $div .= '<h3 class="font-weight-bold">'.(string)($i+1).'</h3>';
        $div .= '</div>';
        $div .= '<div class="col p-2" style="background:rgba(255, 114, 0, '.$temp.')">';
        if(isset($idArray[$i])){
            $div .= '<a href="'.$href.$idArray[$i].'" class="text-dark text-break font-weight-bold ellipses">'.$titleArray[$i].'</a>';
        }
        $div .= '</div>';
        $div .= '</div>';
    }
    $div .= '</div>';
    $div .= '</div>';
    return $div;
}

function getLeaderBord(){
    $div = "";
    $div .= '<div class="row m-0 p-0">';
    //2 box in a row
    $data = getTheMostPosts();
    $idArray= array();
    $titleArray= array();
    foreach($data as $row){
        array_push($idArray,$row['userid']);
        array_push($titleArray ,getUserName($row['userid'])['name']);
    }
    $div .= leaderBox("הכי פעילים","profile.php?profileId=", $idArray, $titleArray);

    
    $data = getTheMostViews();
    $idArray= array();
    $titleArray= array();
    foreach($data as $row){
        array_push($idArray,$row['postid']);
        array_push($titleArray,$row['title']);
    }
    $div .= leaderBox("פוסטים פופלרים","getpost.php?Id=", $idArray, $titleArray);
    $div .= '</div>';
    echo $div;
}


?>
