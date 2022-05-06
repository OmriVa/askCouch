$(document).ready(function () {
    var word = getParam("word");
    getResults(word);
    $('#searchInput').val(decodeURI(word));
});

function getResults(word) {
    //getParam("word")
    $.ajax({
        url: "./controlers/printers/searchController.php",
        method: "POST",
        data: {
            functionName: "aa",
            word: word
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("searchResult").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
