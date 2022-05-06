<?php include('./controlers/db.php'); include('./controlers/frame.php'); session_start(); redirectByRankMin($_SESSION['rank'], 1)?>

<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>AskCouch - צאטים</title>
    <title>Messeges הודעות</title>
    <?php headerScriptLoader(); ?>
    <script src="./js/chat.js"></script>
</head>

<body style="font-family:'Ariel'">
    <?php printHeader(basename($_SERVER['PHP_SELF'])); ?>
    <div class="bg-color px-2 py-4 row m-0 px-md-5">
        <div class="bg-white col-12 p-2 text-right border d-block">
            <div class="row m-0">
                <div id="mySidebar" class="text-right border col-12 col-md-5 mx-0">
                    <form>
                        <div class="d-flex p-1 flex-row justify-content-between">
                            <h3>שיחות אחרונות:</h3>
                            <a href="javascript:void(0)" id="closeChatList" onclick="closeChatList()"><i class="fas fa-times fa-2x"></i></a>
                        </div>
                        <div class="w-100 border m-1 p-1 mb-2" id="freindList" style="height:390px;overflow:scroll;overflow-x:hidden;">
                        </div>
                        <div class="input-group-prepend mb-2 w-100">
                            <input class="form-control w-100 mr-sm-2" id="searchFriend" type="search" placeholder="חיפוש" aria-label="Search" oninput="searchFriendFunc()">
                            <button class="btn btn-light  border" style="height:38px;"> <i class="fas fa-search text-info icon-user active-color"></i> </button>
                        </div>
                    </form>
                </div>
                <div id="chatMain" class="col">
                    <a id="openChatList" href="javascript:void(0)" onclick="openChatList()"></a>
                </div>
            </div>
        </div>

    </div>
    <?php printFooter(); ?>
</body>

</html>
