/**** product gallery ****/
$(document).ready(function(){
    
var PICTURE_UPLOAD_DIR = 'uploads/files/';

$('.product-gallery img').click(function(){
    $('#loadingImg').show();
    $('#productImage').css('opacity', '.8');

   imgSrc = $(this).attr('data-src');

    $('<img src="/' + PICTURE_UPLOAD_DIR + imgSrc + '">').load(function(){
        $('#productImage').attr('src', '/' + PICTURE_UPLOAD_DIR + imgSrc);
        $('#loadingImg').hide();
        $('#productImage').css('opacity', '1');
        

    });
    
});

    
});
