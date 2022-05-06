$(document).ready(function () {
    $(document).on('click', '#submit_user', function (e) {
        e.preventDefault();
        //remove the first 11 lettter so it can check if is not search empty
        var data = $('#searchUser').serialize();
        if (data.slice(11)) {
            $.ajax({
                url: "./controlers/printers/settingsPrinter.php",
                method: "POST",
                data: data,
                dataType: "json",
                success: function ($data) {
                    document.getElementById("showUsers").innerHTML = $data;
                },
                error: function ($data) {
                    console.log($data);
                }
            })
        }

    });
    $(document).on('click', '#pass_change', function (e) {
        e.preventDefault();
        //console.log("pass_change");
        var old_password = $("input[name=oldPassword]").val();
        var password = $("input[name=password]").val();
        var password_confirm = $("input[name=confirm_password]").val();
        //console.log(password, password_confirm, old_password);
        changePass(password, password_confirm, old_password);
    });
    $(document).on('click', '#chosed', function (e) {
        e.preventDefault();
        var radioboxs = document.getElementsByName('userid[]');
        var val;
        for (var i = 0, length = radioboxs.length; i < length; i++) {
            if (radioboxs[i].checked) {
                val = radioboxs[i].value;
            }
        }
        ajaxChosed(val);
    });
    $(document).on('keypress', 'input[name=newuserid]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeUserid').click();
        }
    });

    $(document).on('click', '#changeUserid', function (e) {
        e.preventDefault();
        var newuserid = $("input[name=newuserid]").val();
        var userid = $("#changeUserid").val();
        var sendinfo = {
            "newuserid": newuserid,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, newuserid);
    });
    $(document).on('keypress', 'input[name=newName]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeName').click();
        }
    });
    $(document).on('click', '#changeName', function (e) {
        e.preventDefault();
        var newName = $("input[name=newName]").val();
        var userid = $("#changeName").val();

        var sendinfo = {
            "newName": newName,
            "userid": userid,
        };
        console.log(sendinfo);
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newEmail]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeEmail').click();
        }
    });
    $(document).on('click', '#changeEmail', function (e) {
        e.preventDefault();
        var newEmail = $("input[name=newEmail]").val();
        var userid = $("#changeEmail").val();
        var sendinfo = {
            "newEmail": newEmail,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newPassword]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changePassword').click();
        }
    });
    $(document).on('click', '#changePassword', function (e) {
        e.preventDefault();
        var newPassword = $("input[name=newPassword]").val();
        var userid = $("#changePassword").val();
        var sendinfo = {
            "newPassword": newPassword,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newTitle]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeTitle').click();
        }
    });
    $(document).on('click', '#changeTitle', function (e) {
        e.preventDefault();
        var newTitle = $("input[name=newTitle]").val();
        var userid = $("#changeTitle").val();
        var sendinfo = {
            "newTitle": newTitle,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newBirthday]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeBirthday').click();
        }
    });
    $(document).on('click', '#changeBirthday', function (e) {
        e.preventDefault();
        var newBirthday = $("input[name=newBirthday]").val();
        var userid = $("#changeBirthday").val();
        var sendinfo = {
            "newBirthday": newBirthday,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newInfo]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeInfo').click();
        }
    });
    $(document).on('click', '#changeInfo', function (e) {
        e.preventDefault();
        //var newInfo = $("input[name=newInfo]").val();
        var newInfo = tinyMCE.activeEditor.getContent();
        //console.log(newInfo);
        var userid = $("#changeInfo").val();
        var sendinfo = {
            "newInfo": newInfo,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'textarea[name=newStamp]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeStamp').click();
        }
    });
    $(document).on('click', '#changeStamp', function (e) {
        e.preventDefault();
        var newStamp = tinyMCE.activeEditor.getContent();
        console.log(newStamp);
        var userid = $("#changeStamp").val();
        var sendinfo = {
            "newStamp": newStamp,
            "userid": userid,
        };
        ajaxEditUser(sendinfo, userid);
    });
    $(document).on('keypress', 'input[name=newRank]', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#changeRank').click();
        }
    });
    $(document).on('click', '#changeRank', function (e) {
        e.preventDefault();
        var newRank = $("input[name=newRank]").val();
        var userid = $("#changeRank").val();
        var sendinfo = {
            "newRank": newRank,
            "userid": userid,
        };
        console.log(sendinfo);
        ajaxEditUser(sendinfo, userid);
    });


    //RANK REQ BUTTONS
    $(document).on('click', '#acceptRank', function (e) {
        e.preventDefault();
        var e = document.getElementsByName("ranks")[0];
        var rankLvl = e.options[e.selectedIndex].value;
        var title = $("#rankTitle").val();
        var userid = $("#acceptRank").val();;
        var sendinfo = {
            "functionName": "rankGranted",
            "rankLvl": rankLvl,
            "title": title,
            "userId": userid
        };
        $.ajax({
            url: "./controlers/printers/reqController.php",
            method: "POST",
            data: sendinfo,
            dataType: "html",
            success: function ($data) {
                alert("הבקשה אושרה בהצלחה");
            },
            error: function ($data) {
                console.log($data);
            }
        });
    });
    $(document).on('click', '#refuseRank', function (e) {
        e.preventDefault();
        var userid = $("#refuseRank").val();;
        var sendinfo = {
            "functionName": "refuseReq",
            "userId": userid
        };
        $.ajax({
            url: "./controlers/printers/reqController.php",
            method: "POST",
            data: sendinfo,
            dataType: "html",
            success: function ($data) {
                alert("הבקשה סורבה בהצלחה");
            },
            error: function ($data) {
                console.log($data);
            }
        });
    });

    $(document).on('click', '#changePicture', function (e) {
        e.preventDefault();
        var userid = $("#changePicture").val();
        var file = document.getElementById("newPicture").files[0];
        var formdata = new FormData();
        if (file !== undefined) {
            formdata.append("file1", file);
            formdata.append("userid", userid);
        }
        var sendinfo = {
            "newPicture": formdata,
            "userid": userid
        };
        console.log(sendinfo);
        $.ajax({
            url: "./controlers/requests.php",
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function ($data) {
                document.getElementById("editPanelMsg").innerHTML = $data;
                //console.log($data);
            },
            error: function ($data) {},
            complete: function (data) {
                //console.log("uploaded!");
            }
        })
    });
    getUserProfileEditPanel();
});

function changePass(password, password_confirm, old_password) {
    //passwordChange($_POST['password'],$_POST['password_confirm'],$_POST['old_password'])
    $.ajax({
        url: "./controlers/requests.php",
        method: "POST",
        data: {
            functionName: "changePass",
            password: password,
            password_confirm: password_confirm,
            old_password: old_password
        },
        dataType: "json",
        success: function ($data) {
            console.log($data);
            if ($data[0] == "yes") {
                alert("הסיסמא שונתה בהצלחה!")
                location.reload();
            } else {
                var alertString = "";
                for (var i = 0; i < $data.length; i++) {
                    alertString += $data[i];
                    console.log($data[i]);
                }
                document.getElementById("passAnswer").innerHTML = alertString;
            }
        },
        error: function ($data) {}
    })
}

function ajaxChosed($val) {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "POST",
        data: {
            editUser: $val
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("showUsers").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {}
    })
}

function ajaxEditUser($sendinfo, $userId) {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "POST",
        data: $sendinfo,
        dataType: "json",
        success: function ($data) {
            document.getElementById("editPanelMsg").innerHTML = $data;
        },
        error: function ($data) {},
        complete: function (data) {
            $(document).ready(ajaxChosed($userId));
            alert("עודכן בהצלחה");
        }
    })
}

function getUserProfileEditPanel() {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "GET",
        data: {
            FunctionName: 'getUserProfileEditPanel',
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    })
}

function getManegerPanel() {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "GET",
        data: {
            FunctionName: 'getManegerPanel',
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    })

}

function getPassChangePanel() {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "GET",
        data: {
            FunctionName: 'getPassChangePanel',
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    })

}


function getPHPSessId() {
    var phpSessionId = document.cookie.match(/PHPSESSID=[A-Za-z0-9]+\;/i);

    if (phpSessionId == null)
        return '';

    if (typeof (phpSessionId) == 'undefined')
        return '';

    if (phpSessionId.length <= 0)
        return '';

    phpSessionId = phpSessionId[0];

    var end = phpSessionId.lastIndexOf(';');
    if (end == -1) end = phpSessionId.length;

    return phpSessionId.substring(10, end);
}

function sendSelf(functionName) {
    $.ajax({
        url: "",
        method: "GET",
        data: {
            FunctionName: functionName,
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
            callTiny();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
//getPassChangePanel
function getManagerOptions() {
    $.ajax({
        url: "./controlers/printers/settingsPrinter.php",
        method: "POST",
        data: {
            FunctionName: "getManagerOptions"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}



function getRankReqById(id) {
    $.ajax({
        url: "./controlers/printers/reqController.php",
        method: "POST",
        data: {
            functionName: "getRankReqById",
            userId: id
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getRankReqPanelOfUserId() {
    $.ajax({
        url: "./controlers/printers/reqController.php",
        method: "POST",
        data: {
            functionName: "getRankReqPanelOfUserId"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function getArticleAprovePanelOfUserId() {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "getArticleAprovePanelOfUserId"
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("settingContent").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}

function aproveArticle(id) {
    $.ajax({
        url: "./controlers/printers/articlePrinter.php",
        method: "POST",
        data: {
            functionName: "aproveArticle",
            articleId: id
        },
        dataType: "html",
        success: function ($data) {
            alert("המאמר אושר בהצלחה!");
            location.reload();
        },
        error: function ($data) {
            console.log($data);
        }
    });
}
