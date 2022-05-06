$(document).ready(function () {
    getAdviserListByPage();
});


function getAdviserListByPage() {
    $.ajax({
        url: "./controlers/printers/adviserPrinter.php",
        method: "POST",
        data: {
            functionName: "getAdviersListByPage",
            page: getParam("page")
        },
        dataType: "html",
        success: function (data) {
            document.getElementById("advisersList").innerHTML = data;
            getAdviserControl();
        }
    });

}

function getAdviserControl() {
    $.ajax({
        url: "./controlers/printers/adviserPrinter.php",
        method: "POST",
        data: {
            functionName: "getAdviserControl",
            page: getParam("page")
        },
        dataType: "html",
        success: function (data) {
            document.getElementById("control").innerHTML = data;
        }
    });
}
