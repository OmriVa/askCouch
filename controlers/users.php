<?php
require 'db.php';



// RANKSYSTEM
// 0 - BAN.
// 1 - NORAML USER
// 2 - ADVISOR WITH TITLE
// 3 - ADVISOR WITH TITLE AND ACCSES TO PUBLISH ARTICLES
// 4 - LOW LEVEL ADMIN
// 5 = SYSTEM MANAGER


function getAllUser(){
    $sql = "SELECT * FROM `users`";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetchAll();
    return $result;
}

function getUserById($userid){
    $sql = "SELECT * FROM `users` WHERE `userid` = ".$userid.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    return $result;
}

function getUsersByRange($start,$end){
    $sql = "SELECT * FROM `users` WHERE `userid` BETWEEN '$start' AND '$end';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetchAll();
    return $result;
}

function setUserData($columName, $insertData, $userId){
    $sql = "UPDATE `users` SET `".$columName."` = '$insertData' WHERE `userid` = '$userId'";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    return $sql;
}
function getUserData($columName, $userId){
    $sql = "SELECT `".$columName."` FROM `users` WHERE `userid` = '".$userId."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    return $result;
}
function searchUser($search,$limit){
    //seprate the words into array of words so it can search 1 by 1.
    $words = explode(" ", $search);
    $result = [];
    foreach($words as $word){
        $sql = "SELECT * FROM `users` WHERE `userid` LIKE '%$word%' OR `email` LIKE '%$word%' OR `name` LIKE '%$word%'";
        foreach($result as $user){
            $sql .= " AND `userid` != '".$user['userid']."'";
            // verfiy that will not get duplicated results
        }
        $sql .= "LIMIT ".$limit." ;";
        //echo $sql;
        //echo '<br>';
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute();
        $result= array_merge($result,$stmt->fetchAll());// merge the new result with the old.
    }
    $result = array_map("unserialize", array_unique(array_map("serialize", $result)));
    return $result;
}

function getProfileLink($userid){
    $userName = getUserName($userid)['name'];
    $div = "";
    if(isset($userName)){
        $div .= '<a href="profile.php?profileId='.$userid.'">'.$userName.'</a>';
    }
    return $div;
}

function getUserName($userid){
    $sql = "SELECT `name` FROM `users` WHERE `userid` = '".$userid."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    if($result['name']==''){
        $result['name']="משתמש לא קיים יותר" ;
    }
    return $result;
}

function userIdIsValid($userid){
    $sql = "SELECT `userid` AS `id` FROM `users` WHERE `userid` = '".$userid."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    return $result;
}

function getAdvisers($start, $end){
    //START FROM 0 - PAY ATTTENTION
    $sql = "SELECT * FROM `users` WHERE `rank` BETWEEN 2 AND 3 ORDER BY `userid` LIMIT $start,$end ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetchAll();
    return $result;
}
function getAdvisersCount(){
    $sql = "SELECT count(*) AS count FROM `users` WHERE `rank` BETWEEN 2 AND 3";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}


function getUserTitle($userid){
    $sql = "SELECT `title` FROM `users` WHERE `userid` = '".$userid."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    return $result;
}
function checkIfEmailAlreadyUsed($email){
    $sql = "SELECT count(*) as count FROM `users` WHERE `email` = '$email';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();

    $result= $stmt->fetch();
    
    return $result;
}

function regFastRegister($username,$email,$pass){
    $sql = "INSERT INTO `users` (`userid`, `name`, `email`, `password`, `title`, `birthday`, `info`, `stamp`, `rank`, `createdata`, `picture`) VALUES (NULL, ?, ?, ?, NULL, CURRENT_TIMESTAMP, NULL, NULL, '1', CURRENT_TIMESTAMP, NULL);";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    //$stmt->bindValue(":username", $username);
    //$stmt->bindValue(":email", $email);
    //$stmt->bindValue(":password", md5($pass));
    
    //Execute.
    $stmt->execute(array($username,$email,md5($pass)));
    $result = $GLOBALS['pdo']->lastInsertId();
    
    //If the signup process is successful.
    if($result){
        return $result;
    }
}

?>
