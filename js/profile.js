$(document).ready(function () {
    getProfile();
});

function getProfile() {
    $.ajax({
        url: "./controlers/printers/profilePrinter.php",
        method: "POST",
        data: {
            functionName: "getProfileContentById",
            userid: getParam("profileId")
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("profileBox").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getPostsOwned() {
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getPostsOwned",
            userid: getParam("profileId")
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("result").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getPostsUserInvolved() {
    $.ajax({
        url: "./controlers/printers/postPrinter.php",
        method: "POST",
        data: {
            functionName: "getPostsUserInvolved",
            userid: getParam("profileId")
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("result").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
