<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section id="penztar_wrap" class="wrapper content_wrapper">
    
    <h3>Megrendelés</h3>


    <div id="penztar_form_wrap">

        
        
        <form id="penztar_form" method="post" action="">
            <h4>Kérjük, adja meg szállítási címét</h4>

            <?php
            
            echo form_label('Név: ', 'nev');
            echo form_input(array(
                'type' => 'text',
                'id' => 'name',
                'name' => 'name',
                'value' => set_value('name'),
            ));
            echo "<br>";
            echo form_error('name');
            
            
            echo form_label('Város: ', 'city');

            echo '<div class="select-style" id="city">';
            
            $options = '<option selected disabled>--- Kérjük, válasszon ---</option>
                    <option value="Budapest">Budapest</option>
                    <option disabled>-------------</option>';
            
                foreach ($cities as $city) {
                    $options.= '<option ';
                    if (set_value('city') == $city->city) $options.= "selected";
                    $options.= ' value="'.$city->city.'">'; 
                    $options .= $city->city;
                    $options .= '</option>';
                }

            
            echo form_dropdown('city', $options, set_value('city'));
              
            echo "</div>";
            
            
            echo form_label('Irányítószám: ', 'zip');
            echo form_input(array(
                'type'  =>  'text',
                'id'    =>  'zip',
                'name'  =>  'zip',
                'value' =>  set_value('zip'),
            ));
            echo form_error('city');
            echo form_error('zip');
            echo "<br>";
            

            echo form_label('Utca, házszám: ', 'address');
            echo form_input(array(
                'type'  =>  'text',
                'id'    =>  'address',
                'name'  =>  'address',
                'value' => set_value('address'),
            ));
            echo form_error('address');
            echo "<br>";
            
            
            echo form_label('Mobiltelefon / telefon: ', 'phone');
            echo form_input(array(
                'type'  =>  'text',
                'id'    =>  'phone',
                'name'  =>  'phone',
                'value' =>  set_value('phone'),
            ));
            echo form_error('phone');
            echo "<br>";
            
            echo form_label('E-mail cím: ', 'email');
            echo form_input(array(
                'type'  =>  'email',
                'id'    =>  'email',
                'name'  =>  'email',
                'value' =>  set_value('email'),
            ));
            echo form_error('email');
            echo "<br><br>";
            
            if (!$this->input->post('ellenorzesre_gomb')) {
                $checked = TRUE;
            } 
            else if ($this->input->post('same_address') == 1) {
                $checked = TRUE;
            } else {
                $checked = FALSE;
            }
            
            echo form_checkbox(array(
                'id'        =>  'same_address',
                'checked'   =>  $checked,
                'name'      =>  'same_address',
                'value'     =>  1,
            ));
            
            echo form_label('Számlacím megegyezik a szállítási címmel', 'same_address');
            
            
            ?>


            <div id="szamlacim_wrap">
            
                <h4>Számlázási cím</h4>

        <?php
            
            echo form_label('Név / Cégnév: ', 'bill_company');
            echo form_input(array(
                'type'  => 'text',
                'name'  => 'bill_company',
                'id'    => 'bill_company',
            ));
            echo "<br>";
                
            echo form_label('Város: ', 'bill_city');
            echo '<div class="select-style" id="bill_city">';
            
            $options = '<option selected disabled>--- Kérjük, válasszon ---</option>
                    <option value="Budapest">Budapest</option>
                    <option disabled>-------------</option>';
            
                foreach ($cities as $city) {
                    $options.= '<option ';
                    if (set_value('bill_city') == $city->city) $options.= "selected";
                    $options.= ' value="'.$city->city.'">'; 
                    $options .= $city->city;
                    $options .= '</option>';
                }
            
            echo form_dropdown('bill_city', $options, set_value('bill_city'));
            echo "</div>";                

            echo form_label('Irányítószám: ', 'bill_zip');
            echo form_input(array(
                'type'  =>  'text',
                'name'  =>  'bill_zip',
                'id'    =>  'bill_zip',
            ));
            echo "<br>";
                
            echo form_label('Utca, házszám: ', 'bill_address');
            echo form_input(array(
                'type'  =>  'text',
                'name'  =>  'bill_address',
                'id'    =>  'bill_address',
            ));
            echo "<br><br>";
        ?>
                
            
            </div>
            <br>

            
            <div class="form_felhasab">
                
            <h4>Szállítási mód</h4>

            
        <?php
                
            
            echo '<div class="select-style" id="delivery">';
          
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
            <div class="clear"></div>
            <br>
            <input type="submit" class="altalanos_gomb piros_gomb" name="ellenorzesre_gomb" id="megrendel_gomb" value="Tovább az ellenőrzésre" />


        </form>

    </div>
    
    
    <script>
        <?php if (!empty($form_details)) : 
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
    