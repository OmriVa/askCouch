<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMinAndMax($_SESSION['rank'], 1, 1);?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - בקשת דרגה</title>
    <title>RankReq בקשת דרגה</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/rankreq.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-md-4 py-4 text-right">

        <!-- Page Content -->
        <section class="row m-0 d-flex justify-content-center">
            <div class="col-12 col-md-10 p-0">
                <div id="rankContent" class="p-3 bg-white border">

                </div>
            </div>
        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
