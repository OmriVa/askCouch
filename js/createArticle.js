$(document).ready(function (e) {
    callTiny();
    //getMultiPictureUploadDiv();
    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        sendArticle();
    });
    $(document).on('click', '#uploadImgs', function (e) {
        e.preventDefault();
        uploadimg();
    });
});

function uploadimg() {
    var files = document.getElementById("pictures").files;

    var formdata = new FormData();
    formdata.append("functionName", "uploadimg");
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
            document.getElementById("showpics").innerHTML = $data;
            //console.log($data);
        },
        error: function ($data) {},
        complete: function (data) {
            //console.log("uploaded!");
        }
    })

};

function deleteImg(name) {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "deleteImg",
            imgName: name
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("freindList").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getPictureUploadDivs() {
    var title = $("input[name=title]").val();
    var subTitle = $("input[name=subTitle]").val();
    var content = tinyMCE.activeEditor.getContent();
    var sendinfo = {
        "functionName": "sendArticle",
        "title": title,
        "subTitle": subTitle,
        "content": content
    };
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: sendinfo,
        dataType: "JSON",
        success: function ($data) {
            document.getElementById("showpics").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getMultiPictureUploadDiv() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getMultiPictureUploadDiv",
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("showpics").innerHTML = $data;
        },
        error: function ($data) {
            document.getElementById("showpics").innerHTML = $data;
        }
    });
}

function sendArticle() {
    var title = $("input[name=title]").val();
    var subTitle = $("input[name=subTitle]").val();
    var content = tinyMCE.activeEditor.getContent();
    var sendinfo = {
        "functionName": "sendArticle",
        "title": title,
        "subTitle": subTitle,
        "content": content
    };

    if (title && subTitle && content) {
        $.ajax({
            url: "./controlers/printers/articlePrinter.php",
            method: "POST",
            data: sendinfo,
            //contentType: "application/json; charset=utf-8",
            dataType: "html",
            success: function ($data) {
                document.getElementById("editor").innerHTML = $data;
            },
            error: function ($data) {
                console.log($data);
            }
        });
    }

}
