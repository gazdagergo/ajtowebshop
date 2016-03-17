<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <section id="kosar_wrap" class="wrapper content_wrapper">   

        
        <div class="text_wrap">
            
            <h3>Megrendelés elküldve</h3>

            <p class="green big"><strong>Sikeres rendelés</strong></p>
            <p>Megrenelését megkaptuk, amiről hamarosan értesítést küldünk a megadott email címre.</p>
            <p>&nbsp;</p>
            <p><strong>Kérjük a következő utalást szíveskedjen megindítani a vételár kiegyenlítésére:</strong></p>
            <p>&nbsp;</p>
            <p>Számlatulajdonos: <strong>Effektív Art Kft.</strong></p>
            <p>Bankszámlaszámunk: <strong>10800014-90000006-10249493</strong></p>
            <p>Összeg: <strong><?php echo $total; ?> Ft </strong></p>
            <p>Megjegyzés: <strong><?php 
                echo $name . ', ' . $order_id; 
                
                ?></strong></p>
            
            
        </div>
        
</section>