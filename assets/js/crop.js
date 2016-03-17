
var scaleFactor = 1;
var cropLeft;
var cropTop;


$(document).ready(function(){
    getCropData();
});


$(function() {
      $( ".draggable" ).draggable({
            stop: function( event, ui ) {
                getCropData();
            }
        });
});


$('#minus').click(function(){
    scaleFactor = scaleFactor - 0.1;    
    $('#image_to_crop').css('transform', 'scale('+scaleFactor+')'); 
    getCropData();
});

$('#plus').click(function(){
    scaleFactor = scaleFactor + 0.1;    
    $('#image_to_crop').css('transform', 'scale('+scaleFactor+')'); 
    getCropData();    
});


function getCropData() {
    cropLeft = $('#croparea').css('left');
    cropTop = $('#croparea').css('top');
    
    
    $('input[name="cropLeft"]').val(cropLeft);
    $('input[name="cropTop"]').val(cropTop);
    $('input[name="scaleFactor"]').val(scaleFactor);
    
    console.log(cropLeft + ', ' + cropTop + ', ' + scaleFactor);
    
}