<?php 
require 'db.php';

//userinfo  == userid
function insertRankReq($userid,$text){
    $text = str_replace("'","\'",$text);
    $sql = "INSERT INTO `req` (`reqid`, `userinfo`, `text`, `type`, `date`) VALUES (NULL, '$userid', '$text', 'rankreq', CURRENT_TIMESTAMP);";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}

function getRankReq($userid){
    $sql = "SELECT * FROM `req` WHERE `userinfo` = '$userid' AND `type` = 'rankreq';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

function getAllRankReq(){
    $sql = "SELECT * FROM `req` WHERE `type` = 'rankreq';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getRankReqCountById($userid){
    $sql = "SELECT count(*) FROM `req` WHERE `userinfo` = '$userid' AND `type` = 'rankreq';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result['count(*)'];
    
}
function deleteRankReq($userid){
    $sql = "DELETE FROM `req` WHERE `req`.`userinfo` = $userid AND `type` = 'rankreq';";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    $stmt->execute();
    return;
}
function uploadRankReqCerificatnPic($pic,$userid){
    $str = str_replace('\\', '/', __DIR__);
    $homeDir = str_replace('/controlers', '', $str);
    $upldPath = $homeDir ."/uploads/rankreq/$userid/";
    
    //echo $upldPath;
    if (!is_dir($upldPath)) {
        //mkdir($upldPath);
        if (!mkdir($upldPath,0755, true)) {
            $error = error_get_last();
            echo $error['message'];
        }
    }
    $name = "1.". pathinfo($_FILES['file1']['name'], PATHINFO_EXTENSION);
    //Get the temp file path
    $tmpFilePath = $_FILES['file1']['tmp_name'];
        
    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = $upldPath . $name;
        // Check file size
        if ($newFilePath > 2500000) {
        return "מצטערים, הגודל המקסימלי של קובץ הוא 2.5 MB.";
        exit;
        }
        //check file extansion is valid
        $imageFileType = strtolower(pathinfo($newFilePath,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return "סליחה, רק קבצים מסוג jpg,gif,png,jpeg מותרים.";
            exit;
        }   
        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            //Handle other code here
            return "succeed";
            //echo 'Upload successful!';
        }
    }
}


function getRankReqPicPath($userid){
    //$str = str_replace('\\', '/', __DIR__);
    //$homeDir = str_replace('/controlers', '', $str);
    $searchPath = str_replace('/',DIRECTORY_SEPARATOR,"../../uploads/rankreq/$userid/");
    $files = array();
    
    if (is_dir($searchPath)) {
        $files = scandir($searchPath);
    }
    if(isset($files[2])){
        return substr($searchPath.$files[2],4);
    }
}



?>
