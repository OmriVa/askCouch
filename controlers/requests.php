<?php
/**
* Start the session.
*/
session_start();
require 'db.php';


function getSeasionId(){
    if(isset($_SESSION['userid']))
    {
        echo $_SESSION['userid'];
    }
    return;
}


 
function login(){
      
    //Retrieve the field values from our login form.
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordAttempt = md5($password);
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT `userid`,`name`, `email`, `password`,`birthday`,`rank` FROM `users` WHERE `email` = :email ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':email', $email);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo $passwordAttempt;
        //If $validPassword is TRUE, the login has been successful.
        if($passwordAttempt == $user['password']){
            
            //Provide the user with a login session.
            $_SESSION['name'] = $user['name'];
            $_SESSION['logged_in'] = time();
            $_SESSION['age'] = $user['birthday'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['rank'] = $user['rank'];
            //Redirect to our protected page, which we called index.php
            header('Location: ../index.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('אין התאמה בין שם המשתמש לסיסמא!<br><a href="javascript:history.go(-1)">חזור אחורה</a>');
        }
    
}

function forceLogin($email,$password){
      
    //Retrieve the field values from our login form.
    $email = !empty($email) ? trim($email) : null;
    $password = !empty($password) ? trim($password) : null;
    $passwordAttempt = md5($password);
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT `userid`,`name`, `email`, `password`,`birthday`,`rank` FROM `users` WHERE `email` = :email ";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':email', $email);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo $passwordAttempt;
        //If $validPassword is TRUE, the login has been successful.
        if($passwordAttempt == $user['password']){
            
            //Provide the user with a login session.
            $_SESSION['name'] = $user['name'];
            $_SESSION['logged_in'] = time();
            $_SESSION['age'] = $user['birthday'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['rank'] = $user['rank'];
            //Redirect to our protected page, which we called index.php
            header('Location: ../index.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('אין התאמה בין שם המשתמש לסיסמא!<br><a href="javascript:history.go(-1)">חזור אחורה</a>');
        }
    
}

function register(){
    //Retrieve the field values from our registration form.
    $name = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $confirm = !empty($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;
    $passwordHash = md5($password);
    $date = !empty($_POST['date']) ? trim($_POST['date']) : null;
    $date = date("Y-m-d");
    $rank = 1;
    //TO ADD: Error checking (username characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    
    //check if there is not another username or email;
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT * FROM `users` WHERE `email`= :email;";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':email', $email);
    //Execute.
    $stmt->execute();
    
    $result= $stmt->fetchAll();
    
    if($result)
    {
        die('האיימל כבר נמצא בשימוש<br><a href="javascript:history.go(-1)">חזור אחורה</a>');
    }
    if($password != $confirm){
        die('הסיסמאות לא תואמות<br><a href="javascript:history.go(-1)">חזור אחורה</a>');
    }
    
    
    //Construct the SQL statement and prepare it.
    $sql = "INSERT INTO `users` (`userid`, `name`, `email`, `password`, `title`, `birthday`, `info`, `stamp`, `rank`, `createdata`, `picture`) VALUES (NULL, :name, :email, :password, NULL, :date, NULL, NULL, :rank, CURRENT_TIMESTAMP, NULL);";
    $stmt = $GLOBALS['pdo']->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':rank', $rank);
    
    //Execute.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        forceLogin($email,$password);
        //echo "<script language=\"javascript\">alert(\"ההרשמה בוצעה בהצלחה!\");</script>";
    }
    
}


function passwordChange($post_password,$post_confirm,$post_old){
    $email = !empty($_SESSION['email']) ? trim($_SESSION['email']) : null;
    $password = !empty($post_password) ? trim($post_password) : null;
    $confirm = !empty($post_confirm) ? trim($post_confirm) : null;
    $oldpass = !empty($post_old) ? trim($post_old) : null;
    //return the messeges
    $answerArray = [];

    //check if the users old password id currect.
    if($password == $confirm){
        $sql = "SELECT * FROM `users` WHERE `email`= :email AND `password`= :password ;";
        $stmt = $GLOBALS['pdo']->prepare($sql);

        //Bind the provided username to our prepared statement.
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', md5($oldpass));
        //Execute.
        $stmt->execute();

        $result= $stmt->fetchAll();
        if($result){
            $sql = "UPDATE users SET `password`= :password WHERE `email` = :email ;";
            $stmt = $GLOBALS['pdo']->prepare($sql);

            //Bind the provided username to our prepared statement.
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', md5($password));
            //Execute.
            $result2 = $stmt->execute();

            if($result2){
                $answerArray[] = "yes";
            }
        }
        else{
             $answerArray[] = "נראה כי הסיסמא הנוכחית שלך שגויה, נסה שנית";
        }
    }
    else{
        $answerArray[] = "הסיסמא החדשה וסיסמת האימות לא תואמות, נשה שנית.";
    }
    return $answerArray;
}


function uploadPhoto(){
    $userid = $_POST['userid'];
    $image = $_FILES['file1']['name'];
    $imageTemp = $_FILES['file1']['tmp_name'];
    $imageFileType = pathinfo($image,PATHINFO_EXTENSION);
    $target_dir = "../uploads/";
    $target_file = $target_dir . $userid .".". $imageFileType;
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

    if($_FILES['file1']['size'] <65000)
    {
        //backup the img.
        $imgContent = file_get_contents($imageTemp);
        if (move_uploaded_file($imageTemp, $target_file)) {
            echo "*הקובץ ". basename($image). " הועלה בהצלחה!";
        } else {
            echo "*מצטערים, קרתה תקלה והקובץ לא עלה";
        }
        //upload to database
        $sql = "UPDATE `users` SET `picture` = ? WHERE `userid` = ?;";
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $GLOBALS['pdo']->errorInfo();
        $stmt->execute([$imgContent,$userid]);
    }
    else{
        echo "*הקובץ גדול מדי, זכור הגודל המקסימלי האפשרי הוא 65KB.";
    }
    
    return;
    
}





//END CALLS

//
if(isset($_POST['login'])){
    login();
}
//
if(isset($_POST['reg_user'])){
    register();
}
/*
if(isset($_POST['pass_change'])){
    passwordChange();
}*/
//
if(isset($_FILES['file1']['name'])){
    uploadPhoto();
}
if(isset($_POST['FunctionName']) == 'getSeasionId'){
    getSeasionId();
}
if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "changePass"){
       echo json_encode(passwordChange($_POST['password'],$_POST['password_confirm'],$_POST['old_password']));
    }
}
?>
