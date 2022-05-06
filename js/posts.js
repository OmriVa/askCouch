$(document).ready(function () {
    var div = "";
    getAllPosts();
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

function spinButton() {
    document.getElementById("spin").classList.add('fa-spin');

    setTimeout(function () {
        document.getElementById("spin").classList.remove('fa-spin')
    }, 1000);

}
