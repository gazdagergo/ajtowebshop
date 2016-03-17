$(document).ready(function(){
    
    
    var pathArray = window.location.pathname.split( '/' );
    var id = pathArray[4];
    var scope = pathArray[3];
    
        if (scope == 'edit') {
    
    /**** opcoik szserkesztes gomb ***/

            html = '<div class="form-group"><label class="col-sm-2 control-label">Termék-opciók</label><div class="col-sm-10"><a href="/admin/opciok/'+id+'"><input value="Opciók szerkesztése" class="btn btn-large" id="opciok-button" type="button"></a></div></div>';

            if ($('.sku_form_group').length > 0) 
                $(html).insertAfter('.sku_form_group');
            else
                $(html).insertAfter('.active_form_group');

            
    /**** osszevont termek szserkesztes gomb ***/

            html = '<span>&nbsp;</span><a href="/admin/product_groups/'+id+'"><input value="Termék-összevonások szerkesztése" class="btn btn-large" id="opciok-button" type="button"></a> ';

            $(html).insertAfter('#field_product_group_chzn');

            
    /**** egyedi termekparamterek szerkesztese gomb ***/

            html = '<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><a href="/admin/attribute_by_sku/'+id+'"><input value="Egyedi termékparaméterek szerkesztése" class="btn btn-large" id="opciok-button" type="button"></a></div></div>';

            $(html).insertAfter('.file_5_url_form_group');

            
    /******/

            
                $('input[name="att_weight"], input[name*="dim"]').each(function(){
                    changeToComma($(this).attr('name'));
                });
            
            
            
        } 
    
    
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
