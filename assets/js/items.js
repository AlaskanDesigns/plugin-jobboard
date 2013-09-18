$(document).ready(function(){

    //fixed bug error link order items by date
    var url_date   = $('.col-date a').first().attr('href');
    if( url_date !== undefined ) {
        var href_value = url_date.replace("index.php&","index.php?page=items&");
        $('.col-date a').first().attr('href', href_value);
    }

    $("body.items #content-head > h1 > a:last").addClass("btn-blue add-new-item").removeClass("btn-green ico ico-32 ico-add-white");
    /* HIDE OPTIONS: 'marcar como destacado & marcar como spam */
    $("#item-action-list li:gt(1)").hide();
});