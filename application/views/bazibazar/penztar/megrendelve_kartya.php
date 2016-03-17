<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <section id="kosar_wrap" class="wrapper content_wrapper">   

        
        <div class="text_wrap">
            
            <h3>Megrendelés elküldve</h3>

            <p class="green big"><strong>Sikeres fizetés</strong></p>
            <p>Megrenelését megkaptuk, amiről hamarosan értesítést küldünk a megadott email címre.</p>
            <p>Az Ön PayU tranzakciójának referenciaszáma: <strong><?php echo $payrefno; ?></strong></p>
            <p>Dátum: <strong><?php echo $date; ?></strong></p>
            <p>Rendelésének azonosítója: <strong><?php echo $order_id; ?></strong></p>
            
        </div>
        
</section>