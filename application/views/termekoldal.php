<?php defined('BASEPATH') OR exit( 'No direct script access allowed'); ?>

<section class="wrapper">

    <div id="productlist" class="fokeret kek">

        <div id="termekoldal-termeknev" class="keret-cim kek">
            <h1>biztonsági ajtók</h1>
            <h2>beltéri ajtók</h2>

        </div>


        <div class="clear"></div>

            <?php 

                $stock_status = $product->stock > 0 ? 'InStock' : ' PreOrder';
                
            ?>
        
        
        <div class="productpage-body" itemscope itemtype="http://schema.org/Product">

            <div id="kep-plusz-galeria">

                <div id="kep-wrap">
                    <a href="#" id="nagyitas">
                        
                        <?php if (isset($szin_file)) : ?>
                        <img itemprop="image" id="productImage" src="/<?php echo PICTURE_UPLOAD_DIR . thumb_name(TERMEK_IMAGE_WIDTH, $szin_file); ?>" alt="<?php echo $product->name; ?>" />
                        <?php else : ?>
                        <img itemprop="image" id="productImage" src="/<?php echo PICTURE_UPLOAD_DIR . thumb_name(TERMEK_IMAGE_WIDTH, $product->file_1_url); ?>" alt="<?php echo $product->name; ?>" />
                        <?php endif; ?>
<!--                        <div id="lupe"></div>-->
                        
                        <?php if (isset($minta_file)) : ?>
                        <img id="maras" src="/uploads/files/<?php echo thumb_name(TERMEK_IMAGE_WIDTH, $minta_file); ?>" />
                        <?php endif; ?>

                    </a>

                    <img src="/assets/images/loading.gif" id="loadingImg" />

                </div>

                <div class="clear"></div>

                
                <div id="galeria-wrap" class="product-gallery">

                   <?php echo $gallery; ?>
                    
                </div>

            </div>

            <div id="product-text-wrap">

                <h3 itemprop="name"><?php echo $product->name; ?></h3>
                <span itemprop="description"><?php echo $product->short_description; ?></span>

                    <?php if ($product->price > 0) : ?>
                <div id="price-wrap" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <span itemprop="price" content="<?php echo $product->price; ?>"><?php echo price_format($product->price); ?>.-</span>
                    <span itemprop="priceCurrency" content="HUF"></span>
                    <link itemprop="availability" href="http://schema.org/<?php echo $stock_status; ?>" />
                </div>
                    <?php endif; ?>

                <?php if ($product->long_description != '') : ?>
                
                <div id="product-desc">
                    <?php echo $product->long_description; ?>
                </div>

                <?php endif; ?>
                
                
                <div id="product-properties" itemscope itemtype="http://schema.org/Property">
                    <?php if ($attribute['material'] != '') : ?>
                    <div>anyag: <?php echo $attribute['material']; ?></div>
                    <?php endif; ?>
                    <?php if ($attribute['color'] != '') : ?>
                    <div>szín: <?php echo $attribute['color']; ?></div>
                    <?php endif; ?>
                    <?php if ($attribute['weight'] != '') : ?>
                    <div>súly: <?php echo $attribute['weight']; ?></div>
                    <?php endif; ?>
                    <?php if ($attribute['width'] != '' AND $attribute['height'] != '') : ?>
                    
                    <div>méret: 
                        <?php echo $attribute['width']; ?>
                        <span>&nbsp;x&nbsp;</span>
                        <?php echo $attribute['height']; ?>
                    </div>
                    <?php endif; ?>
                    <div>cikkszám: <span itemprop="sku"><?php echo $sku; ?></span></div>
                </div>

            </div>
            
            
            <?php if ($product->stock > 0 AND $product->stock == $product_in_cart) : ?>
            
                <div id="rendelesre"><a href="/kosar"><?php echo $product_in_cart; ?>&thinsp;db a kosárba helyezve</a></div>

            <?php elseif ($product->stock > 0) : ?>
            
            <form method="post" id="menny_form">
                <?php echo $product_cart_form_hiddens; ?>
                <div id="product-gomb-wrap">
                <?php if ($product->price > 0 AND $product->stock > 0 AND $product->active) : ?>
                    <?php if ($product->stock > 1) : ?>
                    <div id="termekoldal-db-select" class='select-style'>
                        <select name="qty">
                            <?php for ($i=1; $i <= min(($product->stock - $product_in_cart), 30); $i++) { 
    if ($i > 10 AND !in_array($i, array(15,20,25,30))) continue;
    echo "<option value='$i'>$i db</option>";
} ?>
                        </select>
                    </div>
                <?php else: ?>
                    
                    <input type="hidden" name="qty" value="1" />
                    
                <?php endif; ?>
                                    <input id="kosarba_gomb" class="kosarba_gomb" type="submit" value="Kosárba" title="Kosárba helyezés" />

                <?php endif; ?>

                </div>
            </form>
            
            <?php else: ?>
                <div id="rendelesre">Nincs raktáron, rendelhető</div>
            <?php endif; ?>

            <div class="clear"></div>
            
            <div id="form-options">

             <?php echo $form_group; ?>
             <?php echo $form_options; ?>
                        
            </div>
            
        </div>


    </div>
</section>