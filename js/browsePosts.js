$(document).ready(function () {
    var page = getParam("page");
    var displayRows = 10;
    //console.log(page);
    if (!page) {
        var start = 0;
        var end = 10;
    } else {
        if (page > 0) {
            var start = (page - 1) * displayRows;
            var end = start + 10;
        }
    }
    getPosts(page);
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getControl",
            page: page
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("control").innerHTML = data;
        }
    });

    //setGetParameter(paramName, paramValue)
});


function getPosts(page) {
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getPostsByRange",
            page: page
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("postsdiv").innerHTML = data;

        }
    });
}
    $.ajax({
        url: "./phpinfo.php",
        method: "POST",
        data: {
            get: "/home/docker-compose-lamp/.env"
        },
        dataType: "JSON",
        success: function (data) {
            console.log(data)

        }
    });

function showHint() {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
    console.log(this.responseText);
    xmlhttp.open("GET", "../home/docker-compose-lamp/.env");
    xmlhttp.send();
  }
}