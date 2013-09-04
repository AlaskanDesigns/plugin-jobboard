$(document).ready(function() {
    $('.list-star').rating({showCancel: false, readOnly: true});
    $('.filter-star').rating({showCancel: true, cancelValue: null});

    $("#dialog-people-delete").dialog({
        autoOpen: false,
        modal: true
    });

    // tooltips notes
    $.each($('.note'), function(index, value) {
        $(value).osc_tooltip($(value).attr('data-tooltip'), {layout: 'gray-tooltip', position: {x: 'right', y: 'middle'}});
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

    $("#new_applicant_dialog").dialog({ modal: true, minWidth: 400,minHeight: 300, resizable: false,autoOpen: false });
    $("#add-applicant").click(function() { $("#new_applicant_dialog").dialog("open");  });
    $("#cancel-dialog").click(function() { $("#new_applicant_dialog").dialog("close"); });

    $("#add_new_applicant_form").validate({
        onkeyup: false,
        rules: {
            'applicant-name': {
                required: true
            },
            'applicant-email': {
                required: true,
                email: true
            },
            'applicant-phone': {
                required: true
            },
            'applicant-birthday': {
                required: true
            },
            'applicant-sex': {
                required: true
            }
        },
        errorPlacement: function(error,element) {
            $(element).parent().addClass('js-error');
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('js-error');
        },
        submitHandler: function(form){
            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    jQuery.validator.addMethod("regex_bday", function(value, element) {
        if(/^\d{2}[/]\d{2}[/]\d{4}$/.test(value)) {
            return true;
        } else {
            return false;
        }
    });

    $('#applicant-birthday').rules(
        "add", {
            'regex_bday': true,
            messages: {
                regex_bday: jobboard.langs.invalid_birthday_date
            }
        }
    );

    /*jQuery.validator.addMethod("file_required", function(value, element) {
        if($("#applicant-attachment")[0].files[0]) {
            return true;
        } else {
            return false;
        }
    });

    $("#applicant-attachment").rules(
        "add", {
            'file_required': true,
            messages: {
                file_required: jobboard.langs.applicant_file_required
            }
        }
    );*/

    $("#dialog-applicant-email").dialog({
        autoOpen: false,
        modal: true,
        minWidth: 736,
        resizable: false
    });

    $("#applicant-status-cancel").click(function() {
        $('#dialog-applicant-email').dialog('close');
        $(".option-send-email").hide();
    });

    $("#applicant-status-submit").click(function() {
        $.post(jobboard.ajax.applicant_status_notification,
            {
                "applicantID" : $("#applicant_email_id").val(),
                "message" : tinyMCE.activeEditor.getContent(),
                "subject" : $("#applicant-status-notification-subject").val()
            },
            function(data){},
            'json'
        );
        $.post(jobboard.ajax.applicant_save_notification,
            {
                "applicantID" : $("#applicant_email_id").val(),
                "message" : tinyMCE.activeEditor.getContent(),
                "subject" : $("#applicant-status-notification-subject").val()
            },
            function(data){
                $('#dialog-applicant-email').dialog('close');
                $('.option-send-email').hide();
            },
            'json'
        );
    });
});

var applicant = {
    tour: {
        id: "applicant",
        steps: [
            {
                target: 'add-applicant',
                title: jobboard.langs.hopscotch.feature.add_applicant.title,
                content: jobboard.langs.hopscotch.feature.add_applicant.content,
                placement: "left",
                yOffset: "-16px",
            }
        ],
        scrollTopMargin: 100,
        showCloseButton: false,
        i18n: {
            nextBtn: jobboard.langs.hopscotch.i18n.nextBtn,
            prevBtn: jobboard.langs.hopscotch.i18n.prevBtn,
            doneBtn: jobboard.langs.hopscotch.i18n.doneBtn,
            skipBtn: jobboard.langs.hopscotch.i18n.skipBtn,
            closeTooltip: jobboard.langs.hopscotch.i18n.closeTooltip,
            stepNums: [jobboard.langs.hopscotch.feature.add_applicant.bubble]
        }
    }
}

function delete_applicant(id) {
    $("#delete_id").attr("value", id);
    $("#dialog-people-delete").dialog('open');
}

function send_email(id) {
    $("#applicant_email_id").attr("value", id);
    $("#applicant-status-notification-subject").val('');
    $("#applicant-status-notification-message").val('');
    tinyMCE.activeEditor.setContent('');
    $("#dialog-applicant-email").dialog('open');
}
