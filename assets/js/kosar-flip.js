    $('.kosar-sor').each(function(){
       text = $(this).find('.product-desc').text();
        if (text.indexOf('jobbos') > 0)
            $(this).find('.product_thumb').addClass('flip');

    });
