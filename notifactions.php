<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMin($_SESSION['rank'], 1);?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - התראות</title>
    <title>Notifactions התראות</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/notifactions.js"></script>

</head>

<body>

    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-light customBody">
        <!-- Page Content -->
        <section id="content" class="d-flex row mx-0 py-4 px-2 d-flex justify-content-center text-right">
            <div class="col-12 col-md-9 px-2 py-2 bg-white border" id="root">

            </div>
        </section>

    </div>
    <?php printFooter(); ?>
</body>

</html>
