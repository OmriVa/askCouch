<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>

<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - פוסטים</title>
    <title>Posts פוסטים</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/browsePosts.js"></script>
</head>

<body style="font-family:'Ariel'">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 row mx-0 px-md-5">
        <div class="bg-white col-12 mb-2 text-right border d-block">
            <h1>פוסטים אחרונים</h1>
            <hr class="active-info">
            <div class="w-100 border mx-0 mb-2" id="postsdiv" style="#ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
                <div class="fa-3x">
                    <i class="fas fa-spinner fa-spin d-flex justify-content-center" style="color:#ff7200"></i>
                </div>
            </div>
            <div id="control">

            </div>
        </div>
    </div>

    <?php printFooter(); ?>
</body>

</html>
