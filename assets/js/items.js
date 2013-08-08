$(document).ready(function(){
    $("body.items #content-head > h1 > a:last").addClass("btn-blue add-new-item").removeClass("btn-green ico ico-32 ico-add-white");
   /* HIDE OPTIONS: 'marcar como destacado & marcar como spam */
   $("#item-action-list li:gt(1)").hide();
});