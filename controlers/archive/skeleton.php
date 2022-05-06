<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch</title>
    <title>Register הרשמה</title>
    <?php headerScriptLoader(); ?>
</head>

<body class="text-right">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4">

        <!-- Page Content -->
        <section class="row mx-0">
            <div class="col bg-white border p-2">
                <p>עברית</p>
            </div>

        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
