<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

            <form method="POST" action="/penztar/megrendelve/utanvet">
                <input type="hidden" name="order_id" value="<?php echo $order_details->id; ?>">
                
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
       
				
									
    

    <!--</div>--> <!-- kosar lista wrap-->


