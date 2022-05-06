<?php
session_start();
require ('../comments.php');
require ('../users.php');

function getComments($postid){
    $comments = getPostComments($postid);
    $div ="";
    //check if there is comments
    if($comments){
        $div .= '<div class="row mx-0">';
        $div .= '<h1 class="col p-0 text-info">תגובות:</h1>';
        $div .= '</div><hr>';
        foreach($comments as $comment){
            $check = 1;
            if(isset($_SESSION['userid'])){
                $check = checkIfAlreadyRated($_SESSION['userid'], $comment['comment_id']);
            }
            $likes = getRatingLikes($comment['comment_id']);
            $dislikes = getRatingDislikes($comment['comment_id']);
            $username = getUserName($comment['userid']);
            $div .= '<div class="comment border mt-2">';
            $div .= '<header class="bg-color p-2">';
            $div .= '<h5><b>'.getProfileLink($comment['userid']).'</b></h5>';
            $div .= '<p class="p-0 m-0">'.$comment['date'].'</p>';
            $div .= '</header>';
            $div .= '<section>';
            $div .= '<p class="p-2">'.$comment['comment'].'</p>';
            $div .= '</section>';
            $div .= '<footer class="border">';
            $div .= '<div class="d-flex justify-content-end m-0 h-100 align-middle">';
            $div .= '<button class="btn btn-light ml-auto justify-content-start" style="height:38px;">';
            $div .= '<i class="fas fa-exclamation-circle  icon-user text-danger"></i>';
            $div .= '</button>';
            //check if already liked
            if($check['count'] > 0){
                $div .= '<button class="btn btn-light" style="height:38px;" disabled>';}
            else{
                $div .= '<button class="btn btn-light" onclick="insertRating(1,'.$comment['comment_id'].')" style="height:38px;">';
            }
            $div .= '<i class="fas fa-thumbs-up icon-user active-color text-info">'.$likes['count'].'</i>';
            $div .= '</button>';
            if($check['count'] > 0){
                $div .= '<button class="btn btn-light" style="height:38px;" disabled>';}
            else{
                $div .= '<button class="btn btn-light" onclick="insertRating(2,'.$comment['comment_id'].')" style="height:38px;">';
            }
            $div .= '<i class="fas fa-thumbs-down  icon-user active-color">'.$dislikes['count'].'</i>';
            $div .= '</button>';
            $div .= '</div>';
            $div .= '</footer>';
            $div .= '</div>';
        }
    }
    else{
        $div .= '<div class="row mx-0">';
        $div .= '<h1 class="col p-0 text-info">תגובות:</h1>';
        $div .= '</div><hr>';
        $div .= '<h6>אין תגובות עדיין...</h6>';

    }
    $div .= '<form method="post" id="sendComment" class="mt-2">';
    $div .= '<button id="sendSubmit" class="btn btn-info btn-block btn-lg"  value="yes">הוסף תגובה</button></form>';
    echo json_encode($div);
}

function getCommentSection(){
    $div = "";
    if(isset($_SESSION['userid'])){
        $div .= '<form method="post" action="./controlers/comments.php">';
        $div .= '<div id="commends" class="my-2">';
        $div .= '<h2>תוכן התגובה:</h2>';
        $div .= '<textarea id="commentTextbox" class="col"></textarea>';
        $div .= '</div>';
        $div .= '<button type="submit" class="btn btn-info btn-block btn-lg mt-2" name="send_comment" value="'.$_SESSION['userid'].'">שלח</button>';
        $div .= '</form>';
        $div .= '<div id="commentAmswer">';
        $div .= '</div>';
    }
    else{
        $div .= 'תתחבר מניאק';
    }
    echo json_encode($div);
}

function loginOrRegister(){
    $div = "";
    $div .= '';
    $div .= '<div class="row no-gutters text-center">';
    $div .= '<div class="col-12">';
    $div .= '<h3 class="text-info font-weight-bolder">הרשם עכשיו או לחלופין הגב ללא הרשמה</h3>';
    $div .= '<hr class="active-info">';
    $div .= '<div>';
    $div .= '<h5>אז למה להרשם אלינו בכלל?</h5>';
    $div .= '<p>*את/ה הופכ/ת לחלק מקהילת הכושר המשפחתית שיתופית שלנו<br>*יש לך הרשאות לפתוח פוסטים לנהל תקבל/י הרשאות לפתוח פוסטים לנהל שיחות וכו\'<br>*אצלנו בקהילה כל אחד יכול להפוך לחלק מצוות האתר.<br>*איש מקצוע בתחום הכושר? מצויין! אצלנו תוכל לקבל חשיפה בדף המייעצים שלנו והרשאות מורחבות לפרסם מאמרים.';
    $div .= '</p>';
    $div .= '</div>';
    $div .= '<a id="commentWihtoutReg" class="btn btn-info active-background m-1 border" href="#">הגב ללא רשמה</a>';
    $div .= '<a class="btn btn-info active-background m-1 border"   href="register.php">הרשם עכשיו!</a>';
    $div .= '<br>';
    $div .= '<a href="login.php">(או התחבר אם אתה כבר רשום)</a>';
    $div .= '</div>';
    $div .= '</div>';
    echo $div;
}

function getCommentInsert(){
    $div = '';
    if(isset($_SESSION['userid'])){
        $div .= '<textarea id="CommentContent"></textarea>';
        $div .= '<div class="d-flex justify-content-center"><input type="submit" name="send_comment" value="שלח" class="btn btn-info my-2 mx-2"><input type="reset" name="reset" value="אפס" class="btn btn-info my-2 mx-2 "></div>';
    }else{
        $div .= loginOrRegister();
    }
    echo $div;
}

function getNonRegisterCommnet(){
    $div = '';
    $div .= '<form>';
    $div .= '<div class="form-group">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text"><i class="fa fa-user icon-user"></i></span>';
    $div .= '<input type="text" class="form-control" name="username" placeholder="שם מלא" required="required">';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<div class="form-group">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text"><i class="fa fa-envelope icon-user"></i></span>';
    $div .= '<input type="email" class="form-control" name="email" placeholder="כתובת איימל" required="required">';
    $div .= '<div id="emailAlreadyExsist"></div>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<textarea id="unregister"></textarea>';
    $div .= '<div class="d-flex justify-content-center">';
    $div .= '<input id="save" name="save" type="submit" value="שלח" class="btn btn-info my-2 mx-2">';
    $div .= '<input name="reset" type="reset" value="אפס" class="btn btn-info my-2 mx-2 ">';
    $div .= '</div>';
    $div .= '</form>';
    echo $div;
}



if(isset($_POST['functionName']) == "getCommentSection"){
    if($_POST['functionName'] == "getCommentSection"){
        return getCommentSection();
    }
    if($_POST['functionName'] == "getComments"){
        return getComments($_POST['postid']);
    }
    if($_POST['functionName'] == "insertRating"){
        if(isset($_SESSION['userid'])){
            echo json_encode(insertRating($_SESSION['userid'],$_POST['commentId'],$_POST['likeOrDislike']));
        }
    }
    if($_POST['functionName'] == "send_comment"){
        if(isset($_SESSION['userid'])){
            //comments.php function
            return insertComment($_SESSION['userid'], $_SESSION['name'], $_POST['postid'], $_POST['comment'], $_POST['parent']);  
        }
    }
    if($_POST['functionName'] == "getCommentInsert"){
        echo getCommentInsert();
    }
    if($_POST['functionName'] == "getNonRegisterCommnet"){
        echo getNonRegisterCommnet();
    }
    if($_POST['functionName'] == "sendUnregisterComment"){
        //var_dump(checkIfEmailAlreadyUsed($_POST['email']));
        if(checkIfEmailAlreadyUsed($_POST['email'])['count']>0){
            echo "האיימל כבר נמצא בשימוש, נסה איימל אחר.";
        }else{
            $password = rand ();
            $userid = regFastRegister($_POST['userName'],$_POST['email'],rand ());
            var_dump($userid);
            if($userid){
                insertComment($userid, $_POST['userName'], $_POST['postId'], $_POST['comment'], "");
                //clean the echo from insertCommnet
                ob_end_clean();
                echo "yes".$password;
            }
            else{
                return "התגובה לא נקלטה בהצלחה";
            }
        }
    }
}



?>
