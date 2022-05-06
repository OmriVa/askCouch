<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - פוסט</title>
    <title>Post פוסט</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/getposts.js"></script>
    <script src="./plugins/tinymce/js/tinymce/tinymce.min.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-md-4 py-4 text-right">

        <!-- Page Content -->
        <section class="row m-0">
            <div class="col-12 col-md-8 p-0">
                <div id="postContent" class="p-3 bg-white border">
                </div>
                <div id="commentSection" class="p-3 my-md-2 mt-3 bg-white border">
                </div>
            </div>
            <div class="col p-2 mr-md-2 mt-md-0 mt-3 bg-white border">
                asd
            </div>

        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
