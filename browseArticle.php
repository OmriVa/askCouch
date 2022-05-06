<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>

<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - מאמרים</title>
    <title>Article מאמרים</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/browseArticles.js"></script>
</head>

<body style="font-family:'Ariel'">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 row mx-0 px-md-5">
        <div class="bg-white col-12 mb-2 text-right border d-block">
            <h1>מאמרים אחרונים</h1>
            <hr class="active-info">
            <div class="w-100 mx-0 mb-2" id="articles">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-4 bg-light  d-flex align-items-center">
                            <img src="./uploads/tests/2.jpg" class="card-img" alt="...">
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title text-break text-truncate">Card title</h5>
                                <p class="card-text text-break">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text text-break text-truncate"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="control"></div>
        </div>
        <?php
        if(isset($_SESSION['rank'])){
            if($_SESSION['rank'] >= 2){
                echo '<div class="bg-white col-12 mb-2 p-3 text-right border d-block">';
                echo '<a href="createArticle.php" class="btn btn-info btn-block btn-lg">פרסם מאמר</a>';
                echo '</div>';
            }
        }
        ?>
    </div>

    <?php printFooter(); ?>
</body>

</html>
