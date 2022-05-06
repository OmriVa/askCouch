$(document).ready(function () {
    getRankReqCountById();
    $(document).on('click', '#uploadPic', function (e) {
        e.preventDefault();
        var userid = $("#uploadPic").val();
        var text = $("#rankText").val();
        var file = document.getElementById("picture").files[0];
        var formdata = new FormData();
        if (file !== undefined) {
            formdata.append("functionName", "rankreq");
            formdata.append("text", text);
            formdata.append("file1", file);
        }
        //console.log(formdata);
        sendPicture(formdata);
    });
});

function getRankReqCountById() {
    $.ajax({
        url: "./controlers/printers/reqController.php",
        method: "POST",
        data: {
            functionName: "getRankReqCountById"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("rankContent").innerHTML = $data;

        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function sendPicture(formdata) {
    $.ajax({
        url: "./controlers/printers/reqController.php",
        method: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function ($data) {
            console.log($data);
            if ($data == "succeed") {
                alert("הבקשה נקלטה בהצלחה");
                location.reload();
            } else {
                document.getElementById("answer").innerHTML = $data;
            }
        },
        error: function ($data) {},
    })
}
