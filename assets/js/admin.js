$(document).ready(function(){
    
    /**** osszevont termek szserkesztes gomb ***/
    
    var pathArray = window.location.pathname.split( '/' );
    var id = pathArray[4];
    var scope = pathArray[3];
    
        if (scope != 'edit') {
            return false;
        }
    
    html = '<div class="form-field-box even" id="opciok_field_box"><div class="form-display-as-box" id="opciok_display_as_box">        Termék-opciók :    </div>    <div class="form-input-box" id="opciok_input_box">       <a href="/admin/opciok/'+id+'"><input value="Opciók szerkesztése" class="btn btn-large" id="opciok-button" type="button"></a>      </div>    <div class="clear"></div></div>    ';
    
    $(html).insertAfter('#product_group_field_box');
    
    
    html = '<span>&nbsp;</span><a href="/admin/product_groups/'+id+'"><input value="Termék-összevonások szerkesztése" class="btn btn-large" id="opciok-button" type="button"></a> ';
    
    $(html).insertAfter('#field_product_group_chzn');

    $('input[name="att_weight"], input[name*="dim"]').each(function(){
        changeToComma($(this).attr('name'));
    });

    
});


    
/**** decimal separator ****/

$('#crudForm').submit(function(){

    $('input[name="att_weight"], input[name*="dim"]').each(function(){
        inputVal =  $(this).val();
        inputVal = inputVal.replace(',', '.');
        $(this).val(inputVal);
        
    });
    


});

function changeToComma(selector) {
    inputVal = $('input[name="'+selector+'"]').val();
    inputVal = inputVal.replace('.', ',');    
    $('input[name="'+selector+'"]').val(inputVal);    
    
}
