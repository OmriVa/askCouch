<?php
//session_start();
require ('../posts.php');
require ('../users.php');
require ('../article.php');

function searchResult($word){
    if(!ctype_space($word) && strlen($word)>1){
        $posts = searchPosts($word,30);
        $articles = searchArticles($word,10);
        $users = searchUser($word,10);
    }else{
        $posts = "";
        $articles = "";
        $users = "";
    }
    //var_dump($word);
    //var_dump(urldecode($word));
    //var_dump($users);
    $div = "";
    $div .='<div class="accordion" id="accordionExample">';
    $div .='<div class="card">';
    $div .='<div class="card-header" id="headingOne">';
    $div .='<h2 class="mb-0">';
    if(is_array($posts)){
        $div .='<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">פוסטים/שאלות('.sizeof($posts).')';
    }else{
        $div .='<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">פוסטים/שאלות(0)';
    }

    $div .='</button>';
    $div .='</h2>';
    $div .='</div>';

    $div .='<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">';
    $div .='<div class="card-body w-100">';
    if(is_array($posts)){
        if(sizeof($posts)>0){
            foreach($posts as $post){
                $div .= postRow($post);
            }
        }else{
                $div .= '<h3>אין תוצאות</h3>';
        }
    }
    $div .='</div>';
    $div .='</div>';
    $div .='</div>';
    $div .='<div class="card">';
    $div .='<div class="card-header" id="headingTwo">';
    $div .='<h2 class="mb-0">';
    if(is_array($articles)){
        $div .='<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">מאמרים('.sizeof($articles).')';
    }else{
        $div .='<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">מאמרים(0)';
    }
    $div .='</button>';
    $div .='</h2>';
    $div .='</div>';
    $div .='<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">';
    $div .='<div class="card-body">';
    if(is_array($articles)){
        if(sizeof($articles)>0){
            foreach($articles as $article){
                $div .= articleRow($article);
            }
        }else{
                $div .= '<h3>אין תוצאות</h3>';
        }
    }
    $div .='</div>';
    $div .='</div>';
    $div .='</div>';
    $div .='<div class="card">';
    $div .='<div class="card-header" id="headingThree">';
    $div .='<h2 class="mb-0">';
    if(is_array($articles)){
        $div .='<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">משתמשים('.sizeof($users).')';
    }else{
        $div .='<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">משתמשים(0)';
    }
    $div .='</button>';
    $div .='</h2>';
    $div .='</div>';
    $div .='<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">';
    $div .='<div class="card-body">';
    if(is_array($users)){
        if(sizeof($users)>0){
            foreach($users as $user){
                $div .= userRow($user);
            }
        }else{
                $div .= '<h3>אין תוצאות</h3>';
        }
    }

    $div .='</div>';
    $div .='</div>';
    $div .='</div>';
    $div .='</div>';
    echo $div;
}

function postRow($post){
    $div = "";
    $div .=  '<a href="getpost.php?Id='.$post['postid'].'">';
    $div .= '<div class="row m-0 mb-1 text-dark">';
    $div .= '<div class="col-12 col-md-9 border px-2  text-truncate text-break">';
    $div .= '<h6>'.htmlspecialchars($post['title']).'</h6>';
    $div .= '<small>';
    $div .= '<font color="grey">(פורסם ע"י: '.htmlspecialchars($post['name']).' הועלה ב: '.$post['date'].')</font>';
    $div .= '</small>';
    $div .= '</div>';
    $div .= '<div class="col mr-1 border"><b></b>';
    $div .= '<center><b>'.htmlspecialchars($post['reply']).'</b><small> <br>';
    $div .= '<font color="grey">עצות</font>';
    $div .= '</small></center>';
    $div .= '</div>';
    $div .= '<div class="col mr-1 border"><b></b>';
    $div .= '<center><b>'.htmlspecialchars($post['views']).'</b><small> <br>';
    $div .= '<font color="grey">צפיות</font>';
    $div .= '</small></center>';
    $div .= '</div>';
    $div .= '</div></a>';
    return $div;
}

function articleRow($article){
    $div = "";
    $div .=  '<a href="getArticle.php?Id='.$article['articleid'].'">';
    $div .= '<div class="row m-0 mb-1 text-dark">';
    $div .= '<div class="col d-flex align-items-center" style="background: url('.getArticleFirstImgLink($article['articleid']).') no-repeat center scroll;background-size:cover; height:50px;"> </div>';
    $div .= '<div class="col-9 border px-2  text-truncate text-break">';
    $div .= '<h6>'.htmlspecialchars($article['title']).'</h6>';
    $div .= '<small>';
    $div .= '<font color="grey">(פורסם ע"י: '.htmlspecialchars($article['name']).' הועלה ב: '.$article['createDate'].')</font>';
    $div .= '</small>';
    $div .= '</div>';
    $div .= '</div></a>';
    return $div;
}

function userRow($user){
    $div = "";
    $div .=  '<a href="profile.php?profileId='.$user['userid'].'">';
    $div .= '<div class="row m-0 mb-1 text-dark">';
    $div .= '<div class="col ml-1 border"><b></b>';
    $div .= '<center><b>'.htmlspecialchars($user['userid']).'</b><small> <br>';
    $div .= '<font color="grey">מס\' משתמש</font>';
    $div .= '</small></center>';
    $div .= '</div>';
    $div .= '<div class="col-10 border px-2  text-truncate text-break">';
    $div .= '<h6>'.htmlspecialchars($user['name']).'</h6>';
    if($user['name'] != ""){
        $div .= '<h3 class="h3">'.htmlspecialchars($user['title']).'</h3>';
    }
    $div .= '<small>';
    $div .= '<font color="grey">נרשם בתאריך: '.$user['createdata'].'</font>';
    $div .= '</small>';
    $div .= '</div>';
    $div .= '</div></a>';
    return $div;
}

if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "getAdviersListByPage"){
    }
    if($_POST['functionName'] == "aa"){
        $word = urldecode($_POST['word']);
        searchResult($word);
    }
}

?>
