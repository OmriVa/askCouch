<?php
session_start();
//require ('../posts.php');
require ('../users.php');
require ('../comments.php');
require ('../frame.php');

function getPostContentById($id){
    $post = getPostById($id);
    if($post){
        $div = '<div class="border mt-2">';
        $div .= '<div class="gradient">';
        $div .= '<h1 class="text-truncat "><b>'.$post['title'].'</b></h1>';
        $div .= '<p>';
        $div .= getProfileLink($post['userid']).'</a><b> |</b><grey> כתב את השאלה ב:'.$post['date'];
        $div .= '</p>';
        $div .= '</div>';
        $div .= '<p>'.$post['text'].'</p>';
        if(isset($_SESSION['userid'])){
            if($_SESSION['userid'] == $post['userid'] || $_SESSION['rank'] >= 4){
                $div .= '<div class="p-1">';
                $div .= '<a onclick="getPostEditPanel();" href="javascript:void(0);" class="btn btn-info border" style="height:38px;" title="ערוך"> <i class="fas fa-edit"> ערוך</i></a>';
                $div .= '<a onclick="deletePost("'.$id.'");" href="javascript:void(0);" class="btn btn-danger border" style="height:38px;" title="מחק"><i class="fas fa-trash-alt"> מחק פוסט</i></a>';
                $div .= '</div>';
            }
        }

        $div .= '</div>';
    }
    else {
        $div = '<h1 class="my-2">פוסט לא קיים</h1>';
        $div .= '<hr class="bg-info">';
        $div .= '<p>יתכן כי הפוסט נמחק עקב עבירה על אחד מכללי הקהילה שלנו.</p>';
    }

    echo $div;
}

function getPostsDiv($data){
    $div="";
    if(count($data)>0){
        for ($i = 0; $i < count($data); $i++) {
            $div .= '<a href="getpost.php?Id=' . $data[$i]['postid'] . '">';
            if ($i % 2) {
                $div .= '<div class="row m-0 my-1 text-dark" style="background-color: #eceff1">';
            } else {
                $div .= '<div class="row m-0 mb-1 text-dark">';
            };
            $date = $data[$i]['date'];
            //date = date.slice(0, 10).split('-');
            //date = d[1] + '/' + d[2] + '/' + d[0];
            $hours = $data[$i]['hours'];
            $minutes = $data[$i]['minutes'];
            $temp = 1;
            $name = getUserName($data[$i]['userid'])['name'];
            //var_dump($data[$i]['userid']);
            if ($minutes < 60) {
                $div .= '<div class ="col-12 col-md-9 border px-2 text-truncate text-break"><h6>' . $data[$i]['title'] . '    </h6><small><font color="grey">&#40פורסם ע"י: '.$name.' הועלה לפני כ- '.$minutes.' דקות&#41</font></small></div>';
            }
            if ($hours < 24 && $hours >= 1) {
                $div .= '<div class ="col-12 col-md-9 border px-2  text-truncate text-break"><h6>' . $data[$i]['title']. '    </h6><small><font color="grey">&#40פורסם ע"י: '.$name.' הועלה לפני כ- ' . $hours . ' שעות&#41</font></small></div>';
            }
            if ($hours >= 24) {
                $div .= '<div class ="col-12 col-md-9 border px-2  text-truncate text-break"><h6>' . $data[$i]['title']. ' </h6><small><font color="grey">&#40פורסם ע"י: '.$name.' הועלה בתאריך: '.$date.'&#41</font></small></div>';
            }
            $div .= '<div class ="col mr-1 border"><b><center>' . $data[$i]['reply']. '</b><small> <br><font color="grey">עצות</font></small></center></div>';
            $div .= '<div class ="col mr-1 border"><b><center>' . $data[$i]['views']. '</b><small> <br><font color="grey">צפיות</font></small></center></div>';
            $div .= '</div></a>';
        }
    }else{
        //$div = "<h2>הדף המבוקש אינו קיים</h2>";
    }
    return $div;
}

function getControl($page){
    //nim page number = 1
    if($page < 1){
        $page = 1;
    }
    $dataCount = getPostsCount()['count'];
    $displayRows = 10;
    //round up the page number.
    $pages = ceil($dataCount / $displayRows);
    //if pagenumber greater then the last page display last page.
    if($page > $pages){
        $page = $pages;
    }
    $temp = $page;
    
    $div = "";
    $div .= '<nav aria-label="Page navigation example">';
    $div .= '<ul class="pagination justify-content-center ">';
    $temp--;
    if($temp < 1)
    {
        $div .= '<li class="page-item disabled "><a class="page-link text-info" href="?page='.$temp.'">הקודם</a></li>';
    }else{
        $div .= '<li class="page-item "><a class="page-link text-info" href="?page='.$temp.'">הקודם</a></li>';
    }
    $temp++;
    if($temp>=$pages){   
        $temp = $temp-$pages;
    }
    for($i=0;$i<3;$i++)
    {
    if($temp<$pages && $temp > 0){   
        if($temp == $page)
        {
            $div .= '<li class="page-item"><a class="page-link active-color" href="?page='.$temp.'">'.$temp.'</a></li>';
        }else{
            $div .= '<li class="page-item"><a class="page-link text-info" href="?page='.$temp.'">'.$temp.'</a></li>';
        }
    }
        $temp = $temp + 1;
    }
    $div .= '<li class="page-item disabled "><a class="page-link text-info" href="#" >...</a></li>';
    if($page>=$pages){
        $div .= '<li class="page-item"><a class="page-link active-color" href="?page='.$pages.'">'.$pages.'</a></li>';
    }else{
        $div .= '<li class="page-item"><a class="page-link text-info" href="?page='.$pages.'">'.$pages.'</a></li>';
    }
    $temp = intval($page) + 1;
    if($temp > $pages){
        $div .= '<li class="page-item disabled">';
    }else{
        $div .= '<li class="page-item ">';
    }
    $div .= '<a class="page-link text-info" href="?page='.$temp.'">הבא</a>';
    $div .= '</li>';
    $div .= '</ul>';
    $div .= '</nav>';
    return $div;
}


function getPostEditPanel($id){
    $post = getPostById($id);
    if($post){
        $div = '<div class="border mt-2">';
        $div .= '<div class="gradient">';
        $div .= '<div class="input-group my-2"><div class="input-group-prepend"><span class="input-group-text"><b>כותרת</b></span></div><input type="text" id="title" name="title" value="'.$post['title'].'" class="form-control" maxlength="255"><div class=""></div></div>';
        $div .= '<p>';
        $div .= getProfileLink($post['userid']).'</a><b> |</b><grey> כתב את השאלה ב:'.$post['date'];
        $div .= '</p>';
        $div .= '</div>';
        $div .= '<textarea name="content" id="content">'.$post['text'].'</textarea>';
        
        $div .= '</div>';
        $div .= '<div class="m-0 p-1 d-flex bd-highligh justify-content-center">';
        $div .= '<a onclick="sendPostUpdate();" href="javascript:void(0);" class="btn btn-info btn-block btn-lg w-25 mr-1">שלח</a>';
        $div .= '</div>';
        $div .= '</div>';
    }
    echo $div;
}

function loginOrRegister123(){
    $div = "";
    $div .= '';
    $div .= '<div class="row no-gutters text-center">';
    $div .= '<div class="col-12">';
    $div .= '<h3 class="text-info font-weight-bolder">הרשם עכשיו או לחלופין כתוב שאלה ללא הרשמה</h3>';
    $div .= '<hr class="active-info">';
    $div .= '<div>';
    $div .= '<h5>אז למה להרשם אלינו בכלל?</h5>';
    $div .= '<p>*את/ה הופכ/ת לחלק מקהילת הכושר המשפחתית שיתופית שלנו<br>*יש לך הרשאות לפתוח פוסטים לנהל תקבל/י הרשאות לפתוח פוסטים לנהל שיחות וכו\'<br>*אצלנו בקהילה כל אחד יכול להפוך לחלק מצוות האתר.<br>*איש מקצוע בתחום הכושר? מצויין! אצלנו תוכל לקבל חשיפה בדף המייעצים שלנו והרשאות מורחבות לפרסם מאמרים.';
    $div .= '</p>';
    $div .= '</div>';
    $div .= '<a id="commentWihtoutReg" class="btn btn-info active-background m-1 border" href="#">שאל שאלה ללא רשמה</a>';
    $div .= '<a class="btn btn-info active-background m-1 border"   href="register.php">הרשם עכשיו!</a>';
    $div .= '<br>';
    $div .= '<a href="login.php">(או התחבר אם אתה כבר רשום)</a>';
    $div .= '</div>';
    $div .= '</div>';
    echo $div;
}

function getNonRegisterPost(){
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



if (isset($_POST['functionName'])) {
    if($_POST['functionName'] == "getAllPosts"){
        $data = getPostsDiv(getPostsByRange(0,11));
        $data .= '<a href="browsePosts.php" class="btn btn-info btn-block btn-lg">הצג עוד פוסטים</a>';
        echo json_encode($data);
    }

    if ($_POST['functionName'] == "getPostsByRange") {
        //page in borders check
        $page = $_POST['page'];
        $dataCount = getPostsCount()['count'];
        $displayRows = 10;
        //round up the page number.
        $pages = ceil($dataCount / $displayRows);
        $start;
        $end;
        if ($page <= 1) {
            $start = 0;
            $end = $displayRows;
        } else {
            if($page > $pages){
                $page = $pages;
            }
            $start = ($page - 1) * $displayRows;
            $end = $start + $displayRows;
        }

        //posts.php function
        echo json_encode(getPostsDiv(getPostsByRange($start,$end)));
    }    
    if ($_POST['functionName'] == "getControl") {
        //posts.php function
        echo json_encode(getControl($_POST['page']));
    }
    if($_POST['functionName'] == "getPostsOwned"){
        echo json_encode(getPostsDiv(getPostsOfUserId($_POST['userid'], 5)));
    }
    if($_POST['functionName'] == "getPostsUserInvolved"){
        $postsId = getPostsIdUserInvolved($_POST['userid'], 5);
        $posts = array();
        foreach($postsId as $id){
            $data = getPostsUserInvolvedByPostId($id['postid']);
            array_push($posts, $data);
        }
        //var_dump(getPostsDiv($posts));
        echo json_encode(getPostsDiv($posts));
    }
    if($_POST['functionName'] == "getPostEditPanel"){
        if(isset($_POST['postId'])){
            return getPostEditPanel($_POST['postId']);
        }
    }
    if ($_POST['functionName'] == "sendPostUpdate") {
        if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id']) && isset($_SESSION['userid'])){
            return updatePost($_SESSION['userid'], $_POST['id'], $_POST['title'], $_POST['content']);
        }
    }
    if($_POST['functionName'] == "createPost"){
        if(isset($_SESSION['userid'])){
            echo createPost($_POST['content'],$_POST['title'], $_SESSION['userid']);
        }
    }
    if($_POST['functionName'] == "getPostContentById"){
        if(isset($_POST['id'])){
            return getPostContentById($_POST['id']);
        }
    }
}
?>
