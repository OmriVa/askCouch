<?php
require 'db.php';

$articleTemp = str_replace('/',DIRECTORY_SEPARATOR,"../../uploads/article/tmp/");
$articleMain = str_replace('/',DIRECTORY_SEPARATOR,"../../uploads/article/main/");

function insertArticle($userid,$title,$subtitle,$text,$imgfolder){
    $sql = "INSERT INTO `articles` (`articleid`, `userid`, `title`, `subtitle`, `text`, `imgfolder`, `managerId`, `createDate`, `aproveDate`) VALUES (NULL, '$userid', '$title', '$subtitle', '$text', '$imgfolder', NULL , CURRENT_TIMESTAMP, NULL);";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    //Get the articleId
    $last_id = $GLOBALS['pdo']->lastInsertId();
    //move the file to permanent folder with the name of the articleid.
    $src = $GLOBALS['articleTemp']."$userid/";
    $dsc = $GLOBALS['articleMain']."$last_id/";
    moveAllfilesToMainFolder($src, $dsc);
    //Text process after move imgs to permanent folder
    $text = str_replace("tmp/$userid","main/$last_id",$text);
    $sql = "UPDATE `articles` SET `text` = '".$text."' WHERE `articles`.`articleid` = ".$last_id.";";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return $last_id;
}

function getArticle($articleid){
    $sql = "SELECT * FROM `articles` WHERE `articleid` = '".$articleid."';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

function getArticleByRange($start,$end){
    if(isset($_SESSION['rank'])){
        if($_SESSION['rank'] >= 4){
            $sql = "SELECT * FROM `articles` ORDER BY `articleid` DESC LIMIT ".$start.",".$end." ;";
        }else{
            $sql = "SELECT * FROM `articles` WHERE `articleid` IS NOT NULL OR `userid` = ".$_SESSION['userid']." ORDER BY `aproveDate` DESC LIMIT ".$start.",".$end." ;";
        }
    }else{
        $sql = "SELECT * FROM `articles` WHERE `articleid` IS NOT NULL ORDER BY `aproveDate` DESC LIMIT ".$start.",".$end." ;";
        
    }
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getArticleCount(){
    if(isset($_SESSION['rank']) && isset($_SESSION['userid'])){
        if($_SESSION['rank'] >= 4){
            $sql = "SELECT count(*) AS count FROM `articles`";
        }else{
            $sql = "SELECT count(*) AS count FROM `articles` WHERE `aproveDate` IS NOT NULL OR `userid` = ".$_SESSION['userid'].";";
        }
    }else{
        $sql = "SELECT count(*) AS count FROM `articles` WHERE `aproveDate` IS NOT NULL ;";
    }
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $data = $stmt->fetch();
    return $data;
}

function getArticleByRangeAndAprove($start,$end){
    $sql = "SELECT * FROM `articles` WHERE `aproveDate` IS NOT NULL ORDER BY `articleid` DESC LIMIT ".$start.",".$end." ;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getWaitingList(){
    $sql = "SELECT * FROM `articles` WHERE `aproveDate` IS NULL";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function updateArticle($userid,$id,$title,$subtitle,$content){
    $sql = "UPDATE `articles` SET `text` = '$content', `subtitle` = '$subtitle', `title` = '$title' WHERE `articles`.`articleid` = $id;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function aproveArticle($articleid){
    $sql = "UPDATE `articles` SET `managerId` = '".$_SESSION['userid']."', `aproveDate` = CURRENT_TIMESTAMP WHERE `articles`.`articleid` = $articleid;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function cancelAproveArticle($articleid){
    $sql = "UPDATE `articles` SET `managerId` = NULL , `aproveDate` = NULL  WHERE `articles`.`articleid` = $articleid;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function uploadImgs($data,$userid,$target,$articleid){
    //var_dump($_FILES);
    $fileNameArray = array();
    if(count($_FILES) == 0) {
        echo 'לא הועלה שום קובץ';
        return;
    }
    $str = str_replace('\\', '/', __DIR__);
    $homeDir = str_replace('/controlers', '', $str);
    if($target == "tmp"){
        //$upldPath = $homeDir ."/uploads/article/tmp/$userid/";
        $upldPath = $GLOBALS['articleTemp']."$userid/";
    }  
    else{
        $upldPath = $GLOBALS['articleMain']."$articleid/";
    }
    

    
    if (!is_dir($upldPath)) {
        //mkdir($upldPath);
        if (!mkdir($upldPath,0755, true)) {
            $error = error_get_last();
            echo $error['message'];
        }
    }

    // Count # of uploaded files in array
    $total = count($_FILES['pictures']['name']);
    
    //
    // check all the files are valid!
    // 
    for($i=0 ; $i < $total ; $i++ ) {
        //$name = $_FILES['pictures']['name'][$i];
        $name = $i + 1 .".". pathinfo($_FILES['pictures']['name'][$i], PATHINFO_EXTENSION);
        //Get the temp file path
        $tmpFilePath = $_FILES['pictures']['tmp_name'][$i];
        // Check file size
        if ($tmpFilePath > 2500000) {
            return "מצטערים, הגודל המקסימלי של קובץ הוא 2.5 MB.";
            exit;
        }
        //Make sure we have a file path
        if ($tmpFilePath != ""){
            //Setup our new file path
            $newFilePath = $upldPath . $name;
            //check file extansion is valid
            $imageFileType = strtolower(pathinfo($newFilePath,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "סליחה, רק קבצים מסוג jpg,gif,png,jpeg מותרים.";
                exit;
            }   
        }
    }
    
    //
    // clear folder before upload(delete all files in folder);
    //
    $deleteList = glob($upldPath.'*');
    if($deleteList){
        foreach($deleteList as $file){ // iterate files
            if(is_file($file)){
                unlink($file); // delete file
            }
        }
    }
    
    //
    // upload all files after check that they are valid and clear the folder!
    // 
    for($i=0 ; $i < $total ; $i++ ) {
        //$name = $_FILES['pictures']['name'][$i];
        $name = $i + 1 .".". pathinfo($_FILES['pictures']['name'][$i], PATHINFO_EXTENSION);
        //Get the temp file path
        $tmpFilePath = $_FILES['pictures']['tmp_name'][$i];
        //Make sure we have a file path
        if ($tmpFilePath != ""){
            //Setup our new file path
            $newFilePath = $upldPath . $name;
            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                //Handle other code here
                array_push($fileNameArray, $name);
                //echo 'Upload successful!';
            }
        }
    }
    // Loop through each file
    /*for($i=0 ; $i < $total ; $i++ ) {
        //$name = $_FILES['pictures']['name'][$i];
        $name = $i + 1 .".". pathinfo($_FILES['pictures']['name'][$i], PATHINFO_EXTENSION);
        //Get the temp file path
        $tmpFilePath = $_FILES['pictures']['tmp_name'][$i];
        // Check file size
        if ($tmpFilePath > 2500000) {
            return "מצטערים, הגודל המקסימלי של קובץ הוא 2.5 MB.";
            exit;
        }
        //Make sure we have a file path
        if ($tmpFilePath != ""){
            
            //Setup our new file path
            $newFilePath = $upldPath . $name;
            //check file extansion is valid
            $imageFileType = strtolower(pathinfo($newFilePath,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "סליחה, רק קבצים מסוג jpg,gif,png,jpeg מותרים.";
                exit;
            }   
            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                //Handle other code here
                array_push($fileNameArray, $name);
                //echo 'Upload successful!';
            }
        }
    }
    */
    return $fileNameArray;
}

function replaceImage($data,$imgNumber,$articleid){
    $str = str_replace('\\', '/', __DIR__);
    $homeDir = str_replace('/controlers', '', $str);
    $upldPath = $homeDir ."/uploads/article/main/$articleid/";
    
    //echo $upldPath;
    if (!is_dir($upldPath)) {
        //mkdir($upldPath);
        if (!mkdir($upldPath,0755, true)) {
            $error = error_get_last();
            echo $error['message'];
        }
    }
    
    $deleteList = glob($upldPath.'*');
    if($deleteList){
        $deleteThisFile = $deleteList($imgNumber);
        if(is_file($deleteThisFile)){
            unlink($deleteThisFile); // delete file
        }
    }
    $name = $imgNumber.".". pathinfo($_FILES['file1']['name'], PATHINFO_EXTENSION);
    //Get the temp file path
    $tmpFilePath = $_FILES['file1']['tmp_name'];
        
    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = $upldPath . $name;
        //check file extansion is valid
        $imageFileType = strtolower(pathinfo($newFilePath,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return "סליחה, רק קבצים מסוג jpg,gif,png,jpeg מותרים.";
            exit;
        }   
        // Check file size
        if ($newFilePath > 2500000) {
        return "מצטערים, הגודל המקסימלי של קובץ הוא 2.5 MB.";
        exit;
        } 
        //Upload the file into the dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            //Handle other code here
            return "succeed";
            //echo 'Upload successful!';
        }
    }
}

function deleteImg($name){
    $str = str_replace('\\', '/', __DIR__);
    $homeDir = str_replace('/controlers', '', $str);
    $name = $homeDir.str_replace('/',DIRECTORY_SEPARATOR,$name);
    chown($name, 666);
    if (!unlink($name)) {
      echo ("Error deleting $name");
    } else {
      echo ("Deleted $name");
    }
}


function moveAllfilesToMainFolder($src,$dest){
    // Get array of all source files
    $files = scandir($src);
    // Clear not real files.
    $new_arr=array();
    foreach($files as $value)
    {
        if($value=="." || $value==".." ){continue;}
        else{$new_arr[]=$value;}     
    }
    $files = $new_arr;
    // Identify directories
    $source = $src;
    $destination = $dest;
    if(!empty($files)){
        //make new folder
        if (!is_dir($destination)) {
            if (!mkdir($destination,0755, true)) {
            }
        }
        // Cycle through all source files
        foreach ($files as $file) {
          if (in_array($file, array(".",".."))) continue;
          // If we copied this successfully, mark it for deletion
          if (copy($source.$file, $destination.$file)) {
            $delete[] = $source.$file;
          }
        }
        // Delete all successfully-copied files
        foreach ($delete as $file) {
          unlink($file);
        }
    }
}


function getArticleFirstPicture($articleid){   
    $scanDir = array();
    if(is_dir($GLOBALS['articleMain'].$articleid))
    {
        $scanDir = scandir($GLOBALS['articleMain'].$articleid);
        if(array_key_exists(2,$scanDir)){
            return $scanDir[2];
        }
    }
    return;
}
function getArticlePictureList($articleid){   
    $scanDir = array();
    if(is_dir($GLOBALS['articleMain'].$articleid))
    {
        $scanDir = scandir($GLOBALS['articleMain'].$articleid);
        if(array_key_exists(2,$scanDir)){
            return array_slice($scanDir,2);
        }
    }
    return;
}
function getArticlePictureCount($articleid){   
    $scanDir = array();
    if(is_dir($GLOBALS['articleMain'].$articleid))
    {
        $scanDir = scandir($GLOBALS['articleMain'].$articleid);
        if(array_key_exists(2,$scanDir)){
            return count(array_slice($scanDir,2));
        }
    }else{return 0;}
    return;
}

function searchArticles($search,$limit) {
    //seprate the words into array of words so it can search 1 by 1.
    $words = explode(" ", html_entity_decode($search));
    $result = [];
    foreach($words as $word){
        $sql = "SELECT a.* , b.`name` FROM `articles` AS a INNER JOIN `users` AS b ON a.`userid` = b.`userid` WHERE a.`title` LIKE '%".$word."%' AND  a.`aproveDate` IS NOT NULL LIMIT ".$limit." ;";
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

function getArticleFirstImgLink($articleid){
    $scanDir = array();
    if(is_dir($GLOBALS['articleMain'].$articleid))
    {
        $scanDir = scandir($GLOBALS['articleMain'].$articleid);
    }
    if(array_key_exists(2,$scanDir)){
        return './uploads/article/main/'.$articleid.'/'.$scanDir[2];
        }else{
            return;
        } 
}

?>
