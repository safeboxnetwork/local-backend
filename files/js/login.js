jQuery(document).ready(function () {
    jQuery("img.submit").click(function () {
        if (jQuery('#l').val() == '') myalert(wrong_name);
        else if (jQuery('#p').val() == '') myalert(wrong_passwd);
        else {
            jQuery('#v2').val((jQuery(this).attr('name')));
            document.forms[0].submit()
        }
    });
});

function setLoginSize() {
    var h = jQuery('#loginWindow').height();
    h = Math.floor((jQuery(window).height() - h) / 2);
    if ( h < 1 ) { h = 0; }
    var w = jQuery('#loginWindow').width();
    w = Math.floor((jQuery(window).width() - w) / 2);
    if ( w < 1 ) { w = 0; }
    jQuery('#loginWindow').css('top', h + 'px');
    //jQuery('#loginWindow').css('left', w + 'px');
}

function showContent(id) {
    jQuery('#content').html('');
    jQuery('#contentWindow').modal('hide');
    var c = 'lang/' + lang + '/' + id + '.html';
    jQuery.get(c, function (a) {
        jQuery('#content').html(a)
    });
    jQuery('#contentWindow').modal('show');
}

function myalert(a) {
    jQuery('#alert_msg').html(a);
    jQuery('#alertWindow').modal('show');
}
