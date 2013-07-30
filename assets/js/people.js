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

    $("#new_applicant_dialog").dialog({ modal: true, minWidth: 400,minHeight: 300, resizable: false,autoOpen: false,hide: { effect: "clip",duration: 500 }});
    $("#add-applicant").click(function() { $("#new_applicant_dialog").dialog("open");  });
    $("#cancel-dialog").click(function() { $("#new_applicant_dialog").dialog("close"); });

    $("#add_new_applicant_form").validate({
	debug: true,
	rules: {
	    'applicant-name': {
		required: true,
		minlength: 2
	    },
	    'applicant-email': {
		required: true,
		email: true
	    },
	    'applicant-phone': {
		required: true,
		minlength: 5
	    },
	    'applicant-birthday': {
		required: true
	    },
	    'applicant-sex': {
		required: true
	    }
	},
	messages: {
	    'applicant-name': {
		required: jobboard.langs.applicant_name_required,
		minlength: jobboard.langs.applicant_name_short
	    },
	    'applicant-phone': {
		required: jobboard.langs.applicant_phone_required,
		minlength: jobboard.langs.applicant_phone_short
	    },
	    'applicant-email': {
		required: jobboard.langs.applicant_email_required,
		email: jobboard.langs.applicant_email_wrong
	    },
	    'applicant-birthday': {
		required: jobboard.langs.birthday_required
	    },
	    'applicant-sex': {
		required: jobboard.langs.applicant_sex_required
	    }
	},
	errorLabelContainer: "#error_list",
	wrapper: "li",
	invalidHandler: function(form, validator) {
	    $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
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

    //$("#applicant-attachment").on("change", function(){
	jQuery.validator.addMethod("file_required", function(value, element) {
	    if($("#applicant-attachment")[0].files[0]) {
	    return true;
	    } else {
		return false;
	    }
	});
    //});

    $("#applicant-attachment").rules(
	"add", {
	    'file_required': true,
	    messages: {
		file_required: jobboard.langs.applicant_file_required
	    }
	}
    );
});

function delete_applicant(id) {
    $("#delete_id").attr("value", id);
    $("#dialog-people-delete").dialog('open');
}