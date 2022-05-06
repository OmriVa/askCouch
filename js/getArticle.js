$(document).ready(function () {
    //get article
    getArticle();
    $(document).on('click', '#uploadImgs', function (e) {
        e.preventDefault();
        //console.log("uploadImgs");
        //console.log($('#uploadImgs').val());
        uploadImgs($('#uploadImgs').val());
    });
    /*$(document).on('click', '#replaceImage', function (e) {
        e.preventDefault();
        //console.log("uploadImgs");
        console.log($(this).val());
        //replaceImage($('#replaceImage').val());
    });*/
});

function getArticle() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getArticleContentById",
            id: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("postContent").innerHTML = $data;

        },
        error: function ($data) {
            console.log($data);
        }
    });
}


function getEditArticlePanle() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getArticleEditorById",
            id: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("postContent").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}




function sendArticleUpdate() {
    var title = $("#title").val();
    var subtitle = $("#subtitle").val();
    var content = tinyMCE.activeEditor.getContent();
    var sendinfo = {
        "title": title,
        "subtitle": subtitle,
        "content": content,
        "functionName": "sendArticleUpdate",
        "id": getParam("Id")
    };
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: sendinfo,
        dataType: "html",
        success: function ($data) {
            alert("הפוסט עודכן בהצלחה!");
            document.getElementById("postContent").innerHTML = $data;
            //getArticle();
            location.reload();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function replaceImage(imgNumber) {
    var file = document.getElementById("picture").files[0];
    var formdata = new FormData();
    if (file !== undefined) {
        formdata.append("functionName", "replaceImage");
        formdata.append("imgNumber", imgNumber);
        formdata.append("articleId", getParam("Id"));
        formdata.append("file1", file);
    }
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function ($data) {
            console.log($data);
            if ($data == "succeed") {
                alert("התמונה עודכנה בהצלחה");
                location.reload();
            } else {
                document.getElementById("answer").innerHTML = $data;
            }
        },
        error: function ($data) {},
    })
}

function uploadImgs(start) {
    var files = document.getElementById("pictures").files;
    console.log(files);
    var formdata = new FormData();
    formdata.append("functionName", "uploadMoreImgs");
    formdata.append("start", start);
    formdata.append("articleId", getParam("Id"));
    for (var x = 0; x < files.length; x++) {
        formdata.append("pictures[]", files[x]);
    }
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function ($data) {
            console.log($data);
            alert("התמונות הועלו בהצלחה");
            location.reload();
        },
        error: function ($data) {},
        complete: function (data) {
            //console.log("uploaded!");
        }
    })
};

function articlePictureControl() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "articlePictureControl",
            id: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("postContent").innerHTML = $data;

        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function aproveArticle() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "aproveArticle",
            articleId: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            alert("המאמר אושר בהצלחה!");
            location.reload();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function cancelAproveArticle() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "cancelAproveArticle",
            articleId: getParam("Id")
        },
        dataType: "html",
        success: function ($data) {
            alert("הפעולה בוצעה בהצלחה!");
            location.reload();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
//var userid = $("#content").val();
