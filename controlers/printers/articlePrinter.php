<?php
session_start();
require ('../article.php');
require ('../users.php');

function getPictureList($fileNameArray,$tempOrMain,$articleid){
    $div="";
    if(isset($fileNameArray)){
    foreach($fileNameArray as $name){
        if($tempOrMain == "tmp") {
            $href = './uploads/article/tmp/'.$_SESSION['userid'].'/'.$name;
        }
        if($tempOrMain == "main") {
            $href = './uploads/article/main/'.$articleid.'/'.$name;
        }
        //replaceImage(imgNumber)
         /*
        $div .= '<div class="d-flex bd-highlight">';
        $div .= '<div class="p-2 flex-grow-1 bd-highlight"><a href="'.$href.'" target="_blank">'.$name.'</a></div>';
        $div .= '<div class="p-2 bd-highlight">';
        $div .= '<a href="javascript:deleteImg(\''.$href.'\')"><i class="fas fa-trash"></i></a>';
        $div .= '</div>';
        $div .= '</div>';
        */
        //$div .= '<form method="post">';
        $div .= '<div class="input-group my-2">';
        $div .= '<div class="input-group-prepend">';
        $div .= '<span class="input-group-text"><b>תמונה '.substr($name,0,1).'</b></span>';
        $div .= '</div>';
        //$div .= '<input type="file" id="pictures" name="picture'.$name.'" class="form-control" multiple>';
        $link = $GLOBALS['home'].substr($href,1);
        if($tempOrMain == "main") {
            $div .= '<input type="file" id="picture" name="newPicture" class="form-control">';
        }else{
            $div .= '<input type="text" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" value="'.$link.'">';
        }

        $div .= '<div id="answer">';
        //$div .= '<button class="btn btn-info" type="submit" id="uploadImgs" value="14">שנה</button>';
        $div .= '<a class="btn btn-info mx-1" href="'.$href.'" target="_blank">הצג תמונה</a>';
        if($tempOrMain == "main") {
            //$div .= '<a class="btn btn-info mx-1" href="javascript:deleteImg(\''.$href.'\')"><i class="fas fa-trash"></i></a>';
            //$div .= '<a onclick="replaceImage(\''.$name[0].'\');" href="javascript:void(0);" class="btn btn-info border" style="height:38px;">החלף</a>';
        }
        $div .= '<br></div>';
        $div .= '</div>';
        //$div .= '</form>';
    }
    }
    echo $div;
}
function getMultiPictureUploadDiv($start){
    $div="";
    $div .= '<form method="post">';
    $div .= '<div class="input-group my-2">';
    $div .= '<div class="input-group-prepend">';
    $div .= '<span class="input-group-text"><b>בחר תמונות</b></span>';
    $div .= '</div>';
    $div .= '<input type="file" class="form-control" id="pictures" name="pictures[]" class="form-    control" multiple>';
    $div .= '<div class="">';
    $div .= '<button class="btn btn-info" type="submit" id="uploadImgs"    value="'.$start.'">העלה</button><br>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</form>';
    echo $div;
}


function getPictureUploadDiv(){
    $div="";
    for($i = 1; $i <= 4;$i++){
        $div .= '<form method="post">';
        $div .= '<div class="input-group my-2">';
        $div .= '<div class="input-group-prepend">';
        $div .= '<span class="input-group-text"><b>תמונה '.$i.'</b></span>';
        $div .= '</div>';
        $div .= '<input type="file" id="pictures" name="picture'.$i.'" class="form-control" multiple>';
        $div .= '<div class="">';
        $div .= '<button class="btn btn-info" type="submit" id="uploadImgs" value="14">העלה</button><br>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</form>';
    }
    echo $div;
}

function getArticleInsertedDiv(){
    $div = "";
    $div .= '<div>';
    $div .= '<h1>המאמר נקלט בהצלחה!</h1>';
    $div .= '<p>המאמר עבר לאישור אחד המנהלים ויעלה לאתר ע"פ החלטתם, אנו מודים לך שהשקעת מזמך על מנת לעזור לקהילה שלנו.</p>';
    $div .= '</div>';
    echo $div;
}   

function getArtileBrowseRow($article){
    $div=  "";
    $articleid = $article['articleid'];
    //var_dump($article);
    if(isset($article['articleid'])){
        $div .= '<div class="card mb-3"><a href="./getArticle.php?Id='.$articleid.'">';
        $div .= '<div class="row m-0 no-gutters">';
        //$div .= '<div class="col-sm-3 d-flex align-items-center">';
        $scanDir = array();
        if(is_dir($GLOBALS['articleMain'].$articleid))
        {
            $scanDir = scandir($GLOBALS['articleMain'].$articleid);
        }
        if(array_key_exists(2,$scanDir)){
                //$div .= '<img src="./uploads/article/main/'.$articleid.'/'.$scanDir[2].'" class="card-img img-4to3 py-2 px-5 px-sm-2" alt="..." style="max-height: 500px;">';
                $div .= '<div class="col-12 col-sm-3 d-flex align-items-center" style="background: url(\'./uploads/article/main/'.$articleid.'/'.$scanDir[2].'\') no-repeat center scroll;background-size:cover; height:200px;"> ';
        }else{
            $div .= '<div class="col-12 col-sm-3 d-flex align-items-center">';
        }
        //var_dump(getcwd());
        //var_dump($GLOBALS['articleMain'].$articleid);
        $div .= '</div>';
        $div .= '<div class="col-12 col-sm-9">';
        $div .= '<div class="card-body">';
        $div .= '<h5 class="card-title text-break text-truncate">'.htmlspecialchars($article['title']).'</h5>';
        $div .= '<p class="card-text text-dark text-break">'.htmlspecialchars($article['subtitle']).'</p>';
        if(!$article['aproveDate']){
            $div .= '<p class="card-text text-break text-truncate"><small class="text-muted">'.htmlspecialchars($article['createDate']).'</small></p>';
        }else{
            $div .= '<p class="card-text text-break text-truncate"><small class="text-muted">'.htmlspecialchars($article['aproveDate']).'</small></p>';
        }

        if(isset($_SESSION['rank'])){
            if($_SESSION['rank'] >= 4 && $article['aproveDate']){
                $div .= '<div class="d-flex flex-row-reverse" style="height:38px;"><div class="btn btn-success border"><i class="fas fa-check-double"> '.getUserName($article['managerId'])['name'].'</i></div></div>';
            }else{
                if($_SESSION['userid'] == $article['userid']){
                    $div .= '<div  class="d-flex flex-row-reverse" style="height:38px;"><div class="btn btn-danger border"><i class="fas fa-times"> ממתין לאישור</i></div></div>';
                }
            }
        }
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</a></div>';
        //var_dump(getArticleByRange(140));
    }

    echo $div;
}

function getArticleBrowseRowsByRange($start,$end){
    $articlediv ="";
    $articles = getArticleByRange($start,$end);
    //var_dump($articles);
    foreach($articles as $article){
        $articlediv .=  getArtileBrowseRow($article);
    }
    return $articlediv;
}

function getControl($page){
    //nim page number = 1
    if($page < 1){
        $page = 1;
    }
    $dataCount = getArticleCount()['count'];
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
    echo $div;
}


function getIndexArticles(){
    $articles = getArticleByRangeAndAprove(0,5);
    $div="";
    $div .= '<div class="row m-0">';
    
    //1
    $div .= '<div class="col-12 col-md-3 m-0 p-0">';
    $div .= '<div class="row m-0 p-0 vh-sm-30-md-60 border">';
    $div .= '<div class="col-6 col-md-12 p-0 h-100-sm-h50" style="background: url(\'./uploads/article/main/'.$articles[0]['articleid'].'/1.jpg\') no-repeat center  scroll;background-size: cover;opacity:0.8;width:auto;" title="'.htmlspecialchars($articles[0]['title']).'">';
    $div .= '<a href="./getArticle.php?Id='.$articles[0]['articleid'].'" class="w-100 h-100 m-0 p-1 d-flex align-items-end" style="background-image: linear-gradient(transparent, black);">';
    $div .= '<h3 class="text-white text-break" style="right: 5px; bottom: 0px;">';
    $div .= substr(htmlspecialchars($articles[0]['title']),0,70);
    $div .= '</h3>';
    $div .= '</a>';
    $div .= ' </div>';
    //2
    $div .= '<div class="col-6 col-md-12 mb-md-0 p-0 h-100-sm-h50" style="background: url(\'./uploads/article/main/'.$articles[1]['articleid'].'/1.jpg\') no-repeat center scroll;background-size: cover;opacity:0.8;width:auto;" title="'.htmlspecialchars($articles[1]['title']).'">';
    $div .= '<a href="./getArticle.php?Id='.$articles[1]['articleid'].'" class="w-100 h-100 m-0 p-1 d-flex align-items-end" style="background-image: linear-gradient(transparent, black);">';
    $div .= '<h3 class="text-white" style="right: 5px; bottom: 0px;">';
    $div .= substr(htmlspecialchars($articles[1]['title']),0,70);
    $div .= '</h3>';
    $div .= '</a>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</div>';
    //3
    $div .= '<div class="col-12 col-md-6 m-0 p-0">';
    $div .= '<div class="row m-0 p-0 border" style="height:60vh;">';
    $div .= '<div class="col-12 d-flex align-items-end" style="background: url(\'./uploads/article/main/'.$articles[2]['articleid'].'/1.jpg\') no-repeat center scroll;background-size: cover;opacity:0.8;width:auto;"  title="'.htmlspecialchars($articles[2]['title']).'">';
    $div .= '<a href="./getArticle.php?Id='.$articles[2]['articleid'].'" class="w-100 h-100 m-0 p-0  d-flex     align-items-end">';
    $div .= '<h1 class="text-white " style="right: 5px; bottom: 0px;">';
    $div .= substr(htmlspecialchars($articles[2]['title']),0,100);
    $div .= '</h1>';
    $div .= '</a>';
    $div .= ' </div>';
    $div .= '</div>';
    $div .= '</div>';
    //4
    $div .= '<div class="col-12 col-md-3 m-0 p-0">';
    $div .= '<div class="row m-0 p-0 vh-sm-30-md-60 border">';
    $div .= '<div class="col-6 col-md-12 p-0 h-100-sm-h50" style="background: url(\'./uploads/article/main/'.$articles[3]['articleid'].'/1.jpg\') no-repeat center  scroll;background-size: cover;opacity:0.8;width:auto;" title="'.htmlspecialchars($articles[4]['title']).'">';
    $div .= '<a href="./getArticle.php?Id='.$articles[3]['articleid'].'" class="w-100 h-100 m-0 p-1 d-flex align-items-end" style="background-image: linear-gradient(transparent, black);">';
    $div .= '<h3 class="text-white text-break" style="right: 5px; bottom: 0px;">';
    $div .= substr(htmlspecialchars($articles[3]['title']),0,70);
    $div .= '</h3>';
    $div .= '</a>';
    $div .= ' </div>';
    //5
    $div .= '<div class="col-6 col-md-12 mb-md-0 p-0 h-100-sm-h50" style="background: url(\'./uploads/article/main/'.$articles[4]['articleid'].'/1.jpg\') no-repeat center scroll;background-size: cover;opacity:0.8;width:auto;" title="'.htmlspecialchars($articles[4]['title']).'">';
    $div .= '<a href="./getArticle.php?Id='.$articles[4]['articleid'].'" class="w-100 h-100 m-0 p-1 d-flex align-items-end" style="background-image: linear-gradient(transparent, black);">';
    $div .= '<h3 class="text-white" style="right: 5px; bottom: 0px;">';
    $div .= substr($articles[4]['title'],0,70);
    $div .= '</h3>';
    $div .= '</a>';
    $div .= '</div>';
    $div .= '</div>';
    $div .= '</div>';
    //
    $div .= '</div>';
    
    echo $div;
}

function getArticleContentById($id){
    $article = getArticle($id);
    if($article){
        $div = '<div class="border mt-2">';
        //$div .= '<div class="col-12 d-flex align-items-center" style="background: url(\'./uploads/article/main/40/1.jpg\') no-repeat center scroll;background-size:cover; height:200px;opacity:0.5;"> </div>';
        $div .= '<div class="gradient">';
        $div .= '<h1 class="text-truncat text-break"><b>'.$article['title'].'</b></h1>';
        $div .= '<h3 class="text-truncat text-break">'.$article['subtitle'].'</h3>';
        $div .= '<p>';
        if(!$article['aproveDate']){
            $div .= getProfileLink($article['userid']).'</a><b> |</b><grey> כתב את המאמר ב:'.$article['createDate'];
        }else{
            $div .= getProfileLink($article['userid']).'</a><b> |</b><grey> כתב את המאמר ב:'.$article['aproveDate'];
        }
        $div .= '</p>';
        $div .= '</div>';
        $div .= '<p>'.$article['text'].'</p>';
        $div .= '</div>';
        if(isset($_SESSION['userid']) && isset($_SESSION['rank'])){
            if($_SESSION['userid'] == $article['userid']  || $_SESSION['rank'] >= 4 ){
                $div .= '<div class="p-1">';
                $div .= '<a onclick="getEditArticlePanle();" href="javascript:void(0);" class="btn btn-info border" style="height:38px;" title="ערוך"><i class="fas fa-edit"> ערוך</i></a>';
                if($_SESSION['rank'] >= 4){
                    if(!$article['aproveDate']){
                        $div .= '<a onclick="aproveArticle();" href="javascript:void(0);" class="btn btn-info border" style="height:38px;" title="אשר"><i class="fas fa-check"> אשר מאמר</i></a>';
                    }else{
                         $div .= '<a onclick="cancelAproveArticle();" href="javascript:void(0);" class="btn btn-danger border" style="height:38px;" title="אשר"><i class="fas fa-times"> בטל אישור מאמר</i></a>';
                    }
                }
                $div .= '</div>';
            }
        }

    }
    else {
        $div = '<h1 class="my-2">המאמר לא קיים</h1>';
        $div .= '<hr class="bg-info">';
        $div .= '<p>מאמר לא קיים</p>';
    }
    echo $div;
}


function getArticleEditorById($id){
    $article = getArticle($id);
    if($article){
        $div = '<div class="border mt-2">';
        $div .= '<h6 class="text-danger"> שים לב! לאחר העלאת קבצים הדף יתרענן, לכן יש לשמור את המאמר לפני.</h6>';
        $div .= '<h6 class="text-danger"> ברגע שאתה מעלה תמונות כל שאר התמונות נמחקות אוטומטית.</h6>';
        $div .= '<div class="gradient">';
        $div .= '<div class="input-group my-2"><div class="input-group-prepend"><span class="input-group-text"><b>כותרת</b></span></div><input type="text" id="title" name="title" value="'.$article['title'].'" class="form-control" maxlength="255"><div class=""></div></div>';
        $div .= '<div class="input-group my-2"><div class="input-group-prepend"><span class="input-group-text"><b>כותרת משנה</b></span></div><input type="text" id="subtitle" name="subtitle" value="'.$article['subtitle'].'" class="form-control" maxlength="255"><div class=""></div></div>';
        $div .= '<p>';
        if(!$article['aproveDate']){
            $div .= getProfileLink($article['userid']).'</a><b> |</b><grey> כתב את המאמר ב:'.$article['createDate'];
        }else{
            $div .= getProfileLink($article['userid']).'</a><b> |</b><grey> כתב את המאמר ב:'.$article['aproveDate'];
        }
        $div .= '</p>';
        $div .= '</div>';
        $div .= '<textarea name="content" id="content">'.$article['text'].'</textarea>';
        
        $div .= '</div>';
        $div .= '<div class="m-0 p-1 d-flex bd-highligh justify-content-center">';
        $div .= '<a onclick="sendArticleUpdate();" href="javascript:void(0);" class="btn btn-info btn-block btn-lg w-25 mr-1">שלח</a>';
        $div .= '</div>';
        //$div .= '<div id="pictureControl"></div>';
        $div .= '</div>';
        
        $div .= articlePictureControl($id);
    }
    echo $div;
}

function articlePictureControl($id){
    //$div = '<div id="pictureControl" class="d-block border p-1">';
    //$div .= '<h2>הוסף\עדכן תמונות:</h2>';
    //$div .= '<hr class="active-info">';
    $div = getPictureList(getArticlePictureList($id),"main",$id);
    $div .= getMultiPictureUploadDiv(getArticlePictureCount($id));
    //$div .= '</div>';
    echo $div;
}

function getArticleAprovePanelOfUserId($articles){
    $div = '<h2 class="font-weight-bolder">מאמרים הממתינים לאישור</h2><hr class="active-info">';
    if(!sizeof($articles) == 0){
        $div .='<div>';
        $div .='<table class="table text-right">';
        $div .='<thead>';
        $div .='<tr>';
        $div .='<th scope="col">#</th>';
        $div .='<th scope="col">מס\' מאמר</th>';
        $div .='<th scope="col">פורסם ע"י</th>';
        $div .='<th scope="col">לינק למאמר</th>';
        $div .='<th scope="col">פעולות:</th>';
        $div .='</tr>';
        $div .='</thead>';
        $i=1;
        foreach($articles as $article){
            $div .='<tbody>';
            $div .='<tr>';
            $div .='<th scope="row">'.$i.'</th>';
            $div .='<td>'.$article['articleid'].'</td>';
            $div .='<td><a href="profile.php?profileId='.$article['userid'].'" target="_blank">'.getUserName($article['userid'])['name'].'</a></td>';
            $div .='<td><a href="./getArticle.php?Id='.$article['articleid'].'" target="_blank">לינק למאמר</a></td>';
            $div .='<td><a onclick="aproveArticle('.$article['articleid'].');" href="javascript:void(0);" class="btn btn-info border" style="height:38px;" title="אשר"><i class="fas fa-check"> אשר מאמר</i></a></td>';
            $div .='</tr>';
            $div .='</tbody>';
            $i++;
        }
        $div .='</table>';
        $div .='</div>';
    }else{
        $div ="<h1>אין כרגע מאמרים הממתינים לאישור</h1>";
    }
    echo $div;
}

if(isset($_POST['functionName'])){
        
    if($_POST['functionName'] == "uploadimg"){
        //uploadImgs($data,$userid,$target,$articleid,$start)
        $fileNameArray = uploadImgs($_FILES ,$_SESSION['userid'],"tmp",NULL);
        if(count($_FILES)>0){
            return getPictureList($fileNameArray,"tmp",NULL);
        }
    }
    if($_POST['functionName'] == "uploadMoreImgs"){
    uploadImgs($_FILES,$_SESSION['userid'],"main",$_POST['articleId']);
        //uploadImgs($data,$userid,$target,$articleid,$start)
        if(count($_FILES)>0){
            return getPictureList(getArticlePictureList($articleid),"main","");
        }
    }
    
    if($_POST['functionName'] == "deleteImg"){
        $answer = deleteImg($_POST['imgName']);
        if(strpos($answer, "Deleted")){
            return json_encode("has it");
        }
        return json_encode(getFilesInFolder(14));
    }
    
    if($_POST['functionName'] == "getPictureUploadDivs"){
        return getPictureUploadDivs();
    }
    
    if($_POST['functionName'] == "getMultiPictureUploadDiv"){
        return json_encode(getMultiPictureUploadDiv(1));
    }    
    if($_POST['functionName'] == "sendArticle"){
        $answer = insertArticle($_SESSION['userid'],$_POST['title'],$_POST['subTitle'],$_POST['content'],NULL);
        if($answer){
            $answer = getArticleInsertedDiv();
        }
        //$answer = json_decode($answer);
        //$answer = var_dump($answer);
        return $answer;
    }
    if($_POST['functionName'] == "getArticlesByRange"){
        //page in borders check
        $page = $_POST['page'];
        $dataCount = getArticleCount()['count'];
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
        return getArticleBrowseRowsByRange($start,$end);
    }
    if ($_POST['functionName'] == "getControl") {
        return getControl($_POST['page']);
    } 
    if ($_POST['functionName'] == "getIndexArticles") {
        return getIndexArticles();
    }
    if ($_POST['functionName'] == "getArticleContentById") {
        if(isset($_POST['id'])){
            return getArticleContentById($_POST['id']);
        }
    }
    if ($_POST['functionName'] == "getArticleEditorById") {
        if(isset($_POST['id'])){
            return getArticleEditorById($_POST['id']);
        }
    }
    if ($_POST['functionName'] == "articlePictureControl") {
        if(isset($_POST['id'])){
            return articlePictureControl($_POST['id']);
        }
    }
    if ($_POST['functionName'] == "sendArticleUpdate") {
        if(isset($_POST['title']) && isset($_POST['subtitle']) && isset($_POST['content']) && isset($_POST['id']) && isset($_SESSION['userid'])){
            return updateArticle($_SESSION['userid'], $_POST['id'], $_POST['title'],$_POST['subtitle'], $_POST['content']);
        }
    }
    if ($_POST['functionName'] == "checkIfAlreadyUpload") {                               
        if(is_dir($GLOBALS['articleMain'].$articleid))
        {
            $scanDir = scandir($GLOBALS['articleMain'].$articleid);
        }
        if(array_key_exists(2,$scanDir)){
            
        }
    }
    if($_POST['functionName'] == "replaceImage"){
        if(isset($_FILES['file1']) && isset($_POST['imgNumber'])&& isset($_POST['articleId'])){
            $answer = replaceImage($_FILES['file1'],$_POST['imgNumber'],$_POST['articleId']);
            echo $answer;    
        }
    }  
    if($_POST['functionName'] == "aproveArticle"){
        if(isset($_SESSION['rank'])){
            if($_SESSION['rank'] >= 4){
                aproveArticle($_POST['articleId']);
            }
        }
    }
    if($_POST['functionName'] == "cancelAproveArticle"){
        if(isset($_SESSION['rank'])){
            if($_SESSION['rank'] >= 4){
                cancelAproveArticle($_POST['articleId']);
            }
        }
    }
    if($_POST['functionName'] == "getArticleAprovePanelOfUserId"){
        getArticleAprovePanelOfUserId(getWaitingList());
    }
}
?>
