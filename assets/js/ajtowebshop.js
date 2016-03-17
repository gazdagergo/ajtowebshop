/*$('.szuresek select').click(function() {
    $(this).find('option').each(function(){
        text = $(this).text();
        text = text.replace('Rendezés: (', '');
        text = text.replace(')', '');
        $(this).text(text);
    });
                                
});


$('.szuresek select').change(function() {
    text = $(this).find(':selected').text();
    $(this).find(':selected').text('Rendezés: (' + text + ')');
});*/


$('document').ready(function(){
    checkSliderNyil();
});


var lapozas = 0;


$('.slide-nyil').click(function(){
    
    if ($(this).hasClass('disabled')) return false;
    
    slides = $('#slider-img-wrap img').length;
    irany = $(this).attr('id') == 'slide-next' ? -1 : 1;
    lapozas -= 1 * irany;
    margin = -lapozas * 994;
    
    checkSliderNyil();

    $('#slider-img-wrap img').eq(0).css('margin-left', margin + 'px');
    
});

function checkSliderNyil() {
    slides = $('#slider-img-wrap img').length;
    
    if (lapozas < 1) {
        $('#slide-prev').addClass('disabled');   
    } else {
        $('#slide-prev').removeClass('disabled');   
    }
    
    if (lapozas == slides-1) {
        $('#slide-next').addClass('disabled');   
    } else {
        $('#slide-next').removeClass('disabled');   
    }
}