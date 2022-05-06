<?php
require 'db.php';
require 'users.php';
require 'notifications.php';

 
function insertMsg($senderId, $targetId, $text) {
    $sql = "INSERT INTO `msg` (`id`, `text`, `date`, `senderId`, `tagetId`) VALUES (NULL, '".$text."', CURRENT_TIMESTAMP, '".$senderId."', '".$targetId."');";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    //insertNewChatNotifaction($chatId,$ownerId,$userName)
    insertNewChatNotifaction($senderId,$targetId);
    return;
}

function getMsgs($userid, $friendId) {
    $sql = "SELECT *,cast(`date` as time) AS time,cast(`date` as date) AS date FROM `msg` WHERE (`senderId` = ".$userid." AND `tagetId` = ".$friendId.") OR (`senderId` = ".$friendId." AND `tagetId` = ".$userid.") ";
    //$sql = "SELECT *,cast(`date` as time) AS time,cast(`date` as date) AS date FROM `msg` WHERE (`senderId` = 14 AND `tagetId` = 1) OR (`senderId` = 1 AND `tagetId` = 14) "
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    deleteChatNotifaction($userid);
    return $data;
}

function searchFriends($userid){
    $sql = "SELECT DISTINCT REPLACE (CONCAT(`senderId`, `tagetId`), ".$userid.", '') AS `id` FROM `msg`  WHERE `senderId` = ".$userid." OR `tagetId` = ".$userid." ;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    //Execute.
    $stmt->execute();
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}

function getFriendsAfterFiler($userid,$filterWord){
    $sql ="SELECT DISTINCT REPLACE (CONCAT(msg.senderId, msg.tagetId), $userid, '') AS `id` FROM `msg` INNER JOIN `users` as u ON u.userid = msg.tagetId INNER JOIN `users` as u2 ON u2.userid = msg.senderId WHERE (msg.senderId = $userid OR msg.tagetId = $userid) AND (u2.name LIKE '%$filterWord%' OR u.name Like '%$filterWord%')";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    //Execute.
    $stmt->execute();
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}

function getCommentCountByUserId($userid){
    //SELECT COUNT(*) AS count FROM `tbl_comment` WHERE `userid` = 14
    $sql = "SELECT COUNT(*) AS count FROM `tbl_comment` WHERE `userid` = ".$userid.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    //Execute.
    $stmt->execute();
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}

function rankRedirect($url,$userRank,$minRank){
    if($userRank < $minRank){
        header('Location: index.php');
    }
}
?>
