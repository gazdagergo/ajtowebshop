
var PICTURE_UPLOAD_DIR = 'uploads/files/';

$('#searchField').focusout(function(){
    $(this).val('');
});

$('#menu > ul > li').hover(function(){
    if (!$(this).hasClass('active')) {
        $('.active .sub').hide();
    }
}, function(){
    $('.active .sub').show();   
});


/**** product gallery ****/


$('#product_gallery img').click(function(){
    $('#loadingImg').show();

    imgSrc = $(this).attr('data-src');
    
    $('<img src="/' + PICTURE_UPLOAD_DIR + imgSrc + '">').load(function(){
        $('#prodImage').html('<img src="/' + PICTURE_UPLOAD_DIR + imgSrc + '" alt="Image of product" />');
        $('#loadingImg').hide();

    });
    
});


/**** képszerkesztés ****/

$('.kepszerkesztes').click(function(){
    $('.product').removeClass('szerkesztesre_var');
    $(this).closest('.product').addClass('szerkesztesre_var');
});


$('#kepform input').change(function(){
    kepformazas();
});


$(document).ready(function(){
    kepformazas();   
    downloadMoreItem();
});


function kepformazas() {
    if ($('#kepform').length == 0) {return false;}
    inputs = $('#kepform').children('input[type="number"]');

    transformValue = '';
    transformArray = {};
    
        for (i=0;i<inputs.length;i++) {

            transform = $(inputs[i]).attr('name');
            ertek = $(inputs[i]).val();
            dimension = $(inputs[i]).attr('data-dim');

            transformArray[i] = ertek;        

            if (i > 0) {transformValue += ' '};

            if (transform == 'translateY') {ertek = ertek * (-1)};

            transformValue += transform + '(' + ertek + dimension + ')';


        }
    
    w = $('#edited_img').width();
    h = $('#edited_img').height();
    
    
    $('#edited_img').css('transform', transformValue); 
    navigation(transformArray, w, h);

}


function navigation(transformArray, orig_width, orig_height) {
    
        //console.log(transformArray);
    
        var thumb_width = 356;
        var thumb_height = 324
    
        translateX = transformArray[0];
        translateY = transformArray[1];
        scale = transformArray[2];
        rotate = transformArray[3];
    
    
    thb_pos = $('#edit_wrap').position();
    img_pos = $('#edited_img').position();

    
    var thumb = {
        left    :   thb_pos.left,
        top     :   thb_pos.top,
        width   :   $('#edit_wrap').width(),
        height  :   $('#edit_wrap').height(),
        right   :   thb_pos.left + $('#edit_wrap').width(),
        bottom  :   thb_pos.top + $('#edit_wrap').height()
    };
    
    var image = {
        left    :   img_pos.left,
        top     :   img_pos.top,
        width   :   document.getElementById('edited_img').getBoundingClientRect().width,
        height  :   document.getElementById('edited_img').getBoundingClientRect().height,
        right   :   img_pos.left + document.getElementById('edited_img').getBoundingClientRect().width,
        bottom  :   img_pos.top + document.getElementById('edited_img').getBoundingClientRect().height
        
    };
    
    
    x1 = Math.round((thumb.left - image.left) / scale * 100) / 100;
    y1 = Math.round((thumb.top - image.top) / scale * 100) / 100;
    width = Math.round(thumb.width/scale * 100) / 100;
    height = Math.round(thumb.height/scale * 100) / 100;


    x2 = x1 + width;
    y2 = y1 + height;

    
/*        $('#thumbdiv').css({
            'left' : x1+'px', 
            'top' : y1+'px', 
            'width' : width + 'px', 
            'height': height + 'px'
        }); 
    */
    
    $('#kepform input[name="x1"]').val(x1);
    $('#kepform input[name="y1"]').val(y1);
    $('#kepform input[name="x2"]').val(x2);
    $('#kepform input[name="y2"]').val(y2);
    $('#kepform input[name="rotate"]').val(rotate);
    
}



/**** scroll ****/

$( "form" ).submit(function( event ) {
    var scroll = $(window).scrollTop();
    $(this).append('<input type="hidden" name="scroll" value="' + scroll + '" />');

//    event.preventDefault();
});


/*** kosár ***/

$('.menny_valt').click(function(){
    val = parseInt($('#menny_kosarba').val());
    max = $(this).closest('form').find('input[name="stock"]').val();
    
    
        if ($(this).val() == '+') {
            val = val + 1;
        } else {
            val = val - 1;
        }
    
    if (! $.isNumeric(val)) {val = 1;}
    if (val < 1) {val = 1;}
    if (val > max) {val = max;}
    
    $('#menny_kosarba').val(val);
});



/*** termekoldal ****/

$('.valaszto_form').change(function(){
    
    option_nr = parseInt($(this).find('input[name="option_nr"]').val());
    current_url = $(this).find('input[name="current_uri"]').val();
    uri_parts = current_url .split("/"); 
    action_url = $(this).find('input[name="uri"]').val();
    action_url += $(this).find('select[name="product_option"]').find(":selected").val();
    
    uri_end = '';
    
        for (i = option_nr + 2; i < uri_parts.length; i++) {
            uri_end +=  '/' + uri_parts[i];   
        }

    
    action_url += uri_end;
    $(this).attr('action', action_url);
    $(this).submit();
});


/**** lazy load ****/
var stopScrollCheck = false;

$(window).scroll(function () {

    checkIfScrolledDown();
    
});


function checkIfScrolledDown(){

    scrollTop = parseInt($(window).scrollTop());
    winHeight = parseInt($(window).height());
    docHeight = parseInt($(document).height());
    sc_wh = scrollTop + winHeight;
    

    if (scrollTop + winHeight == docHeight) {
        downloadMoreItem();
    }

    
    if (scrollTop + winHeight > docHeight - 100) {

        if (stopScrollCheck != true) {
            downloadMoreItem();
            stopScrollCheck = true;
            
               timer = setTimeout(function(){
                   stopScrollCheck = false;
               }, 2000);
            
        }
    }
}


function downloadMoreItem() {
    
    path = (window.location.pathname);
    path = path.replace(/\//g, '_');
    last_scroll = parseInt($.cookie("scroll"+path));
    
    last_scroll = !last_scroll ? 0 : last_scroll;
    
    newScroll = last_scroll + 1; 

    limit = newScroll * 12;
    
    productsToShow = 0;
    $('#product_wrap').find('.product').each(function(){
        productsToShow++;

        $wrap = $(this);
        
        if (productsToShow <= limit) {
            srcToLoad = $(this).find('.product_thumb').attr('data-src');                
            $(this).find('.product_thumb').attr('src', srcToLoad).load(function(){
                $(this).closest('.product').fadeIn();
            });
        }


    });
    
    $.cookie("scroll"+path, newScroll, { expires : 1 });
    

}

$('form.self_submit').change(function() {
     $(this).submit();
});


$('.parent_submit').change(function() {
     $(this).closest('form').submit();
});



$('#searchField').click(function(){
   if ($(this).val()) {
       $(this).closest('form').submit();
   }
});

$('#searchForm').submit(function(event){

   $(this).attr('action', '/kereses/' + $('#searchField').val());
    //    event.preventDefault();

});


$('.enable_submit').change(function(){
    submit_button = $(this).closest('form').find('button[type="submit"]');
    
        if ($(this).is(':checked')) {
            $(submit_button).removeAttr('disabled');
        } else {
            $(submit_button).attr('disabled', 'disabled');   
        }
});






