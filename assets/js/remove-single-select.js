$(document).ready(function(){

    $('.termekopciok').each(function(){
        len = $(this).find('select').find('option').length; 

        if (len == 2) $(this).hide();
    });

});