<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - פרופיל</title>
    <title>Profile פרופיל</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/profile.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 text-right">

        <!-- Page Content -->
        <section id="profileBox" class="row m-0 col-12 text-break">
        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
