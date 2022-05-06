$(document).on('click', '#search', function (e) {
    e.preventDefault();
    window.location.href = "search.php?word=" + $('#searchInput').val();
    console.log();
});

function getParam(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return results[1];
}

function setGetParameter(paramName, paramValue) {
    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0) {
        var prefix = url.substring(0, url.indexOf(paramName + "="));
        var suffix = url.substring(url.indexOf(paramName + "="));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    } else {
        if (url.indexOf("?") < 0)
            url += "?" + paramName + "=" + paramValue;
        else
            url += "&" + paramName + "=" + paramValue;
    }
    window.location.href = url + hash;
}

function callTiny() {
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink link image lists charmap print preview Full Page',
        menubar: false,
        toolbar: 'redo undo | bold underline | alignleft aligncenter alignright | bullist numlist | outdent indent | link image',
        directionality: 'rtl',
        language: 'he_IL',
        image_class_list: [
            {
                title: 'ראשי',
                value: 'img-fluid'
            },
        ],
        setup: function (editor) {
            //editor.on('init keydown change', function (e) {
            //console.log();
            //});
        }

        //statusbar: false
    });
    if (tinymce.initialized == false) {
        callTiny();
    }
}

function callBasicTiny() {
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink link image lists charmap print preview Full Page',
        menubar: false,
        toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent',
        directionality: 'rtl',
        language: 'he_IL',
    });
    if (tinymce.initialized == false) {
        callBasicTiny();
    }
}

function ifLogIn() {

}
