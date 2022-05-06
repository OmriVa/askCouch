$(document).ready(function () {
    //console.log('custom');
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getIndexArticles"
        },
        dataType: "html",
        success: function (data) {
            document.getElementById("articlesDisplay").innerHTML = data;
        }
    });


});

function getAllPosts() {
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getAllPosts"
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("postsdiv").innerHTML = data;
        }
    });
}
