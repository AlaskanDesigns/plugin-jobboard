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

    $("#new_applicant_dialog").dialog({modal: true, minWidth: 400,minHeight: 300, resizable: false,autoOpen: false});
    $("#add-applicant").click(function() {$("#new_applicant_dialog").dialog("open");});
    $("#cancel-dialog").click(function() {$("#new_applicant_dialog").dialog("close");});

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


    //********************************//
    //***** ADD && REMOVE TAGS ******//
    //********************************//

    //add tag to div
    $("#tags").on("change", function() {
        $("#search_tags").show();
        var tag_id   = $.trim($(this).val());
        var tag_name = $('#tags [value="' + tag_id + '"]').text();

        var open_div  = '<div class="tag-info" data-tag-id="' + tag_id + '">';
        var span1     = '<span>' + tag_name + '</span>';
        var span2     = '<span class="del-tag">x</span>'
        var close_div = '</div>';

        if(tag_id != '-1') {
            $("#search_tags").append(open_div + span1 + span2 + close_div);
            $('#tags option[value="' + tag_id + '"]').remove();
        }
    });

    //remove tag from div
    $(document.body).on('click', '.del-tag', function() {
       //get id && value
       var tag_id   = $(this).parent().data("tag-id");
       var tag_name = $(this).parent().children('span').first().text();

       //remove element
       $(this).parent().remove();

       //add to selector again
       $("#tags").append('<option value="' + tag_id + '" >' + tag_name + '</option>');

        //order selector alphabetically
        var default_option = $('#tags option').first();
        default_option.remove();

        var listitems = $('#tags').children('option').get();
        //console.log(listitems);
        listitems.sort(function(a, b) {
            var compA = $(a).text().toUpperCase();
            var compB = $(b).text().toUpperCase();

            return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
        })
        $.each(listitems, function(idx, itm) {$('#tags').append(itm);});
        $('#tags').prepend(default_option);
    });

    //********************************//
    //**** EN ADD && REMOVE TAGS *****//
    //********************************//


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

    $("#shortcut-filters").submit(function(event) {
       var tags = '';
       $("#search_tags").children().each(function(b, element) {
           tags = tags + $(this).children('span').first().text() + ',';
       });
       tags = tags.slice(0,tags.length-1);
       $("#current_tags").val(tags);
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
                yOffset: "-16px"
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
