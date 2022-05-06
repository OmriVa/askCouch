$(document).ready(function (e) {
    callBasicTiny();
    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        //console.log("click");
        var content = tinyMCE.activeEditor.getContent();
        var title = $('input[name=title]').val();
        var sendinfo = {
            functionName: "createPost",
            content: content,
            title: title
        };
        if (content.replace(/\s/g, '').length && title.replace(/\s/g, '').length) {
            $.ajax({
                url: "./controlers/printers/postPrinter.php",
                method: "POST",
                data: sendinfo,
                dataType: "json",
                success: function ($data) {
                    window.location = 'getpost.php?Id=' + $data;
                },
                error: function ($data) {
                    console.log($data);
                }
            });
        } else {
            var error = [];
            if (!content) {
                error.push("* חובה למלא את גוף השאלה");
            }
            if (!title) {
                error.push("* חובה למלא כותרת לשאלה");
            }
            for (var i = 0; i < error.length; ++i) {
                if (i == 0) {
                    document.getElementById("errors").innerHTML = error[i] + '<br>';
                } else {
                    document.getElementById("errors").innerHTML += error[i] + '<br>';
                }
            }

        }
    });
});
