<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - התחבר</title>
    <title>Login התחבר</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/login.js"></script>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4">

        <!-- Page Content -->
        <section class="d-flex justify-content-center row mx-0">
            <div class="bg-white signup-form col-l-4 col-xl-4 col-md-6 col-sm-8 text-right border">
                <form action="./controlers/requests.php" method="post">
                    <center>
                        <h2 class="my-2">התחבר</h2>
                    </center>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope icon-user"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="כתובת איימל" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock icon-user"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="סיסמא" required="required" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();">
                        </div>
                    </div>
                    <div class=" form-group">
                        <button type="submit" name="login" value="login" class="btn btn-info btn-block btn-lg">התחבר</button>
                    </div>
                </form>
                <div class="text-center border border-info m-1">
                    <a href="#" id="testuser">לחץ כאן למילוי פרטים אוטומתי לצורך הדגמת האתר</a>
                </div>
                <div class="text-center pb-2">
                    שכחת את הסיסמא? <a href="#">שחזור סיסמא</a>.
                </div>
            </div>

        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
