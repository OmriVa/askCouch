<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>

<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch</title>
    <title>Posts פוסטים</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/posts.js"></script>
</head>

<body style="font-family:'Ariel'">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 row mx-0 px-md-5">
        <aside class="bg-white col-12 col-lg-4 ml-lg-2 mb-2 p-0 text-right border d-block">
            <?php include('./controlers/printers/indexPrinter.php'); getLeaderBord()?>


        </aside>
        <div class="bg-white col mb-2 p-1 text-right border d-block">
            <h1 class="font-weight-bold">הפוסטים האחרונים:</h1>
            <hr>
            <div class="w-100 border mx-0 mb-2" id="postsdiv">
                <div class="fa-3x">
                    <i class="fas fa-spinner fa-spin d-flex justify-content-center" style="color:#ff7200"></i>
                </div>
            </div>
        </div>
        <div class="bg-white col-12 text-right border d-block justify-content-end" style="height:400px">
            <?php     var_dump($_SESSION);
                var_dump(basename($_SERVER['PHP_SELF']));?>
        </div>
    </div>

    <?php printFooter(); ?>
</body>

</html>
