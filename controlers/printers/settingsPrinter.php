<?php
session_start();
require '../users.php';

function printInputDiv($title, $divName, $userId ,$value,$type, $disable){
    //for $disable send value d-none so to button will be hideen.
    $div = '<div class="input-group my-2">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text"><b>'.$title.'</b></span>';
    $div .= '</div>';
    if($disable){
        $div .= '<input type="'.$type.'" name="new'.$divName.'" value="'.$value.'" class="form-control"  onfocus="this.value = \'\'" maxlength="255" disabled>';
    }
    else{
        if($divName=="Picture"){
            $div .= '<input type="'.$type.'" id="new'.$divName.'" name="new'.$divName.'"  class="form-control"  maxlength="255">';
            $div .= '<a class="btn btn-info ml-1" href="showImage.php?userId='.$userId.'" target="_blank">הצג</a>';

        }else{
            $div .= '<input type="'.$type.'" id="new'.$divName.'" name="new'.$divName.'" value="'.$value.'" class="form-control"  maxlength="255">';
        }

    }
    $div .= '<div class="">';
    $div .= '<button class="btn btn-info '.$disable.'" type="submit" id="change'.$divName.'"     value="'.$userId.'">שנה</button>';
    //$div .= '';
    $div .= '<br>';
    $div .=  '</div>';
    $div .= '</div>';
    return $div;

}

function printInputDivAsTextarea($title, $divName, $userId ,$value,$type, $disable){
    //for $disable send value d-none so to button will be hideen.
    $div = '<div class="my-2">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text"><b>'.$title.'</b></span>';
    $div .= '</div>';
    $div .= '<textarea name="new'.$divName.'">'.$value.'</textarea>';
    $div .= '<div class="">';
    $div .= '<button class="btn btn-info '.$disable.'" type="submit" id="change'.$divName.'"     value="'.$userId.'">שנה</button>';
    $div .=  '</div>';
    $div .= '</div>';
    return $div;

}
function getUsersTable($search){

    $data = searchUser($search,30);
    if(ctype_space($search))
    {
        $result = '<p class="text-center">* קלט שגוי</p>';
        echo json_encode($result);
        return;
    }
    if(!$data)
    {
        $result = '<p class="text-center">אין תוצאות לחיפוש המבוקש</p>';
        echo json_encode($result);
        return;
    }
    $result = '<form id="choseUser" method="post"><div class="row mx-0">';
    $result .= "<div class=\"col-1 border px-2 wrapping\">";
    $result .= "<p><b>#</b></p>";
    $result .= "</div>";
    $result .= "<div class=\"col-2 border px-2 wrapping\">";
    $result .= "<p><b>UserId</b></p>";
    $result .= "</div>";
    $result .= "<div class=\"col-4 border px-2 wrapping\">";
    $result .= "<p><b>name</b></p>";
    $result .= "</div>";
    $result .= "<div class=\"col-5 border px-2 wrapping\">";
    $result .= "<p><b>email</b></p>";
    $result .= "</div>";
    $result .= '</div>';
    foreach( $data as $i => $user ){
        $result .= '<a href=# onclick=""><div class="row mx-0">';
        $result .= '<div class="col-1 border px-2 wrapping "><b>';
        $result .= '<input type="radio" name="userid[]" value="'.$data[$i]['userid'].'">';
        $result .= '</b></div>';
        $result .= '<div class="col-2 border px-2 wrapping ">';
        $result .= $user['userid'];
        $result .= '</div>';
        $result .= '<div class="col-4 border px-2 wrapping ">';
        $result .= $user['name'];
        $result .= '</div>';
        $result .= '<div class="col-5 border px-2 wrapping ">';
        $result .= $user['email'];
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div></a>';
    }
    $result .= '<div class="col-12 border px-2 wrapping ">';
    $result .= '  <button id="chosed" class="btn btn-info btn-block btn-lg" type="submit">ערוך</button>';
    $result .= '</div></form>';
    echo json_encode($result);
}

function getUserEditPanel($userid){
    $user = getUserById($userid);
    
    //echo json_encode($user);
    $div = '<form id="editUser" method="post"><h5>שנה את הפרטים של המשתמש :</h5>';
    //userid
    $div .= printInputDiv("מס' אישי:","Userid", $userid , $user['userid'], "number","d-none");

    //name
    $div .= printInputDiv("שם מלא:","Name", $userid , $user['name'], "text","");
    
    //email
    $div .= printInputDiv("איימל:","Email", $userid , $user['email'], "email","");

    //password
    $div .= printInputDiv("סיסמא:","Password", $userid , $user['password'], "text","");

    //title
    $div .= printInputDiv("כותרת:", "Title", $userid , $user['title'],"text", "");

    //birthday
    $div .= printInputDiv("תאריך לידה", "Birthday", $userid , $user['birthday'],"date", "");
    
    //stamp
    //$div .= printInputDivAsTextarea(":חתימה","Stamp", $user['userid'] , $user['stamp'], "text","");
    
    //info
    $div .= printInputDivAsTextarea("קצת עלי:","Info", $user['userid'] , $user['info'], "text","");
    
    //rank
    $div .= printInputDiv("דרגה:", "Rank", $userid , $user['rank'],"text", "");
           
    //picture
    $div .= printInputDiv("תמונת פרופיל", "Picture", $userid , "","file", "");
    
    //createdata
    $div .= printInputDiv("תאריך הרשמה", "Createdata", $user['userid'] , $user['createdata'],"text", "d-none");
    
    //form closer
    $div .= '<div id="editPanelMsg"></div></form>';
    
    echo json_encode($div);
    
}

function getUserProfileEditPanel(){

    if(isset($_SESSION['userid']))
    {
            $user = getUserById($_SESSION['userid']);
    }

    
    $div = '<form id="editUser" method="post"><h1>עדכון פרטים אישיים:</h1>';
    $div .='<hr class="active-info">';
    
    //name
    $div .= printInputDiv("שם מלא","Name", $user['userid'] , $user['name'], "text","");

    //stamp
    //$div .= printInputDivAsTextarea(":חתימה","Stamp", $user['userid'] , $user['stamp'], "text","");
    //info
    //$div .= printInputDivAsTextarea("קצת עלי:","Info", $user['userid'] , $user['info'], "text","");
        
    
    //birthday
    $div .= printInputDiv("תאריך לידה", "Birthday", $user['userid'] , $user['birthday'],"date", "");
       
    //picture
    $div .= printInputDiv("תמונת פרופיל", "Picture", $user['userid'] , "","file", "");
    

    //createdata
    $div .= printInputDiv("תאריך הרשמה", "Createdata", $user['userid'] , $user['createdata'],"text", "d-none");
    if($_SESSION['rank']>=2){
        $div .= printInputDivAsTextarea("מידע:","Info", $user['userid'] , $user['info'], "text","");
    }

    
    //form closer
    $div .= '<div id="editPanelMsg"></div></form>';
    //var_dump($div);
    echo json_encode($div);
}

function updateUser($columName, $userId, $insertData){
    $result = setUserData($columName, $userId, $insertData);
    if($result){
        echo json_encode($result);
        return;
    }
    echo "faild";
}

function getManegerPanel(){
    $div = '<h1>ניהול משתמשים</h1>';
    $div .= '<hr class="active-info">';
    $div .= '<div id="displayUsers">';
    $div .= '<h2>חפש משתמש לפי מספר משתמש,איימל או לפי שם</h2>';
    $div .= '<div class="container">';
    $div .= '<div class="row">';
    $div .= '<div class="col-md-12">';
    $div .= '<div class="search-container">';
    $div .= '<form id="searchUser">';
    $div .= '<div class="input-group my-2">';
    $div .= '<input type="text" placeholder="Search.." name="searchUser" class="form-control mr-sm-2" required="required">';
    $div .= '<div>';
    $div .= '<button type="submit" name="submit_user" id="submit_user" class="btn btn-light"><i class="fa fa-search"></i></button>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</form>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<div id="showUsers">';
    $div .= '</div>';
    echo json_encode($div);
}

function getPassChangePanel(){
    $div = '<form action="./controlers/requests.php" method="post">';
    $div .= '<h2>שינוי סיסמא</h2>';
    $div .= '<p class="lead">על מנת לשנות את הסיסמא יש צורך בסיסמא הנוכחית.</p>';
    $div .= '<hr class="active-info">';
    $div .= '<div class="form-group">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text">';
    $div .= '<i class="fa fa-lock icon-user"></i>';
    $div .= '</span>';
    $div .= '<input type="password" id="password" class="form-control" name="oldPassword"    placeholder="סיסמא נוכחית" required="required">';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<div class="form-group">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text">';
    $div .= '<i class="fa fa-unlock icon-user"></i>';
    $div .= '</span>';
    $div .= '<input type="password" id="password" class="form-control" name="password"   placeholder="סיסמא חדשה" required="required">';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<div class="form-group ">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text">';
    $div .= '<i class="fa fa-lock icon-user "></i>';
    $div .= '</span>';
    $div .= '<input type="password" id="password2" class="form-control" name="confirm_password"  placeholder="אימות סיסמא חדשה" required="required">';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '<div class="form-group">';
    $div .= '<button type="submit" class="btn btn-info btn-block btn-lg" name="pass_change" id="pass_change"  value="yes">החלף סיסמא</button>';
    $div .= '</div>';
    $div .= '<div id="passAnswer"></div>';
    $div .= '</form>';
    echo json_encode($div);
}   

function getManagerOptions(){
    $div ="";
    $div .= '<div class="d-flex justify-content-between text-center">';
    $div .= '<a href="javascript:void(0)" class="nav-link" onclick="getManegerPanel();"><i class="fas fa-users fa-3x"></i><br>ניהול משתמשים</a>';
    $div .= '<a href="javascript:void(0)" class="nav-link" onclick="getRankReqPanelOfUserId();"><i class="fas fa-level-up-alt fa-3x"></i><br>ניהול בקשות</a>';
    $div .= '<a href="#" class="nav-link" onclick="getArticleAprovePanelOfUserId()"><i class="fas fa-newspaper fa-3x"></i><br>ניהול מאמרים</a>';
    $div .= '</div>';
    echo $div;
}


if(isset($_POST['editUser'])){
    if(isset($_SESSION['rank'])){
        if($_SESSION['rank']>= 4){
            getUserEditPanel($_POST['editUser']);
        }
    }
};
if(isset($_POST['searchUser'])){
    if(isset($_SESSION['rank'])){
        if($_SESSION['rank']>= 4){
            getUsersTable($_POST['searchUser']);
        }
    }
}
//edit user data calls
if(isset($_POST['newuserid'])){
    //$columName, $insertData, $userId
    setUserData("userid", $_POST['newuserid'],$_POST['userid'] );
}
if(isset($_POST['newName'])){
    setUserData("name", $_POST['newName'],$_POST['userid'] );
}
if(isset($_POST['newEmail'])){
    setUserData("email", $_POST['newEmail'],$_POST['userid'] );
}
if(isset($_POST['newPassword'])){
    setUserData("password", md5($_POST['newPassword']),$_POST['userid'] );
}
if(isset($_POST['newTitle'])){
    setUserData("title", $_POST['newTitle'],$_POST['userid'] );
}
if(isset($_POST['newBirthday'])){
    setUserData("birthday", $_POST['newBirthday'],$_POST['userid'] );
}
if(isset($_POST['newInfo'])){
    setUserData("info", $_POST['newInfo'], $_POST['userid'] );
}
if(isset($_POST['newRank'])){
    setUserData("rank", $_POST['newRank'],$_POST['userid'] );
}
if(isset($_POST['newStamp'])){
setUserData("stamp", $_POST['newStamp'],$_POST['userid'] );
}
//GET
if(isset($_GET['FunctionName'])){
    if($_GET['FunctionName'] == "getUserProfileEditPanel"){
        getUserProfileEditPanel();
    }
    if($_GET['FunctionName'] == "getManegerPanel"){
        getManegerPanel();
    }
    if($_GET['FunctionName'] == "getPassChangePanel"){
        getPassChangePanel();
    }
}

//POST
if(isset($_POST['FunctionName'])){
    if($_POST['FunctionName'] == "getManagerOptions"){
        getManagerOptions();
    }
}

?>
