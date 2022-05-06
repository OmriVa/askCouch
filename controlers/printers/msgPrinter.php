<?php
session_start();

require '../msg.php';
//require '../users.php';

function getChat($userId,$friendId){
    $msgs = getMsgs($userId, $friendId);
    $div = "";
    if(sizeof($msgs)>0)
    {
        $lastDate = $msgs[0]['date'];
        $div .= dateDiv($lastDate);
        foreach($msgs as $msg){
            if($lastDate != $msg['date']){
                $lastDate = $msg['date'];
                $div .= dateDiv($lastDate);
            }
            if($msg['senderId'] == $userId)
            {
                $div .= msgDivOfMe($msg['text'],$msg['time']);
            }else{
                $div .= msgDivOfFriend($msg['text'],$msg['time']);
            }
        }
    }
    return $div;
}

function getChatHeader($userId){
    $userLink = getProfileLink($userId);
    $div = "";
    if($userLink){
        $div .= '<div class="d-flex flex-row justify-content-between">';
        $div .= '<h3>שיחה עם '.$userLink.'</h3>';
        $div .= '<a id="openChatList" href="javascript:void(0)" onclick="openChatList()"><i class="fas fa-chevron-left fa-2x"></i></a>';
        $div .= '</div>';
    }

    return $div;
}

function getFriendList($userid){
    $freinds = searchFriends($userid);
    $div ='';
    //var_dump($freinds);
    if(sizeof($freinds)>0){
        foreach($freinds as $friend){
            $div.= getFriendDiv($friend['id']);
        }
    }
    return $div;
}

function getFillterdFriendList($userid,$filterWord){
    $freinds = getFriendsAfterFiler($userid,$filterWord);
    $div ='';
    //var_dump($freinds);
    if(sizeof($freinds)>0){
        foreach($freinds as $friend){
            $div.= getFriendDiv($friend['id']);
        }
    }
    echo $div;
}

function msgDivOfMe($msgText,$time){
    $div="";
    $div.='';
    $div.='<div id="messege" class="d-flex flex-row">';
    $div.='    <div class="p-2 m-1 friendColor active-info rounded" style="width:40%">';
    $div.='        <p class="p-0 m-0">'.$msgText.'</p>';
    $div.='    </div>';
    $div.='    <div class="d-flex align-self-end">';
    $div.='    <p class="m-auto">';
    $div.='        <smal class="bg-light rounded border text-secondary">'.substr($time,0,5).'</smal>';
    $div.='    </p>';
    $div.='    </div>';
    $div.='</div>';
    return $div;
}

function msgDivOfFriend($msgText,$time){
    $div="";
    $div.='';
    $div.='<div id="messege" class="d-flex flex-row-reverse">';
    $div.='    <div class="p-2 m-1 senderColor active-border rounded" style="width:40%">';
    $div.='        <p class="p-0 m-0">'.$msgText.'</p>';
    $div.='    </div>';
    $div.='    <div class="d-flex align-self-end">';
    $div.='    <p class="m-auto">';
    $div.='        <smal class="bg-light rounded border text-secondary">'.substr($time,0,5).'</smal>';
    $div.='    </p>';
    $div.='    </div>';
    $div.='</div>';
    return $div;
}

function dateDiv($date){
    $div = "";
    $div.='<div id="date" class="d-flex justify-content-center">';
    $div.='    <div class="">';
    $div.='        <p class="p-1 m-0 bg-light rounded border text-secondary">'.$date.'</p>';
    $div.='    </div>';
    $div.='</div>';
    return $div;
}
function getFriendDiv($friendId){
    $name = getUserName($friendId)['name'];
    $title = getUserTitle($friendId)['title'];
    $div='';
    $div.='<a href="chat.php?freindId='.$friendId.'">';
    $div.='<div id="friendList" class="text-center w-100 border">';
    $div.='<div class="w-100">';
    $div.='<h5>'.$name.'</h5>';
    if(strlen($title)>0){
        $div.='<h6>'.$title.'</h6>';    
    }
    $div.='</div>';
    $div.='</div>';
    $div.='</a>';
    return $div;
}

function getChatFrame(){
    $div='';
    $div.='<div id="chatHeader">';
    $div.='</div>';
    $div.='<div class="w-100 border mx-0 mb-2" id="chatBox" style="height:330px;overflow:scroll;overflow-x:hidden;">';
    $div.='</div>';
    $div.='<div class="d-flex flex-column">';
    $div.='    <textarea class="w-100" id="chatText"></textarea>';
    $div.='    <button type="submit" name="sendMsg" id="sendMsg" value="sendMsg" class="btn btn-info btn-block btn-lg">שלח</button>';
    $div.='</div>';
    return $div;
}

if(isset($_POST['functionName']))
{
    if($_POST['functionName'] == "getChat")
    {
        $userId = $_SESSION['userid'];
        $friendId = $_POST['friendId'];
        $data = getChat($userId,$friendId);
        //var_dump($data);
        echo json_encode($data);

    }    
    if($_POST['functionName'] == "sendMsg")
    {  
        $userId = $_SESSION['userid'];
        $friendId = $_POST['friendId'];
        $text = $_POST['text'];
        //var_dump($text);
        //var_dump(strlen($text));
        if(trim($text) != '' && strlen($text) > 0){
            insertMsg($userId, $friendId ,$text);
        }
        echo json_encode(getChat($userId,$friendId));
    }
    if($_POST['functionName'] == "getChatHeader")
    {
        $friendId = $_POST['friendId'];
        echo json_encode(getChatHeader($friendId));
    }    
    if($_POST['functionName'] == "getFriendList")
    {
        $userId = $_SESSION['userid'];
        echo json_encode(getFriendList($userId));
    }
    if($_POST['functionName'] == "getFillterdFriendList")
    {
        if(isset($_SESSION['userid'])){
            getFillterdFriendList($_SESSION['userid'],$_POST['filterWord']);
        }

    }
    if($_POST['functionName'] == "getChatFrame")
    {
        if(strlen($_POST['friendId']) > 0){
            $friendId = $_POST['friendId'];
            if(userIdIsValid($friendId)['id'] == $friendId && $_SESSION['userid'] != $friendId){
                echo json_encode(getChatFrame());
            }
        }
        
    }
}
?>
