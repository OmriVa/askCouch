<?php
require 'db.php';
require 'rating.php';
require 'posts.php';

function insertComment($userid, $username, $postid, $content, $parent){
    if(empty($parent)){
        $parent = "NULL";
    }
    else{
        $parent = "'".$parent."'";
    }
    //echo json_encode($parent);
    $sql = "INSERT INTO `tbl_comment` (`comment_id`, `postid`, `parent_comment_id`, `comment`,  `userid`, `date`) VALUES (NULL, '".$postid."', ".$parent.", '".$content."', '".$userid."', CURRENT_TIMESTAMP);";
    $stmt = $GLOBALS['pdo']->prepare($sql)->execute();
    //posts.php function
    increaseReplyCount($postid);
    echo json_encode("*COMMENT SUBMIT SUCSEES");
}

function getPostComments($postid){
    $sql = "SELECT * FROM `tbl_comment` WHERE `postid` ='".$postid."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetchAll();
    return $result;
}

function getPostsIdUserInvolved($userid, $limit){
    $sql = "SELECT DISTINCT `postid` FROM `tbl_comment` WHERE `userid` = '".$userid."'  ORDER BY `postid` DESC LIMIT ".$limit.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetchAll();
    return $result;
}

?>
