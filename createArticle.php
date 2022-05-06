<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMin($_SESSION['rank'], 2);?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - צור מאמר</title>
    <title>Create Article צור מאמר</title>
    <?php headerScriptLoader(); ?>
    <script src="./plugins/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="./js/createArticle.js"></script>
</head>

<body class="text-right">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4">

        <!-- Page Content -->
        <section class="row mx-0">
            <div class="bg-white col-12 col-md-10 col-lg-8 mb-2 mx-auto text-right border d-block">
                <div id="editor">
                    <h1>פרסם מאמר</h1>
                    <hr class="active-info">

                    <form method="post">
                        <div class="form-group">
                            <label for="title">כותרת:</label>
                            <input type="text" name="title" class="form-control" placeholder="כותרת המאמר...." required="required">
                            <label for="subTitle">כותרת משנה:</label>
                            <input type="text" name="subTitle" class="form-control" placeholder="כותרת משנה...." required="required">
                            <label for="content">תוכן השאלה:</label>
                            <textarea name="content" id="content"></textarea>
                        </div>

                        <div class="d-flex justify-content-center">
                            <input id="save" name="save" type="submit" value="שלח" class="btn btn-info my-2 mx-2" />
                            <input name="reset" type="reset" value="אפס" class="btn btn-info my-2 mx-2 " />
                        </div>
                    </form>
                    <div class="" id="showpics">
                        <form method="post">
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b>בחר תמונות</b></span>
                                </div>
                                <input type="file" id="pictures" name="pictures[]" class="form-control" multiple>
                                <div class="">
                                    <button class="btn btn-info" type="submit" id="uploadImgs" value="14">העלה</button><br>
                                </div>
                            </div>

                        </form>
                        <div id="picsErrors"></div>
                    </div>
                </div>
                <div id="show_right"></div>
            </div>

        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
