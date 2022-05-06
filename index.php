<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - דף הבית</title>
    <title>Index ראשי</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/posts.js"></script>
    <script src="./js/index.js"></script>

</head>

<body style="font-family:'Ariel'">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 row mx-0 px-md-5">
        <div class="bg-white col-12 mb-2 p-1 text-right border d-block " id="articlesDisplay">

        </div>
        <div class="bg-white col-12 col-lg-8 mb-2 p-1 text-right border d-block">
            <div class="d-flex flex-row justify-content-between">
                <h1 class="font-weight-bold color-info">הפוסטים האחרונים: </h1>
                <span class="m-1 mt-2">
                    <a onclick="getAllPosts();spinButton();" href="javascript:void(0);" class="btn btn-info border" style="height:38px;"> <i id="spin" class="fas fa-sync"></i>
                    </a>
                </span>
            </div>

            <hr class="active-info">
            <div class="w-100 border mx-0 mb-2" id="postsdiv">
                <div class="fa-3x">
                    <i class="fas fa-spinner fa-spin d-flex justify-content-center" style="color:#ff7200"></i>
                </div>
            </div>
        </div>
        <aside class="bg-white col mr-lg-2 mb-2 p-0 text-right border d-block">
            <?php include('./controlers/printers/indexPrinter.php'); getLeaderBord()?>
        </aside>
    </div>
    <?php printFooter(); ?>
</body>

</html>
