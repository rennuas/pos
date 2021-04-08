$(document).ready(function(){
    $(".money").mask('000.000.000', {
        reverse: true
    });

    $('[data-toggle="datepicker"]').datepicker();
});