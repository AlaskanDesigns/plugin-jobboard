$(document).ready(function() {
   $("#delete-jobboard-step-2").hide();
   $("#delete-jobboard-step-3").hide();

   $("#delete-button-step-1").on("click", function() {
       $("#delete-jobboard-step-1").hide();
       $("#delete-jobboard-step-2").show();
   });
   $("#delete-button-step-2").on("click", function() {
       $("#delete-jobboard-step-2").hide();
       $("#delete-jobboard-step-3").show();
   });

   $(".cancel-delete-jobboard").on("click", function() {
       window.location.href = $("#dashboard-page").val();
   });
});
