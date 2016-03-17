<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

        <?php
            if ($config['HUF_MERCHANT']!='') {
        ?>
            <form method="POST" action="/penztar/fizetes">
                <input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">
                <input type="hidden" name="testcurrency" id="testcurrency" value="HUF">
                <input type="hidden" name="order_id" value="<?php echo $order_details->id; ?>">
                <img id="payu_preload" src="/assets/images/simple_vedd_online.png" style="width:150px;">
                
                <table class="elfogad">
                    <tr>
                        <td>
                            <label for="elfogad">Elfogadom a <a href="/vasarloi_tajekoztato" target="_blank"> Vásárlói tájékoztatóban</a> foglaltakat.</label>    </td>
                        <td>
                            <input id="elfogad" type="checkbox" name="elfogad" class="enable_submit" />
                        </td>
                    </tr>
                </table>                
                
                <button type="submit" id="payment_button" class="<?php echo $button_class; ?> keret-aljara" disabled>Rendelés</button>	
            </form><br>
       
        <?php
            }
        ?>					
									
    

    </div> <!-- kosar lista wrap-->


