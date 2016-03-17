$(document).ready(function(){
    
    
    var pathArray = window.location.pathname.split( '/' );
    var id = pathArray[3];
    
    url = id == undefined ? '/admin/products' : '/admin/products/edit/'+id;

    
html = '<div class="floatL t5"><a class="btn btn-primary" href="'+url+'"><i class="fa fa-arrow-left"></i> &nbsp; Vissza </a></div>';
    
    $('.header-tools').prepend(html);
    
});

