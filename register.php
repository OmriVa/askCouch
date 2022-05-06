<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start();?>
<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - הרשם</title>
    <title>Register הרשמה</title>
    <?php headerScriptLoader(); ?>
</head>

<body>
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4">

        <!-- Page Content -->
        <section class="d-flex justify-content-center">
            <div class="bg-white signup-form col-12 col-md-8 col-lg-6 text-right border">
                <form action="./controlers/requests.php" method="post">
                    <h2>הרשם אלינו!</h2>
                    <p class="lead">זה בחינם וזה לוקח פתוח מ-30 שניות</p>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user icon-user"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="שם מלא" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope icon-user"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="כתובת איימל" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar-day icon-user"></i></span>
                            <input type="date" class="form-control" name="date" placeholder="תאריך לידה" required="required" value="2000-1-1" lang="he">
                        </div>
                    </div>
                    <div class=" form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-unlock icon-user"></i>
                            </span>
                            <input type="password" id="password" class="form-control" name="password" placeholder="סיסמא" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock icon-user "></i>
                            </span>
                            <input type="password" id="password2" class="form-control" name="confirm_password" placeholder="אימות סיסמא" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block btn-lg" name="reg_user">הרשם</button>
                    </div>

                </form>
                <div class="text-center">כבר יש לך משתמש? <a href="login.php">התחבר כאן</a>.</div>
            </div>
        </section>
    </div>
    <?php printFooter(); ?>
</body>

</html>
