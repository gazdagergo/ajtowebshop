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
            
            <?php echo $galeria; ?>
            
        </div>
        
        <div id="slide-prev" class="slide-nyil"></div>
        <div id="slide-next" class="slide-nyil"></div>
    </div>

    <?php echo $gombok; ?>
    
    
<!--
    <div id="csomagajanlatok-keret" class="fokeret piros">

        <div id="csomagajanlatok-cim" class="keret-cim kis-keret-cim">
            <h1>Csomagajánlatok</h1>
        </div>
                <img style="display: block;margin: auto; cursor:pointer;" src="/uploads/files/kamu-1.jpg" />
    </div>
-->
    
    <div id="kiemelt-termeke-keret" class="fokeret kek">

        <div id="kiemelt-termekek-cim" class="keret-cim kis-keret-cim">
            <h1>Kiemelt termékek</h1>
        </div>
        
        <div id="kiemelt-body" class="racs-wrap">
        
        <?php foreach ($kiemelt_termekek as $product) : ?>
            
            <a href="/termekek/<?php echo $product->url_string; ?>">
                <div class="racs-termek-wrap">
                    <div class="racs-img-wrap">
                        <img src="<?php echo PICTURE_UPLOAD_DIR . thumb_name(RACS_THUMB_WIDTH, $product->file_1_url); ?>" alt=""/>
                    </div>
                    <div class="clear"></div>
                    <div class="racs-text">
                        <p><?php echo $product->name; ?><br><?php echo price_format($product->price); ?>.-</p>
                    </div>
<!--
                    <form method="post">
                        </?php echo $this->product_model->print_product_cart_form_hiddens($product); ?>
                        <input type="hidden" name="qty" value="1" />

                    <input class="racs-kosar-gomb vilagoskek" type="submit" value="Kosárba" />
                    </form>
-->
                    
                    
                </div>
            </a>
            
        <?php endforeach; ?>
            
        </div>
        
    </div>
    
</section>