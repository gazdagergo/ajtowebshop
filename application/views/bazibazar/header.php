<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>
<?php 
    if ($this->input->post()) {
        if ($this->uri->segment(1) != 'penztar') {
            if (!$this->authentication->is_loggedin()){
                header("Location: ".current_url());
            }
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png" />
    <link rel="stylesheet" type="text/css" href="/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css" />

    <title>Bazi Bazár</title>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="/assets/fonts/fontsmoothie.min.js" async></script>
	<script src="/assets/js/jquery.cookie.js"></script>

</head>


<body>
<script type="text/javascript">
var utag_data = {
  ga_eventCategory : "", // 
  ga_eventAction : "", // 
  ga_eventLabel : "", // 
  ga_eventValue : "", // 
  wt_plugin_brightcove : "", // URL to plugin
  wt_plugin_mmm_downloads : "", // URL to plugin
  wt_plugin_scroll_depth : "" // URL to plugin
}
</script>

<!-- Loading script asynchronously -->
<script type="text/javascript">
    (function(a,b,c,d){
    a='//tags.tiqcdn.com/utag/3m/offp-hu-hu/prod/utag.js';
    b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
    a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
    })();
</script>
    
    
    <header>
        
        <div id="fomenu_wrap" class="wrapper">

            <a href="/">
                <div id="logo"></div>
            </a>

            <ul id="fomenu">
                <li><a href="#">Blog</a>
                </li>
                <li><a href="/rolunk">Rólunk</a>
                </li>
                <li class="active"><a href="/">Bolt</a>
                </li>
            </ul>
            <form id="searchForm" method="post" class="self_submit" action="/kereses">
                <input id="searchField" placeholder="KERESÉS" />
            </form>    


            <ul id="social">
                <li><a href="https://www.facebook.com/bazibazarbudapest" target="_blank"><img src="/assets/images/share-fb.png" alt="facebook" title="Facebook"></a>
                </li>
                <li><a href="https://www.pinterest.com/bazibazar/" target="_blank"><img src="/assets/images/share-pin.png" alt="pinterest" title="Pinterest"></a>
                </li>
                <li><a href="https://www.instagram.com/bazibazar/" target="_blank"><img src="/assets/images/share-ig.png" alt="instagram" title="Instagram"></a>
                </li>
                <li><a href="mailto:info@bazibazar.hu"><img src="/assets/images/share-mail.png" alt="email" title="Email"></a>
                </li>
                <li><a href="https://www.google.hu/maps/place/B%C3%A1lna+Budapest/@47.4835483,19.0612442,15z/data=!4m2!3m1!1s0x0:0x10744f5ecfa67dab" target="_blank"><img src="/assets/images/share-map.png" alt="map" title="Maps"></a>
                </li>
            </ul>


        </div>

        <div id="menu_wrap" class="wrapper">
            <nav id="menu">
                
            <?php
                $this->product_model->print_categories();
            ?>                
                
            </nav>


            <a id="kosar_gomb" href="/kosar">
                <?php 
                    if ($this->cart->total_items() >0) {
                        echo '
                            <div id="kosar_db">
                                ' . $this->cart->total_items() . '
                            </div>
                        ';
                    }
                ?>
            </a>


      <!--      <div id="belep_wrap">
                <a href="#">Belépés</a><a href="#">Regisztráció</a>

            </div>-->


        </div>

    </header>


    <section>
        <div id="termeklista-wrap" class="wrapper">
            <div id="lista-fejlec">
                <h3>Műanyag ablakok</h3>
                
                <?php echo $szuresek; ?>
                
            
            </div>
        
        
        </div>
    
    </section>
    
    
    