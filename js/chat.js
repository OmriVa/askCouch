var chatLoaded = "false";
$(document).ready(function () {
    var chatWith = getParam("freindId");
    getChatFrame(chatWith);
    getFriendList();

    $(document).on('keypress', '#chatText', function (e) {
        if (e.which == 13) // the enter key code
        {
            $('#sendMsg').click();
        }
    });
    $(document).on('click', '#sendMsg', function (e) {
        e.preventDefault();
        sendMsg();
        //CLEAR TEXTAREA
        $('#chatText').val('');
    });
});

function scrollDownChat() {
    //scrolldonw the chat box when load.
    $("#chatBox").animate({
        scrollTop: $('#chatBox').prop("scrollHeight")
    }, 1000);
}

function getChatFrame(freindId) {
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: "getChatFrame",
            friendId: freindId
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("chatMain").innerHTML = $data;
            getChatHeader(freindId);
            //setInterval(loadChat(freindId), 10000);
            //loadChat(freindId);
            runForEven(freindId);
            chatLoaded = "true";
            responsiveChat();
        },
        error: function ($data) {
            //console.log($data);
            responsiveChat();
        }
    });

}

function runForEven(freindId) {
    window.setInterval(loadChat(freindId), 3000);
}

function sendMsg() {
    var fucntionName = "sendMsg";
    var friendId = getParam("freindId");
    var text = $('textarea#chatText').val();
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: fucntionName,
            friendId: friendId,
            text: text
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("chatBox").innerHTML = $data;
            scrollDownChat();
        },
        error: function ($data) {
            console.log($data);
        }
    })
};

function loadChat(friendId) {
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: "getChat",
            friendId: friendId
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("chatBox").innerHTML = $data;
            scrollDownChat();
        },
        error: function ($data) {
            console.log($data);
        }
    })
};


function getChatHeader(friendId) {
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: "getChatHeader",
            friendId: friendId
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("chatHeader").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    })
};

function getFriendList() {
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: "getFriendList"
        },
        dataType: "json",
        success: function ($data) {
            document.getElementById("freindList").innerHTML = $data;
        },
        error: function ($data) {
            console.log($data);
        }
    });
}


function openChatList() {
    document.getElementById("mySidebar").style.display = "block";
    //document.getElementById("openChatList").style.display = "none";
    if (window.innerWidth < 768) {
        document.getElementById("chatMain").style.display = "none";
    }
}

function closeChatList() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("openChatList").style.display = "block";
    document.getElementById("chatMain").style.display = "block";
}


function responsiveChat() {
    if (window.innerWidth < 768) {
        if (chatLoaded == "false") {
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("chatMain").style.display = "none";
        } else {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("chatMain").style.display = "block";
        }
    } else {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("chatMain").style.display = "block";
    }
    if (chatLoaded == "false") {
        document.getElementById("closeChatList").style.display = "none";
    }
}
window.addEventListener("resize", function () {
    responsiveChat();
});


function searchFriendFunc() {
    var word = document.getElementById("searchFriend").value;
    //console.log(word);
    $.ajax({
        url: "./controlers/printers/msgPrinter.php",
        method: "POST",
        data: {
            functionName: "getFillterdFriendList",
            filterWord: word
        },
        dataType: "html",
        success: function ($data) {
            document.getElementById("freindList").innerHTML = $data;
        }
    });
}
