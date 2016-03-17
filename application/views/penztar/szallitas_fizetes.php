<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section class="wrapper main-wrap">

    <div id="szallitas" class="fokeret kek">
        <div id="termekoldal-termeknev" class="keret-cim kek">
            <h1>Megrendelői adatok</h1>
        </div>
        <div class="clear"></div>
        
            
<form id="penztar_form" method="post">
            
            <div class="keret-hasab hasab-50">


            <h4>Fizetési mód</h4>

                
        <?php
                
            echo '<div class="select-style" id="paying_method">';
          
            $options =   '<option selected disabled>-- Kérjük válasszon --</option>';  
                
                foreach ($paying_list as $option) {

    
                    $options .= "<option ";
                    if (set_value('paying_method') == $option->code ) $options .= "selected";
                    $options .= " value='$option->code'>$option->text</option>";
                }
                
          
            echo form_dropdown('paying_method', $options, NULL, 'class="parent_submit"');
                
            echo "</div>";
            echo form_error('paying_method');    
            

    ?>
                
            </div>
            

            
            <div class="keret-hasab hasab-50">
                
            <h4>Szállítási mód</h4>

            
        <?php
                
            
            echo '<div class="select-style" id="delivery_mode">';
          
            $options = '<option selected disabled>-- Kérjük válasszon --</option>';  
                
                foreach ($delivery_list as $option) {
                    $options .= "<option ";
                    if (set_value('delivery_mode') == $option->code ) $options .= "selected";
                    $options .= " value='$option->code'>$option->text</option>";
                }
          
            echo form_dropdown('delivery_mode', $options, NULL, 'class="parent_submit"');
                
            echo "</div>";
            echo form_error('delivery_mode');    
            if (isset($error)) echo '<div class="form_error">'.$error.'</div>';


        ?>
                

                
            </div>

            <div class="clear"></div>
    
        <div class="keret-hasab hasab-100">
    
        <?php if ($order_details->delivery_mode  == 'HOME_DLV') : ?>    
                <span>Az kiszállítás címe:</span> <?php echo $order_details->address; ?>

        <?php endif; ?>
            
    </div>
    <div class="keret-hasab hasab-100">
            <h4 id="user-notes">Megjegyzések a szállításhoz</h4>
            <textarea name="user_notes"><?php echo $order_details->user_notes ?></textarea>

    
    </div>
                    
                <div class="clear"></div>

                    <button type="submit" class="kek-gomb nagy-gomb icon-pipa keret-aljara"  <?php
                            if (isset($disable_submit)) echo "disabled"; 
                            ?> name="ellenorzesre_gomb" value="1">Tovább az ellenőrzésre</button>
                    
    
    
				</form>	
                
    </div>
    

    <?php echo $gombok; ?>
    
</section>