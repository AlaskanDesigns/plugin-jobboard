$(document).ready(function() {
    $('.list-star').rating({showCancel: false, readOnly: true});
    $('.filter-star').rating({showCancel: true, cancelValue: null});

    $("#dialog-people-delete").dialog({
	autoOpen: false,
	modal: true
    });

    $("#dialog-send-mail").dialog({
	autoOpen: false,
	modal: true,
        resizable: false,
        height: 450,
        width: 620
    });

    $('#show-filters').click( function(){
	$('.search-filter').toggle();
	if( $('.search-filter:visible').size() > 0 ) {
	    $('#show-filters').text( jobboard.langs.text_hide_filter );
	} else {
	    $('#show-filters').text( jobboard.langs.text_show_filter );
	}
    });
    // tooltips notes
    $.each($('.note'), function(index, value) {
	$(value).osc_tooltip($(value).attr('data-tooltip'), {layout: 'gray-tooltip', position: {x: 'right', y: 'middle'}});
    });

    $("#contact-cancel").click(function(){
        $("#dialog-send-mail").dialog('close');
    });

    $("#contact-submit").click(function() {
        console.log(tinyMCE.activeEditor.getContent());
        console.log($("#subject").val());
    });
});

function delete_applicant(id) {
    $("#delete_id").attr("value", id);
    $("#dialog-people-delete").dialog('open');
}
function send_email(id) {
    $("#delete_id").attr("value", id);
    $("#dialog-send-mail").dialog({width:600}).dialog("open");
}