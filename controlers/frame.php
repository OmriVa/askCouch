<?php 
require 'notifications.php';

function headerScriptLoader(){
    //echo '<script src="./plugins/jQuery/Popper.js" crossorigin="anonymous"></script>';
    //echo '<script src="./plugins/jQuery/popper.min.js" crossorigin="anonymous"></script>';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="stylesheet" href="./plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css" crossorigin="anonymous">';
    echo '<script src="./plugins/jQuery/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>';
    //<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    echo '<link href="./plugins/Robto-font/" rel="stylesheet">';
    echo '<script src="./plugins/bootstrap-4.3.1-dist/js/bootstrap.min.js" crossorigin="anonymous"></script>';
    echo '<link rel="stylesheet" href="./plugins/fontawesome-free-5.10.1-web/css/all.css" crossorigin="anonymous">';
    echo '<script src="./js/costum.js"></script>';
    echo '<link rel="stylesheet" href="./css/custom.css">';
}

function printHeader($currentPage)
{
        echo'<header>';
        echo'<div>';
        echo'    <div class="navbar navbar-expand-md navbar-light row mx-0">';
        echo'        <div class="col-md-6 d-flex justify-content-center justify-content-md-start">';
        echo'            <img src="img/Untitled-2.png" alt="logo" class="img-fluid">';
        echo'        </div>';
        echo'        <div class="col-md-6 d-flex justify-content-center justify-content-md-end py-2">';
        echo'            <form class="form-inline">';
        echo'                <div class="input-group-prepend">';
        echo'                    <input class="form-control mr-sm-2" type="search" placeholder="חיפוש" aria-label="Search" id="searchInput">';
        echo'<button class="btn btn-info border" id="search" style="height:38px;"> <i class="fas fa-search text-white icon-user active-color"></i>   </button>';
        echo'                </div>';
        echo'            </form>';
        if(isset($_SESSION['userid'])){
            if($currentPage=="settings.php"){
                echo'<a href="./settings.php"><button class="btn btn-info border active-background" style="height:38px;">';
            }else{
                echo'<a href="./settings.php"><button class="btn btn-info border" style="height:38px;">'; 
            }
            echo' <i class="fas fa-cog text-white icon-user active-color"></i>';
            echo'                    </button><a>';
            if($currentPage=="chat.php"){
                echo '<a href="chat.php"  class="btn btn-info border active-background" style="height:38px;"><i class="fas fa-comment"></i></a>';     
            }else{
                echo '<a href="chat.php"  class="btn btn-info border " style="height:38px;"><i class="fas fa-comment"></i></a>';
            }
            if($currentPage=="notifactions.php"){
                echo '<a href="notifactions.php"  class="btn btn-info border active-background" style="height:38px;"><i class="fas fa-bell"> '.getNotifcationsCount($_SESSION['userid'])['count'].'</i></a>';     
            }else{
                echo '<a href="notifactions.php"  class="btn btn-info border " style="height:38px;"><i class="fas fa-bell"> '.getNotifcationsCount($_SESSION['userid'])['count'].'</i></a>';
            }

        }
        echo'        </div>';
        echo'    </div>';
        echo'</div>';
        echo'<div>';
        echo'    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-expand-xl text-right navbar-dark bg-dark">';
        echo'        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">';
        echo'           <span class="navbar-toggler-icon"></span>';
        echo'        </button>';
        echo'        <div class="navbar-collapse collapse justify-content-start" id="navbarSupportedContent ">';
        echo'            <ul class="nav navbar-nav  ml-auto w-100 justify-content-start">';
        echo'                <li class="nav-item">';
        if($currentPage=="index.php")
        {
            echo'                    <a class="nav-link text-white font-weight-bold active" href="#">ראשי</a>';
        }
        else
        {
            echo'                    <a class="nav-link text-white font-weight-bold" href="index.php">ראשי</a>';
        }
        echo'                </li>';
        echo'                <li class="nav-item">';
        if($currentPage=="createPost.php")
        {
            echo'                    <a class="nav-link text-white font-weight-bold active" href="#">פרסם שאלה</a>';
        }
        else{
            echo'                    <a class="nav-link text-white font-weight-bold" href="createPost.php">פרסם שאלה</a>';
        }

        echo'                </li>';
        echo'                <li class="nav-item">';
        if($currentPage=="browsePosts.php")
        {
            echo'                    <a class="nav-link text-white font-weight-bold active" href="#">פוסטים</a>';
        }
        else
        {
            echo'                    <a class="nav-link text-white font-weight-bold" href="browsePosts.php">פוסטים</a>';    
        }
        echo'                </li>';
        echo'                </li>';
        echo'                <li class="nav-item">';
        if($currentPage=="browseArticle.php")
        {
            echo'                    <a class="nav-link text-white font-weight-bold active" href="#">מאמרים</a>';
        }
        else
        {
            echo'                    <a class="nav-link text-white font-weight-bold" href="browseArticle.php">מאמרים</a>';    
        }
        echo'                </li>';
        echo'                <li class="nav-item">';
        if($currentPage=="advisers.php")
        {
            echo'                    <a class="nav-link text-white font-weight-bold active" href="#">המייעצים שלנו</a>';
        }
        else
        {
            echo'                    <a class="nav-link text-white font-weight-bold" href="advisers.php">המייעצים שלנו</a>';    
        }
        echo'                </li>';
        if(isset($_SESSION['name'])){
            echo '<li class="nav-item"><a class="nav-link text-white font-weight-bold btn-hover" href="logout.php">'.$_SESSION['name'].' התנתק</a></li>';
        }
        else
        {
            if($currentPage=="login.php")
            {
                echo '<li class="nav-item"><a class="nav-link text-white font-weight-bold active" href="#">התחבר</a></li>';
            }
            else
            {
                echo '<li class="nav-item"><a class="nav-link text-white font-weight-bold" href="login.php">התחבר</a></li>';
            }
            if($currentPage=="register.php")
            {
                echo '<li class="nav-item"><a class="nav-link text-white font-weight-bold active" href="#">הרשם</a></li>';
            }
            else
            {
                echo '<li class="nav-item"><a class="nav-link text-white font-weight-bold" href="register.php">הרשם</a></li>';
            }
        }
        echo'            </ul>';
        echo'        </div>';
        echo'    </nav>';
        echo'</div>';
        echo'</header>';
}

function printFooter()
{
    echo'<footer id="sticky-footer" class="py-4 bg-white text-black-50">';
    echo'    <div class="container text-center">';
    echo'        <small>Copyright &copy; Your Website</small>';
    echo'    </div>';
    echo'</footer>';
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
    $div .= '<p>*אתה הופך לחלק מקהילת הכושר המשפחתית שיתופית שלנו<br>*יש לך הרשאות לפתוח פוסטים לנהל שיחות עם שאר חברי הקהילה<br>*אצלנו בקהילה כל אחד יכול להפוך לחלק מצוות האתר.<br>*אתה איש מקצוע בתחום הכושר? מצויין! אצלנו תוכל לקבל חשיפה בדף המייעצים שלנו והרשאות מורחבות לפרסם מאמרים.';
    $div .= '</p>';
    $div .= '</div>';
    $div .= '<a class="btn btn-info active-background m-1 border" href="#">הגב ללא רשמה</a>';
    $div .= '<a class="btn btn-info active-background m-1 border"   href="register.php">הרשם עכשיו!</a>';
    $div .= '<br>';
    $div .= '<a href="login.php">(או התחבר אם אתה כבר רשום)</a>';
    $div .= '</div>';
    $div .= '</div>';
    echo $div;
}


function redirectByRankMin($userRank, $minRank){
    if(is_null($userRank))
    {
        header("Location: ./index.php");
        return;
    }else{
        if($userRank >= $minRank){
            return;
        }else{
            header("Location: ./index.php");
        }
    }
}


function redirectByRankMinAndMax($userRank, $minRank, $maxRank){
    if(is_null($userRank))
    {
        header("Location: ./index.php");
        return;
    }else{
        if($userRank >= $minRank && $userRank <= $maxRank){
            return;
        }else{
            header("Location: ./index.php");
        }
    }
}



    
?>
