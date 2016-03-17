<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<section id="penztar_wrap" class="wrapper content_wrapper">
    
    <h3>Megrendelés</h3>


    <div id="penztar_form_wrap">
    
        <form id="penztar_form" method="post" action="" class="self_submit">
            
            
            
            <div class="form_felhasab">

            <h4>Fizetési mód</h4>

                
        <?php
                
            echo '<div class="select-style" id="paying_method">';
          
            $options =   '<option selected disabled>-- Kérjük válasszon --</option>';  
                
                foreach ($paying_list as $option) {

    
                    $options .= "<option ";
                    if (set_value('paying_method') == $option->code ) $options .= "selected";
                    $options .= " value='$option->code'>$option->text</option>";
                }
                
          
            echo form_dropdown('paying_method', $options);
                
            echo "</div>";
            echo form_error('paying_method');    
            

    ?>
                
            </div>
            

            
            <div class="form_felhasab">
                
            <h4>Szállítási mód</h4>

            
        <?php
                
            
            echo '<div class="select-style" id="delivery_mode">';
          
            $options = '<option selected disabled>-- Kérjük válasszon --</option>';  
                
                foreach ($delivery_list as $option) {
                    $options .= "<option ";
                    if (set_value('delivery_mode') == $option->code ) $options .= "selected";
                    $options .= " value='$option->code'>$option->text</option>";
                }
          
            echo form_dropdown('delivery_mode', $options);
                
            echo "</div>";
            echo form_error('delivery_mode');    

        ?>
                

                
            </div>

            <div class="clear"></div>
                    
                    <input type="submit" class="altalanos_gomb piros_gomb" <?php
                            if (isset($utanvet_hiba)) echo "disabled"; 
                                                ?> name="ellenorzesre_gomb" id="megrendel_gomb" value="Tovább az ellenőrzésre" />
                    
				</form>		
        
    </div>
    
    
    <script>
        <?php if (!empty($form_details) AND !$this->input->post()) : 
        ?>
        
        var obj = <?php echo json_encode($form_details); ?>;
        
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {

                    if ($('[name="'+key+'"]').attr('type') == 'email' || $('[name="'+key+'"]').attr('type') == 'text') {
                        $('#'+key).val(obj[key]);
                    }
                    if ($('[name="'+key+'"]').is('select')) {
                            $('[name="'+key+'"]').find('option').each(function(){
                                if ($(this).val() == obj[key]) {
                                    $(this).attr('selected', 'selected');
                                }
                            });
                    }
                    if ($('[name="'+key+'"]').attr('type') == 'checkbox') {

                        if (obj[key] == null) {
                            $('#'+key).prop('checked', false);
                        } else {
                            $('#'+key).prop('checked', true);
                        }
                    }
                }
            }
                   
    
    <?php endif; ?>
    
    
    </script>
    