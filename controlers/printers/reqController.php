<?php
session_start();
require '../req.php';
require '../users.php';

function rankReqInProcess(){
    $div ="";
    $div .='<h1>משתמש יקר בקשתך נקלטה והיא נמצאת בתהליך בדיקה </h1>';
    $div .='<hr class="active-info">';
    $div .='<p>אנא העזר בסבלנות, אנו מודים לך על הסבלנות</p>';
    return $div;
}

function getRankReqPanel(){
    $div ="";
    $div .='<h1 class="font-weight-bold color-info">בקשת דרגה: </h1>';
    $div .='<hr class="active-info">';
    $div .='<p>כאן ניתן להגיש בקשה לקבלת דרגה, ע"מ לקבל דרגה יש לצרף צילום תעודת מקצוע, תעודת הסמכה בנושא כושר,תזונה וכו\'.<br>במידה והבקשה תאושר יתווסף למשתמש שלכם כותרת התואמת את ההסמכה, בנוסף תתווספו לדף "המייעצים שלנו" ושם תוכלו להוסיף פרטים ולצבור חשיפה.<br>  במידה ואחד המנהלים יראה לנכון ינתן לכם גישה לפרסום מאמרים באתר.<br> צוות האתר מודה לך על תרומתך ורצונך לתמוך בקהילה שלנו.</p>';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend">';
    $div .='<span class="input-group-text"><b>בחר תמונה</b></span>  </div>';
    $div .='<input type="file" id="picture" name="newPicture" class="form-control" maxlength="255">';
    $div .='</div>';
    $div .='</div>';
    $div .='<div class="input-group-prepend">';
    $div .='<span class="input-group-text"><b>טקסט חופשי</b></span>  </div>';
    $div .='<textarea id="rankText" class="form-control" maxlength="500"></textarea>';
    $div .='</div>';
    $div .='</div>';
    $div .='<div class="mt-2">';
    $div .='<button class="btn btn-info btn-block " type="submit"  id="uploadPic">שלח</button><br>';
    $div .='<div id="answer"></div>';
    return $div;
}


function getRankReqControlByUserId($userData, $reqData, $picPath){
    $div = "";
    $div .='<div class="text-right">';
    $div .='<h2 class="font-weight-bolder">ניהול בקשת דרגה</h2>';
    $div .='<hr class="active-info">';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend"><span class="input-group-text"><b>שם משתמש</b></span></div><input type="text" id="username" value="'.$userData['name'].'" class="form-control" disabled>';
    $div .='</div>';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend"><span class="input-group-text"><b>תאריך הגשת בקשה</b></span></div><input type="text" id="date" value="'.$reqData['date'].'" class="form-control" disabled>';
    $div .='</div>';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend"><span class="input-group-text"><b>טקסט</b></span></div>';
    $div .='<div type="text" class="form-control overflow-auto" style="height:150px;" disablead>'.htmlspecialchars($reqData['text']).'</div>';
    $div .='</div>';
    $div .='<div class="d-flex justify-content-center">';
    $div .='<a class="btn btn-info ml-1" target="_blank" href="'.$picPath.'">הצג תעודה</a>';
    $div .='<a class="btn btn-info ml-1" target="_blank" href="./profile.php?profileId='.$userData['userid'].'">פרופיל משתמש</a>';
    $div .='</div>';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend"><span class="input-group-text"><b>בחר דרגה</b></span></div>';
    $div .='<select class="form-control" name="ranks">';
    $div .='<option value="2">2 - מייעץ</option>';
    $div .='<option value="3">3 - מייעץ בכיר</option>';
    $div .='<option value="4">4 - מנהל</option>';
    $div .='</select>';
    $div .='</div>';
    $div .='<div class="input-group my-2">';
    $div .='<div class="input-group-prepend"><span class="input-group-text"><b>כותרת משתמש</b></span></div>';
    $div .='<input type="text" id="rankTitle" class="form-control">';
    $div .='</div>';
    $div .='<div class="d-flex justify-content-center">';
    $div .='<button class="btn btn-success ml-1" id="acceptRank" value="'.$userData['userid'].'">אשר בקשה</button>';
    $div .='<button class="btn btn-danger ml-1" id="refuseRank" value="'.$userData['userid'].'">דחה בקשה</button>';
    $div .='</div>';
    $div .='</div>';
    echo $div;
}

function getRankReqPanelOfUserId($reqs){
    $div = '<h2 class="font-weight-bolder">בקשות דרגה</h2><hr class="active-info">';
    if(!sizeof($reqs) == 0){
        $div .='<div>';
        $div .='<table class="table text-right">';
        $div .='<thead>';
        $div .='<tr>';
        $div .='<th scope="col">#</th>';
        $div .='<th scope="col">מס\' משתמש</th>';
        $div .='<th scope="col">שם משתמש</th>';
        $div .='<th scope="col">תאריך הגשה</th>';
        $div .='</tr>';
        $div .='</thead>';
        $i=1;
        foreach($reqs as $req){
            $div .='<tbody>';
            $div .='<tr class="custom-link" href="javascript:void(0)" onclick="getRankReqById('.$req['userinfo'].');" );">';
            $div .='<th scope="row">'.$i.'</th>';
            $div .='<td>'.$req['userinfo'].'</td>';
            $div .='<td>'.getUserData("name", $req['userinfo'])['name'].'</td>';
            $div .='<td>'.$req['date'].'</td>';
            $div .='</tr>';
            $div .='</tbody>';
            $i++;
        }
        $div .='</table>';
        $div .='</div>';
    }else{
        $div ="<h1>אין כרגע בקשות</h1>";
    }
    echo $div;
}

if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "rankreq"){
        if(isset($_FILES['file1']) && isset($_SESSION['userid']))
        $answer = uploadRankReqCerificatnPic($_FILES['file1'], $_SESSION['userid']);
        if($answer == "succeed"){
             insertRankReq($_SESSION['userid'], $_POST['text']);
        }
        echo $answer;

    }
    if($_POST['functionName'] == "rankGranted"){
        setUserData("title",$_POST['title'], $_POST['userId']);
        setUserData("rank",$_POST['rankLvl'], $_POST['userId']);
        deleteRankReq($_POST['userId']);
    }
    if($_POST['functionName'] == "refuseReq"){
        deleteRankReq($_POST['userId']);
        //NEED TO ADD DELETE FILE TO THE DELETERANKREQ FUNCTION
    }
    if($_POST['functionName'] == "getRankReqById"){
        $userid = $_POST['userId'];
        $userData = getUserById($userid);
        $reqData = getRankReq($userid);
        $picPath = getRankReqPicPath($userid);
        getRankReqControlByUserId($userData, $reqData, $picPath);
    }
    if($_POST['functionName'] == "getRankReqPanelOfUserId"){
        getRankReqPanelOfUserId(getAllRankReq());
    }
    if($_POST['functionName'] == "getRankReqCountById"){
        if(isset($_SESSION['userid'])){
            $count = getRankReqCountById($_SESSION['userid']);
        }
        if($count > 0){
            echo rankReqInProcess();
        }else{
            echo getRankReqPanel();
        }
        
    }
}
?>
