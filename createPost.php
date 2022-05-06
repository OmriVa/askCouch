<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMin($_SESSION['rank'], 1);?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouck - פרסם פוסט</title>
    <title>Create Post פרסם פוסט</title>
    <?php headerScriptLoader(); ?>
    <script src="./plugins/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="./js/createPost.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color row mx-0 px-2 py-4">
        <div class="bg-white col-12 col-md-10 col-lg-8 mb-2 mx-auto text-right border d-block">
            <div id="editor">
                <h1>פרסם שאלה</h1>
                <hr class="active-info">
                <form method="post">
                    <div class="form-group">
                        <label for="title">כותרת:</label>
                        <input type="tile" name="title" class="form-control" placeholder="נושא השאלה...." required="required">
                        <label for="content">תוכן השאלה:</label>
                        <textarea name="content" id="content"></textarea>
                    </div>

                    <div class="d-flex justify-content-center">
                        <input id="save" name="save" type="submit" value="שלח" class="btn btn-info my-2 mx-2" />
                        <input name="reset" type="reset" value="אפס" class="btn btn-info my-2 mx-2 " />
                    </div>
                </form>
            </div>
            <div id="errors"></div>
        </div>
    </div>
    <footer id=" sticky-footer" class="py-4 bg-white text-black-50">
        <div class="container text-center">
            <small>Copyright &copy; Your Website</small>
        </div>
    </footer>
</body>

</html>
