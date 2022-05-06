<?php
require 'db.php';


function insertNewChatNotifaction($sendFromID,$ownerId){
    $sql = "SELECT COUNT(*) AS count FROM `noticitions` WHERE `userid` = $ownerId AND `link` = 'chat.php?freindId=".$sendFromID."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result['count'] == 0){
        $sql = "INSERT INTO `noticitions` (`id`, `text`, `link`, `read`, `date`, `type`, `userid`) VALUES (NULL, 'הודעה חדשה התקבלה מ -', 'chat.php?freindId=$sendFromID', '', CURRENT_TIMESTAMP, 'chat', '$ownerId');";
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute();
    }
    return $result;
}

function deleteChatNotifaction($readerid){
    $sql = "DELETE FROM `noticitions` WHERE `type` = 'chat' AND `userid` = $readerid";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function getChatNotifactions($userid){
    $sql = "SELECT * FROM `noticitions` WHERE `type` = 'chat' ANd `userid` = $userid;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result= $stmt->fetchAll();
    return $result;
}

function getNotifcationsCount($userid){
    $sql = "SELECT count(*) as count FROM `noticitions` WHERE `userid` = $userid;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}


?>
