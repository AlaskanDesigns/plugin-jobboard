$(document).ready(function() {

    $("#statuses").on("change", function() {
        window.location.href = $(this).val();
    });

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

    $("#dialog-new_status").dialog({
	autoOpen: false,
	modal: true,
        resizable: false,
        width: 600
    });

    /* SORT TABLE ROWS */
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
    $("#dialog-new_status table tbody").sortable({
        helper: fixHelper,
        start: function(event, ui){
            $(ui.item).animate({
                'background-color': '#F1F1F1'
            }, 'fast');
        },
        stop: function(event, ui){
            $(ui.item).animate({
                'background-color': '#ffffff'
            }, 'fast');
        }
    }).disableSelection();

    /* OPEN STATUS MANAGEMENT DIALOG */
    $("#status_manage").on("click", function() {
        $("#dialog-new_status").dialog("open");
    });

    /* CLOSE STATUS MANAGEMENT DIALOG */
    $("#add-new-status-cancel, #dialog-new_status .ui-icon.ui-icon-closethick").on("click", function()
    {
        /* order statuses and saved it into DB */
        var aStatuses = new Array();
        $("#dialog-new_status .table tbody tr td:first-child").each(function() {
            var aStatus = new Array();
            aStatus.push($(this).children().attr("id"));
            aStatus.push($.trim($(this).text()));
            aStatuses.push(aStatus);
        });
        $.post(jobboard.ajax.update_statuses, {'statuses' : aStatuses});

        $("#dialog-new_status").dialog("close");
        location.reload();
    });

    /* ADD NEW STATUS */
    $("#add-new-status-submit").on("click", function()
    {
        $("#error_list").empty().hide();
        $.post( jobboard.ajax.new_status_applicant, {'statusName' : $("#new_status_input").val()}
        ).done(function(data){
                if(data.match(/already exists/)) {
                   $("#error_list").append("<li>" + data + "</li>").show();
                } else {
                    var obj = jQuery.parseJSON(data);
                    $("#dialog-new_status table").append('<tr><td><label id=' + obj.id +
                      '>' + obj.name + '</label></td><td><a class="delete_status" data-status-id="'
                       + obj.id + '"><div class="icon-delete-status"></div></a></td></tr>');
                }
         });
    });

    /* DELETE STATUS*/
    $("#dialog-new_status .table").on("click", "a.delete_status", function(event)
    {
        var statusId = $(this).data("status-id");
        /* assign old status value to input hidden that will be needed when reallocate applicants */
        $("#reallocating-applicants #old-status-delete").attr("value", statusId);
        $.post(jobboard.ajax.get_current_applicants_by_status, { 'statusID' : statusId })
        .done(function(num_applicants){

            if(num_applicants > 0)
            {
                /* reset values for current status */
                $("#status-appl-num-info").empty();
                $("#selector-new-statuses").empty();

                $("#status-appl-num-info").append(num_applicants);
                $(".adding-new-status").hide();

                /* get current statuses to reasign */
                $.post( jobboard.ajax.get_current_statuses, {}).done(function(data)
                {
                    /* assing new values to selector */
                    var statuses = jQuery.parseJSON(data);
                    $("#selector-new-statuses").append("<option value='-1' selected='selected'>" + $("#unread-option").val()  + "</option>");
                    for(var status in statuses) {
                        if(statusId != statuses[status].id) {
                            $("#selector-new-statuses").append("<option value='" + statuses[status].id + "'>" + statuses[status].name + "</option>");
                        }
                    }
                    $("#reallocating-applicants").show();
                });
            } else {
                $.post( jobboard.ajax.delete_status_applicant,{ 'current_status' : $("#reallocating-applicants #old-status-delete").val() }).done(function(data)
                {
                    $("#" + $("#reallocating-applicants #old-status-delete").val() ).closest('tr').remove();
                });
                $("#reallocating-applicants").hide();
                $(".adding-new-status").show();
            }
        });
    });

    $("#button-reallocate-close").on("click", function() {
        $("#reallocating-applicants").hide();
        $(".adding-new-status").show();
    });


    $("#button-reallocate").on("click", function() {
        $.post( jobboard.ajax.delete_status_applicant,{
        'current_status' : $("#reallocating-applicants #old-status-delete").val(),
        'new_status': $("#reallocating-applicants #selector-new-statuses").val()
        }).done(function(data) {
            $("#" + $("#reallocating-applicants #old-status-delete").val() ).closest('tr').remove();
            $("#reallocating-applicants").hide();
        });

        $("#reallocating-applicants").hide();
        $(".adding-new-status").show();

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