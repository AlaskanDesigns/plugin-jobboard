$(document).ready(function(){
    $($('select#parentCategory').find('option')[2]).prop("selected",true);
    setTimeout(function() {
	$("select#parentCategory").trigger('change');
	$('select#parentCategory').find('option:first').prop("selected",true);
	$("select#parentCategory").trigger('change');
    }, 1) ;
    $("form[name=item]").validate({
        rules: {
            country: {
                required: true
            },
            region: {
                required: true
            },
            city: {
                required: true
            }
        },
        messages: {
            country : {
                required: jobboard.langs.country_required
            },
            region : {
                required: jobboard.langs.region_required
            },
            city : {
                required: jobboard.langs.city_required
            }
        },
        errorLabelContainer: "#flashmessage",
        wrapper: "label",
        invalidHandler: function(form, validator) {
            $("#flashmessage").empty();
            $("#flashmessage").addClass("flashmessage-error");
            $("#flashmessage").append('<a class="btn ico btn-mini ico-close">x</a>');
            $('html,body').animate({scrollTop: $('h1').offset().top}, {duration: 250, easing: 'swing'});
        }
    });
});