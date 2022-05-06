$(document).ready(function () {
    //get post
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getPostContentById",
            id: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("postContent").innerHTML += $data;
            if (!$data.startsWith('<h1 class="my-2">פוסט לא קיים</h1>')) {
                getComments();
                //getCommentSection();
            }

        },
        error: function ($data) {
            console.log($data);
        }
    });
    //insert new Comment
    $(document).on('click', '#sendSubmit', function (e) {
        e.preventDefault();
        sendComment();
        $('#sendSubmit').hide();
    });
    $(document).on('click', '#commentWihtoutReg', function (e) {
        e.preventDefault();
        commentWihtoutReg();
    });
    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        var username = $("input[name=username]").val();
        var email = $("input[name=email]").val();
        var comment = tinyMCE.get('unregister').getContent()
        //console.log(username, email, comment);
        sendUnregisterComment(username, email, comment);
    });
    $(document).on('click', 'input[name=send_comment]', function (e) {
        e.preventDefault();
        var comment = tinyMCE.get('CommentContent').getContent();
        //var send_comment = $('input[name=send_comment]').val();
        var sendinfo = {
            functionName: "send_comment",
            postid: getParam("Id"),
            comment: comment,
            parent: null,
        };
        $.ajax({
            url: "./controlers/printers/commentPrinter.php",
            method: "POST",
            data: sendinfo,
            dataType: "json",
            success: function ($data) {
                getComments();
            },
            error: function ($data) {
                console.log($data);
            }
        });
    });
    //sendComment
});


function getCommentSection() {
    //console.log("inside");
    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "getCommentSection"
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("sendComment").innerHTML = $data;
            callBasicTiny();
            getComments();
            this.hide();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getPostEditPanel() {
    //console.log("inside");
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getPostEditPanel",
            postId: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("postContent").innerHTML = $data;
            callBasicTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function sendPostUpdate() {
    var title = $("#title").val();
    var subtitle = $("#subtitle").val();
    var content = tinyMCE.activeEditor.getContent();
    var sendinfo = {
        "title": title,
        "content": content,
        "functionName": "sendPostUpdate",
        "id": getParam("Id")
    };
    console.log(sendinfo);
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: sendinfo,
        dataType: "html",
        success: function ($data) {
            alert("השאלה עודכנה בהצלחה.");
            location.reload();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getComments() {
    //getcomments
    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "getComments",
            postid: getParam("Id")
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("commentSection").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function insertRating(likeOrDislike, comment_id) {
    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "insertRating",
            likeOrDislike: likeOrDislike,
            commentId: comment_id,
        },
        dataType: "json",
        success: function ($data) {
            getComments();
        },
        error: function ($data) {
            //console.log($data);
        }
    });
}

function sendComment() {
    /*var $data = "";
    $data += '<textarea id="CommentContent"></textarea>';
    $data += '<div class="d-flex justify-content-center"><input type="submit" name="send_comment" value="שלח" class="btn btn-info my-2 mx-2"><input type="reset" name="reset" value="אפס" class="btn btn-info my-2 mx-2 "></div>';
    callBasicTiny();
    getComments();
    this.hide();*/

    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "getCommentInsert"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("sendComment").innerHTML += $data;
            callBasicTiny();
            //getComments();
        },
        error: function ($data) {
            console.log($data);
        }
    });

}

function commentWihtoutReg() {
    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "getNonRegisterCommnet"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("sendComment").innerHTML = $data;
            callBasicTiny();
            //getComments();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function sendUnregisterComment(username, email, comment) {
    $.ajax({
        url: "./controlers/printers/commentPrinter.php",
        method: "POST",
        data: {
            functionName: "sendUnregisterComment",
            userName: username,
            email: email,
            comment: comment,
            postId: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            if ($data.substring(0, 3) == "yes") {
                var str = "התגובה נקלטה בהצלחה, הסיסמא שלך היא: " + $data.substring(3);
                alert(str);
                location.reload();
            } else {
                alert($data);
            }
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
