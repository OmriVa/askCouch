<?php
session_start();
require '../users.php';
require '../paganation.php';

function getAdviserDivRow11($dviser){
    $div=  "";
    //userid | name | info | stats?
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
        $div .= '<h5 class="card-title text-break text-truncate">'.$article['title'].'</h5>';
        $div .= '<p class="card-text text-dark text-break">'.$article['subtitle'].'</p>';
        $div .= '<p class="card-text text-break text-truncate"><small class="text-muted">'.$article['createDate'].'</small></p>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</a></div>';
        //var_dump(getArticleByRange(140));
    }

    echo $div;
}

function getAdviserDivRow($adviser){
    $div=  "";
    if($adviser){
        $div .= '<div class="card mb-3"><a href="./profile.php?profileId='.$adviser['userid'].'">';
        $div .= '<div class="row m-0 no-gutters">';
        $div .= '<div class="col-12 col-sm-3 d-flex align-items-center" style="background: url(\'img/1.png\') no-repeat center scroll;background-size:cover; height:200px;"> </div>';
        $div .= '<div class="col-12 col-sm-9">';
        $div .= '<div class="card-body">';
        $div .= '<h3 class="card-title text-break text-truncate">'.$adviser['name'].'</h3>';
        $div .= '<h5 class="card-title text-break text-truncate">'.$adviser['title'].'</h5>';
        $div .= '<hr>';
        $div .= '<div class="text-dark text-break text-truncate">'.$adviser['info'].'</div>';
        $div .= '<h6 class="text-dark">למידע נוסף לחץ כאן!</h6>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</div>';
        $div .= '</a>';
        $div .= '</div>';
    }
    return $div;
}

if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "getAdviersListByPage"){
        if(isset($_POST['page'])){
            $page = $_POST['page'];
            if(strlen($page) == 0){
                $page = 1;
            }
        }else{
            $page = 1;
        }
        //var_dump($page);
        $displayPerPage = 5;
        $start = ($page - 1) * $displayPerPage;
        $end = $page * $displayPerPage;
        //var_dump($start,$end, $_POST['page']);
        $advisers = getAdvisers($start, $end);
        $div = "";
        foreach($advisers as $adviser){
            $div .= getAdviserDivRow($adviser);
        }
        //var_dump($advisers);
        echo $div;
    }
    if($_POST['functionName'] == "getAdviserControl"){
        //echo var_dump();
        echo getPaginationNav($_POST['page'],"page","5",getAdvisersCount()['count']);
    }
}

?>
