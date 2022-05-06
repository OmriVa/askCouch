<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMin($_SESSION['rank'], 1);?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - הגדרות</title>
    <title>Settings הגדרות</title>
    <?php headerScriptLoader(); ?>
    <script src="./plugins/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="./js/settings.js"></script>

</head>

<body>

    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-light customBody">

        <!-- Page Content -->
        <section id="content" class="d-flex row mx-0 my-0">
            <div id="mySidebar" class="text-right border bg-light col-12 col-md-3 mx-0">
                <h1>תפריט הגדרות</h1>
                <?php
                echo '<a href="#" class="nav-link" onclick=\'getUserProfileEditPanel()\'>עדכון פרטים</a>';      
                if($_SESSION['rank']<= 1){
                    echo '<a href="./rankreq.php" class="nav-link">בקשת דרגה - הצטרפות למייעצים</a>';
                }
                echo '<a href="#" class="nav-link" onclick=\'getPassChangePanel()\'>שינוי סיסמא</a>';
                if($_SESSION['rank']> 4){
                    echo '<a href="javascript:void(0)" class="nav-link"  onclick=\'getManagerOptions();\'>פאנל מנהל</a>';
                }       
                ?>
            </div>
            <div class="col-12 col-md-9 px-2 py-2" id="settingBody">
                <div class="col-12 text-right">
                    <div id="settingContent" class="m-2">

                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php printFooter(); ?>
</body>

</html>
