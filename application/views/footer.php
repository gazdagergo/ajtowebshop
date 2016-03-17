<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

    <footer>
        <section class="wrapper" id="foot-wrap">


<?php echo $foot_menu; ?>



            <ul id="foot-links">
                <li><a href="/">Ügyfélszolgálat</a>
                </li>
                <li><a href="/">GYIK</a>
                </li>
                <li><a href="/vasarloi_tajekoztato">Vásárlói tájékoztató</a>
                </li>
                <li><a href="/">Szállítási feltételek</a>
                </li>
                <li><a href="/kapcsolat">Kapcsolat</a>
                </li>
                <li>&nbsp;</li>
                <li>&copy; <?php echo date('Y'); ?> AJTÓEXPRESS KFT.</li>
            </ul>

            <div id="foot-logo">
                <a href="/">
                    <img src="/assets/images/ajtowebshoplogo-feher.svg" alt="logo" />
                </a>
            </div>

            <a href="http://simplepartner.hu/PaymentService/Fizetesi_tajekoztato.pdf" target="_blank">
                <div id="simple_foot">
                </div>
            </a>    






        </section>

    </footer>

    <script type="text/javascript" src="/assets/js/main.js"></script>
    <script type="text/javascript" src="/assets/js/ajtowebshop.js"></script>

    <script>
        respReplace = function(){
            var kek_gombsor = $('#kek_gombsor').html();
            $('#almenu').append(kek_gombsor);
            var narancs_gombsor = $('#narancs_gombsor').html();
            $('#almenu').append(narancs_gombsor);
        }
        
		$(window).on('resize', function(){
			  var win = $(this); //this = window
			  if (win.width() <= 975) { 
                    respReplace();
                }
		});
		
		$(document).ready(function(){
			if ($(window).width() < 600){
                respReplace();
			}
		})
	</script>
<?php

        if (isset( $_SERVER['HTTP_REFERER'])) {
            $termek = $this->uri->segment(1) . '/' . $this->uri->segment(2);
            $referer_parts = explode('/', $_SERVER['HTTP_REFERER']);
            
            if (array_key_exists(4, $referer_parts))
                $referer_termek = 'termekek/'.$referer_parts[4];
            

            
                if ($_SERVER['HTTP_REFERER'] == "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") {
                    $scroll_top = $this->input->cookie('last_scroll');   

                            echo "
                            <script>
                            $(window).scrollTop('".$scroll_top."');
                            </script>
                            ";

                }

                else if (isset($referer_termek) AND $referer_termek == $termek) {
                    $scroll_top = $this->input->cookie('last_scroll');   
                    
                            echo "
                            <script>
                            $(window).scrollTop('".$scroll_top."');
                            </script>
                            ";

                }
                else if ($_SERVER['HTTP_REFERER'] !=  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") {
                        delete_cookie('last_scroll');
                    }
        }
            


?>
    
</body>

</html>