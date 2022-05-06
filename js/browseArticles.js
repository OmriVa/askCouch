$(document).ready(function () {
    var page = getParam("page");
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getArticlesByRange",
            page: page
        },
        dataType: "html",
        success: function (data) {
            document.getElementById("articles").innerHTML = data;
        }
    });
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getControl",
            page: page
        },
        dataType: "html",
        success: function (data) {
            document.getElementById("control").innerHTML = data;
        }
    });
});
