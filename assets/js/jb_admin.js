$(document).ready(function(){
    $('p.help-inline:first').text(jobboard.langs.admins_help_inline);


    var admins = JSON.parse(jobboard.admin_users);
    $('#check_all').parent().after('<th>' + admins['admin_option'] + '</th>');
    $('.col-bulkactions [name="id[]"]').each(function(element, object) {
        $(this).parent().after('<td class="user-type">' + admins[$(this).val()] + '</td>');
    });

});