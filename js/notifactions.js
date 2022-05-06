$(document).ready(function () {
    //var word = getParam("word");
    getNotifactions();
});

function getNotifactions() {
    $.ajax({
        url: "./controlers/printers/notificationController.php",
        method: "POST",
        data: {
            functionName: "getNotifactions"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("root").innerHTML = $data;
        }
    });
}
