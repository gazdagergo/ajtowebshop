<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<?php 
    $exceptions = array('penztar', 'rolunk');
    $allowed = array('penztar/szallitas_fizetes');
    
if ((property_exists($this, 'form_validation') AND $this->form_validation->run() != FALSE) OR !property_exists($this, 'form_validation') )

    if ($this->input->post()) {

        if (!$this->authentication->is_loggedin()){
            
            if (!in_array($this->uri->segment(1),$exceptions)) {
                    header("Location: ".current_url());
            } 
            if (in_array($this->uri->segment(1) . '/'. $this->uri->segment(2),$allowed)) {
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
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/reset.css" />

    <title>Ajtówebshop</title>

    <script src="/assets/js/jquery-v1.11.1.js"></script>
    <script type="text/javascript" src="/assets/fonts/fontsmoothie.min.js" async></script>
    <script src="/assets/js/jquery.cookie.js"></script>



</head>


<body>

    <header>
        <?php if (ENVIRONMENT == 'testing') : ?>
        
        <div id='test-alert'>
            Figyelem, ez egy tesztoldal. A leadott rendelések nem teljesülnek.
        </div>
        
        <?php endif; ?>
        
        <div id="fomenu_wrap" class="wrapper">

            <ul id="kek_gombsor" class="gombsor">
                <li id="kosar-menu" class="vilagoskek <?php if ($this->cart->total_items() >0) echo "vekony"; ?> kosar-icon"><a href="/kosar">
                <?php 
                    if ($this->cart->total_items() >0) {
                        echo $this->cart->total_items();
                        echo "db termék | ";
                        echo number_format($this->cart->total(), 0, ',', '.');
                    } else {
                        echo "Kosár üres";   
                    }
                ?>
                   </a>
                </li>
<!--                <li class="pencil-icon"><a href="/regisztracio">Regisztráció</a>
                </li>-->
<!--
                <li class="lock-icon"><a href="/bejelentkezes">Bejelentkezés</a>
                </li>
-->
                <li class="pencil-icon"><a href="/kapcsolat">Kapcsolat</a>
                </li>
            </ul>


            <ul id="narancs_gombsor" class="gombsor">
                <li class="hammer-icon"><a href="/beepitesi_abc">Építkezők tudástára</a>
                </li>
                <li class="list-icon"><a href="/gyik">GYIK</a>
                </li>
                <li class="clipboard-icon"><a href="/vasarloi_tajekoztato">Vásárlói tájékoztató</a>
                </li>
<!--                <li class="navigation-icon"><a href="/szallitasi_feltetelek">Szállítási feltételek</a>-->
                </li>
            </ul>

        </div>

        <div class="clear"></div>

        <div id="almenu-wrap" class="wrapper">
            <div id="logo">
                <a href="/">
                    <img src="/assets/images/ajtowebshoplogo2.svg" alt="Ajtówebshop" />
                </a>
            </div>

            <div id="kozep-wrap">
                <form id="searchForm" method="post" class="self_submit" action="/kereses">
                    <input id="searchField">
                </form>

                <?php echo $almenu; ?>
                

            </div>

        
            <div id="unisec">
                <a href="//unisec.hu">
                    <img src="/assets/images/szakmai-partnerunk.png" alt="unisec" />
                </a>
            </div>

        </div>

        <div class="clear"></div>



    </header>


    <div class="clear"></div>