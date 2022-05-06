<?php

require 'db.php';


function insertRating($userid,$commentid,$likeOrDislike){
    // likeOrDislike explain :
    // like = 1
    // dislike =2
    $sql = "INSERT INTO `rating` (`likeid`, `userid`, `commentid`, `likeOrDislike`) VALUES (NULL, '".$userid."', '".$commentid."', '".$likeOrDislike."');";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return $sql;
}


function getRatingLikes($commentid){
    // likeOrDislike explain :
    // like = 1
    // dislike =2
    $sql = "SELECT count(*) AS count FROM `rating` WHERE `commentid` = '".$commentid."' AND `likeOrDislike` = '1' ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result;
}

function getRatingDislikes($commentid){
    // likeOrDislike explain :
    // like = 1
    // dislike =2
    $sql = "SELECT count(*) AS count FROM `rating` WHERE `commentid` = '".$commentid."' AND `likeOrDislike` = '2' ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result;
}
function checkIfAlreadyRated($userid,$commentid){
    $sql = "SELECT count(*) AS count FROM `rating` WHERE `userid` = '".$userid."' AND `commentid` = '".$commentid."' ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

function getLikesCountByUserId($userid){
    $sql = "SELECT count(*) AS count FROM `rating` WHERE `userid` = '".$userid."'  AND `likeOrDislike` = 1";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}
function getDislikesCountByUserId($userid){
    $sql = "SELECT count(*) AS count FROM `rating` WHERE `userid` = '".$userid."'  AND `likeOrDislike` = 2";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}
    
?>
