<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - מאמר</title>
    <title>Article מאמר</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/getArticle.js"></script>
    <script src="./plugins/tinymce/js/tinymce/tinymce.min.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-md-4 py-4 text-right">

        <!-- Page Content -->
        <section class="row m-0 d-flex justify-content-center">
            <div class="col-12 col-md-10 p-0">
                <div id="postContent" class="p-3 bg-white border">
                </div>
            </div>
        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
