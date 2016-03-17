<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<footer>
    <section class="wrapper">

        <div id="foot_logo">

        </div>

        <div id="foot_text">
            <div>
                <h4>Bazi Bazár</h4>
                <p>1093 Budapest, Fővám tér 11-12., -1 szint, 14/B üzlet</p>
                <p>Nyitva tartás: Hétfő - Vasárnap: 10-18h</p>
                <p>Telefon: +36 30 944 2800</p>
                <p>E-mail: <a href="mailto:info@bazibazar.hu">info@bazibazar.hu</a></p>
            </div>
               
            <div>
                   <ul>
 <?php
                    foreach($categories as $cat) {
                        echo '<li><a href="/';
                        echo $cat['url'];
                        echo '">';
                        echo $cat['name'];
                        echo '</a></li>';
                        
                    }
                
                ?>
                
                </ul>
            </div>

            <div>
                <ul>                
                    <li><a href="/vasarloi_tajekoztato">VÁSÁRLÓI TÁJÉKOZTATÓ</a></li>
                    <li><a href="/rolunk">KAPCSOLAT</a></li>
                    <li><a href="#">BLOG</a></li>
                </ul>    
                <a id="karyak" href="https://simplepartner.hu/PaymentService/Fizetesi_tajekoztato.pdf" target="_blank"></a>
                <p>&nbsp;</p>
                <p>© Effektív-Art Kft. 2015 | minden jog fenntartva</p>
            </div>
        </div>

    </section>

</footer>

<script type="text/javascript" src="/assets/js/main.js"></script>


</body>

</html>