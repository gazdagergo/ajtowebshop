<?php defined('BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section id="fooldal-wrap" class="wrapper">
    <div id="mester1">
        <div id="buborek1">
            <p>Segítenek <br>a Mesterek!</p>
        </div>
    </div>
    
    <div id="mester2">
        <div id="buborek2">
            <p>Írjon nekünk <br>bizalommal, <br>ha elakad <br>a munkában!</p> 
        </div>
    </div>    
    
    <div id="slider-keret" class="fokeret kek">
        <div id="slider-img-wrap">
            <img src="/uploads/files/slider.jpg" alt="Offer 1" />
            <img src="/uploads/files/slider2.jpg" alt="Offer 2" />
        </div>
        
        <div id="slide-prev" class="slide-nyil"></div>
        <div id="slide-next" class="slide-nyil"></div>
    </div>

    <?php echo $gombok; ?>
    
    
    <div id="csomagajanlatok-keret" class="fokeret piros">

        <div id="csomagajanlatok-cim" class="keret-cim kis-keret-cim">
            <h1>Csomagajánlatok</h1>
        </div>
                <img style="display: block;margin: auto; cursor:pointer;" src="/uploads/files/kamu-1.jpg" />
    </div>
    
    <div id="kiemelt-termeke-keret" class="fokeret kek">

        <div id="kiemelt-termekek-cim" class="keret-cim kis-keret-cim">
            <h1>Kiemelt termékek</h1>
        </div>
                <img style="display: block;margin: auto; cursor:pointer;" src="/uploads/files/kamu-2.jpg" />
    </div>
    
</section>