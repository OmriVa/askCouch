<?php

//post.php

/**
 * Start the session.
 */
session_start();

/**
 * Include our MySQL connection.
 */
require './controlers/db.php';
    var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Post</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>

<body>
    <br />
    <h2 align="center"><a href="#">Comment</a></h2>
    <br />
    <div class="container">
        <form method="POST" id="comment_form">
            <div class="form-group">
                <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
            </div>
            <div class="form-group">
                <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="comment_id" id="comment_id" value="0" />
                <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
            </div>
        </form>
        <span id="comment_message"></span>
        <br />
        <div id="display_comment"></div>
    </div>
</body>

</html>
