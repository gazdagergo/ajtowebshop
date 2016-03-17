$(document).ready(function(){
    $fel = $('#form-options').find('.valaszto_form').eq(2);
    $('#form-options').find('.valaszto_form').eq(1).before($fel);
    $fel = $('#form-options').find('.valaszto_form').eq(3);
    $('#form-options').find('.valaszto_form').eq(2).before($fel);
});