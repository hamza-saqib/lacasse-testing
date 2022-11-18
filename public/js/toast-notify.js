var toast = function (msg, classname) {
    var d = new Date();
    var t = d.getTime();
    var messg;
    if (jQuery(".toasts-container").length == 0) {
        jQuery("body").prepend("<div class='toasts-container'></div>");
    }
    if (classname == "success") {
        messg = "<div class='disp_msg flash-" + classname + "' id='msg-" + t + "'><span><i class='fa fa-check-circle' style='margin: 0 10px 0px 0px !important;vertical-align: middle !important;'></i><span style='display: inline-block; vertical-align: top; line-height:28px;'>" + msg + "</span></span></div>";
    } else if (classname == "error") {
        messg = "<div class='disp_msg flash-" + classname + "' id='msg-" + t + "'><span><i class='fa fa-exclamation-circle' style='margin: 5px 10px 0px 0px !important; vertical-align: middle !important;'></i><span class='toast-msg'>" + msg + "</span></span></div>";
    }
    /* $("#msg-"+t).hide(); */
    jQuery(".toasts-container").prepend(messg);
    jQuery("#msg-" + t).fadeIn(1000);
    setTimeout(function () {
        jQuery("#msg-" + t).slideUp(500, function () {
            jQuery("#msg-" + t).remove();
        });
    }, 5000);
};