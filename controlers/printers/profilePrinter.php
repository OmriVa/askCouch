<?php
//require ('../users.php');
require ('../rating.php');
require ('../posts.php');
require ('../msg.php');

function getProfileContentById($id){
    $div ="";
    $user = getUserById($id);
    if(isset($user['userid'])){
    $stats = getUserStatsByUserId($id);
    $div .='';
    $div .='<div id="profileAside" class="col-12 col-sm-4 p-2 bg-white">';
    $div .='<div class="border h-100">';
    $div .='<div class="col-12 text-center p-2">';
    if($user['picture'] != ''){
        $div .='<img class="img-thumbnail" src="data:image/jpeg;base64,'.base64_encode($user['picture']).'"/>';
    }else{
        $div .='<span><i class=" fas fa-male fa-5x"></i></span>';
    }

    $div .='</div>';
    $div .='<div class="text-center">';
    $div .='<a class="btn btn-info text-white border" href="chat.php?freindId='.$id.'">שלח הודעה פרטית </a>';
    $div .='</div>';
    $div .='<hr>';
    $div .='<div>';
    $div .='<p class="m-0 p-2"><i class="fas fa-question text-info"></i> '.$stats[0].' שאלות</p>';
    $div .='</div>';
    $div .='<div>';
    $div .='<p class="m-0 p-2"><i class="fas fa-comments text-info"></i> '.$stats[1].' עצות</p>';
    $div .='</div>';
    $div .='<div>';
    $div .='<p class="m-0 p-2"><i class="fas fa-thumbs-up text-info"></i> '.$stats[2].' הצבעות בעד עצותי</p>';
    $div .='</div>';
    $div .='<div>';
    $div .='<p class="m-0 p-2"><i class="fas fa-thumbs-down text-info"></i> '.$stats[3].' הצבעות נגד עצותי</p>';
    $div .='</div>';
    $div .='</div>';
    $div .='</div>';
    //////
    
    
    $div .='<div id="profileHeader" class="col-12 col-sm-8 p-2  bg-white">';
    $div .='<div class="row border m-0">';
    $div .='<div class="col-12 py-2">';
    $div .='<h1>'.$user['name'].'</h1>';
    if(isset($user['title'])){
        $div .='<hr>';
        $div .='<h6>'.$user['title'].'</h6>';
    }
    $div .='</div>';
    $div .='</div>';
    $div .='<div id="profileBody" class="row m-0 mt-2 border">';
    $div .='<div class="w-100 p-2 m-2">';
    if(isset($user['info'])){
        $div .='<p>';
        $div .='<b>קצת עלי:</b>';
        $div .='<br>';
        $div .= $user['info'];
        $div .='</p>';
    }
    $div .='<a onclick="getPostsUserInvolved()" href="javascript:void(0);">פוסטים שהגבתי בהם לאחרונה</a><br>';
    $div .='<a onclick="getPostsOwned()" href="javascript:void(0);">פוסטים שפתחתי לאחרונה</a>';
    $div .='</div>';
    $div .='</div>';
    $div .='<div id="result" class="w-100 mt-2"></div>';
    $div .='</div>';
    
    ///sidebox
    //$div .='<div class="col py-2 px-2 mr-md-3 mt-md-0 mt-3 bg-white border">';
    //$div .='asd';
    //$div .='</div>';
    }else{
        $div .= '<div class="w-100 bg-white border p-2"><h1>משתמש לא קיים</h1></div>';
    }
    return $div;
}

function getUserStatsByUserId($userid){
    $postsOwend = getPostsCountByUserId($userid)['count'];
    $commentCount = getCommentCountByUserId($userid)['count'];
    $likes = getLikesCountByUserId($userid)['count'];
    $dislike = getDislikesCountByUserId($userid)['count'];
    $data = array ($postsOwend, $commentCount, $likes, $dislike);
return $data;
}


if(isset($_POST['functionName'])){
    if($_POST['functionName'] == "getProfileContentById"){
        echo json_encode(getProfileContentById($_POST['userid']));
    }
}

?>
