<?php
require 'db.php';

function createPost($content, $title, $userid) {
    $sql = "INSERT INTO `posts` (`postid`, `title`, `text`, `edit`, `userid`, `date`, `reply`, `likes`, `dislikes`) VALUES (NULL, '".$title."', '".$content."', '', '".$userid."', CURRENT_TIMESTAMP, '0', '0', '0');";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $sql2 = "SELECT `postid` FROM `posts` WHERE `postid` = (SELECT MAX(`postid`) FROM `posts` WHERE `userid` =  ".$userid.")";
    $stmt = $GLOBALS['pdo']->prepare($sql2);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['postid'];
}

function getPostById($postId) {
    $sql = "SELECT * FROM `posts` WHERE `postid` = ".$postId." ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result= $stmt->fetch();
    addViewCount($postId);
    return $result;
}

function updatePost($userid,$id,$title,$content){
    $sql = "UPDATE `posts` SET `text` = '$content', `title` = '$title' WHERE `posts`.`postid` = $id;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function searchPosts($search,$limit) {
    //seprate the words into array of words so it can search 1 by 1.
    $words = explode(" ", html_entity_decode($search));
    $result = [];
    foreach($words as $word){
        $sql = "SELECT a.`title` ,a.`postid` ,a.`date`,a.`reply`,a.`views` , b.`name` FROM `posts` AS a INNER JOIN `users` AS b ON a.`userid` = b.`userid` WHERE a.`title` LIKE '%".$word."%' LIMIT ".$limit." ;";
        /*foreach($result as $user){
            $sql .= " AND `userid` != '".$user['userid']."'";
            // verfiy that will not get duplicated results
        }*/
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute();
        $result= array_merge($result,$stmt->fetchAll());// merge the new result with the old.
    }
    $result = array_map("unserialize", array_unique(array_map("serialize", $result)));
    //$sql = "SELECT a.* , b.`name` FROM `posts` AS a INNER JOIN `users` AS b ON a.`userid` = b.`userid` WHERE a.`title` = ".$keyword." LIMIT ".$limit." ;";
    //$stmt = $GLOBALS['pdo']->prepare($sql);
    //$stmt->execute();
    //$result= $stmt->fetchAll();
    return $result;
}

function addViewCount($postId){
    $sql = "UPDATE `posts` SET `views` = `views` + '1' WHERE `posts`.`postid` = ".$postId.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function gettAllPosts() {
    $sql = "SELECT COUNT(*) FROM `posts`;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}

function getPostCount(){
    $sql = "SELECT count(*) AS count FROM `posts` ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}
function getPostsByRange($start, $end) {
    $count = getPostCount()['count'];
    $sql = "SELECT `views`,`postid`,`title`, date(`date`) AS date, `reply`, TIMESTAMPDIFF(HOUR, `date`, now()) AS hours, TIMESTAMPDIFF(MINUTE, `date`, now()) AS minutes, `userid` FROM `posts` WHERE `postid` ORDER BY `postid` DESC LIMIT ".$start.",".$end."";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}

function getPostsCount(){
    $sql = "SELECT count(*) AS count FROM `posts`";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result= $stmt->fetch();
    return $result;
}

function increaseReplyCount($postId){
    $sql = "UPDATE `posts` SET `reply` = `reply` + 1 WHERE `posts`.`postid` = ".$postId.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function getTheMostPosts(){
    $sql = "SELECT `userid`, count(*) FROM `posts` WHERE `userid` = `userid` GROUP BY `userid` ORDER BY count(*) DESC LIMIT 5";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}
function getTheMostViews(){
    $sql = "SELECT `postid`, `title`, `views` FROM `posts`  GROUP BY `postid` ORDER BY `views` DESC LIMIT 5";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;
}
function getPostTitleById($postid){
    $sql = "SELECT `title` FROM `posts` WHERE `postid` = ".$postid.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}

function getPostsCountByUserId($userid){
    $sql = "SELECT COUNT(*) AS count FROM `posts` WHERE `userid` = ".$userid.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}

function getPostsOfUserId($userid, $limit){
    $sql = "SELECT `views`,`postid`,`title`, date(`date`) AS date, `reply`, TIMESTAMPDIFF(HOUR, `date`, now()) AS hours, TIMESTAMPDIFF(MINUTE, `date`, now()) AS minutes, `userid` FROM `posts` WHERE `userid` = '".$userid."' ORDER BY `postid` DESC LIMIT  ".$limit;
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetchAll();
    return $data;

}

function getPostsUserInvolvedByPostId($postid){
    $sql = "SELECT `views`,`postid`,`title`, date(`date`) AS date, `reply`, TIMESTAMPDIFF(HOUR, `date`, now()) AS hours, TIMESTAMPDIFF(MINUTE, `date`, now()) AS minutes, `userid` FROM `posts` WHERE `postid` = '".$postid."' ORDER BY `postid` DESC";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;

}
