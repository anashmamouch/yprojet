if (window.addEventListener) {
    window.addEventListener('load', maFonctionDeTest, false);
} else {
    window.attachEvent('onload', maFonctionDeTest);
}

function maFonctionDeTest() {
    //on affiche "vive tutoriels en folie"
    //alert("vive tutoriels en folie !");

    var i = -1,
            toastCount = 0,
            $toastlast,
            getMessage = function () {
                var msgs = ['Hello, some notification sample goes here',
                    '<div><input class="form-control input-small" value="textbox"/>&nbsp;<a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank">Check this out</a></div><div><button type="button" id="okBtn" class="btn blue">Close me</button><button type="button" id="surpriseBtn" class="btn default" style="margin: 0 8px 0 8px">Surprise me</button></div>',
                    'Did you like this one ? :)',
                    'Totally Awesome!!!',
                    'Yeah, this is the Metronic!',
                    'Explore the power of Metronic. Purchase it now!'
                ];
                i++;
                if (i === msgs.length) {
                    i = 0;
                }

                return msgs[i];
            };


    var shortCutFunction = $('#type_notification').val();
    var msg = $('#msg_notification').val();
    var title = $('#title_notification').val();

    var toastIndex = toastCount++;

    toastr.options = {
        closeButton: true,
        debug: false,
        positionClass: $('#position_notification').val(),
        onclick: null
    };

    $("#toastrOptions").text("Command: toastr[" + shortCutFunction + "](\"" + msg + (title ? "\", \"" + title : '') + "\")\n\ntoastr.options = " + JSON.stringify(toastr.options, null, 2));

    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if ($toast.find('#okBtn').length) {
        $toast.delegate('#okBtn', 'click', function () {
            alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
            $toast.remove();
        });
    }
    if ($toast.find('#surpriseBtn').length) {
        $toast.delegate('#surpriseBtn', 'click', function () {
            alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
        });
    }

    $('#clearlasttoast').click(function () {
        toastr.clear($toastlast);
    });
}
;