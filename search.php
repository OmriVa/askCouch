<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - חיפוש</title>
    <title>Search חיפוש</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/search.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-md-4 py-4 text-right">

        <!-- Page Content -->
        <section class="row m-0 d-flex justify-content-center">
            <div class="col-12 col-md-10 p-0">
                <div class="p-3 bg-white border">
                    <h1>חיפוש</h1>
                    <hr class="active-info">
                    <p class="text-center">* זכור החיפוש מוגבל עד ל-50 תוצאות השתמש במילות חיפוש ספציפיות כלל הניתן</p>
                    <div id="searchResult">

                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
