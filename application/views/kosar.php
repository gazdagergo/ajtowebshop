<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section class="wrapper main-wrap">

    <div id="productlist" class="fokeret kek">

        <div id="productlist-header">
            <h3 class="icon-cart">Kosár</h3>

            <div class="szuresek">

            </div>

        </div>

        <div class="clear"></div>

        <div class="productlist-body cart-body">

        <?php if (isset($state) && $state == 'ures_kosar') : ?>

            <div class="text-wrap"><h4><?php echo $uzenet; ?></h4></div>

        <?php endif; ?>            
            
        <?php
            
        $cart_total = number_format($this->cart->total(), 0, ',', '.') . " Ft";
            
        foreach ($this->cart->contents() as $items) : 
            $minta_file = $szin_file = NULL;
            $file_url = $this->product_model->get_product_field($items['id'], 'file_1_url');
            $thumb = thumb_name(TERMEKLISTA_THUMB_WIDTH, $file_url);
            $url_string = $this->product_model->get_product_field($items['id'], 'url_string');
            $short_desc = ucfirst($this->product_model->get_product_field($items['id'], 'short_description'));
            
            if (empty($url_string)) {
                $url_string = $items['id'];
            }
            
            $price = number_format($items['price'], 0, ',', '.') . " Ft";
                
                if (!empty($items['options'])) {
                    //a_print($items['options']);
                    $options = '';
                    $i=0;
                        foreach ($items['options'] as $key => $value) {
                            if ($i > 0) $options .= ", ";
                            $options .= ucfirst($key) . ":  <strong>" . $value . "</strong>";
                            $i++;
                            
                            if ($key == 'Minta') $minta_file = $this->view_model->get_minta_file_by_text($value, $items['id']);
                            if ($key == 'Szín') $szin_file = $this->view_model->get_minta_file_by_text($value, $items['id']);
                            if ($key == CIKKSZAM) {
                                $sku = $value;
                                $url_string = $this->product_model->get_url_string_by_sku($sku);                                
                            }
                     }

                    if ($short_desc != '' AND $options != '') {
                        $short_desc = $options /*. " | " . $short_desc*/;
                    } else {
                        $short_desc = $options . $short_desc;                        
                    }
                    
                }

            
            ?>
            
            <form id="<?php echo "cart_item_form_$items[id]"; ?>" action="" method="post" class="product self_submit">
                <div class="kosar-sor">

                    <a href="/termekek/<?php echo $url_string; ?>">
                        <div class="list-img-wrap" style="<?php echo "min-width: " . TERMEKLISTA_THUMB_WIDTH . "px; min-height: " . TERMEKLISTA_THUMB_HEIGHT . "px" ?>">
                            
                        <?php if (isset($szin_file) AND isset($minta_file)) :
                        
                            $minta_file = PICTURE_UPLOAD_DIR . thumb_name(TERMEKLISTA_THUMB_WIDTH, $minta_file);
                            list($width, $height) = getimagesize($minta_file);
                            $left_margin = $width / (-2);
                            ?>
                            <img class="product_thumb" alt="Ablak1" src="/<?php echo PICTURE_UPLOAD_DIR . thumb_name(TERMEKLISTA_THUMB_WIDTH, $szin_file); ?>" alt="cart_item" />
                            <img class="kosar_minta" style="margin-left: <?php echo $left_margin; ?>px;" class="product_thumb" alt="Ablak1" src="/<?php echo $minta_file; ?>" alt="cart_item" />
                            
                            
                        <?php else : ?>
                            <img class="product_thumb" alt="Ablak1" src="/<?php echo PICTURE_UPLOAD_DIR . $thumb; ?>" alt="cart_item" />
                        <?php endif; ?>
                        </div>
                    </a>
                    <div class="price_wrap">
                        <a href="/termekek/<?php echo $url_string; ?>">
                            <span itemprop="name"><?php echo $items['name']; ?></span>
                            <span itemprop="price"><?php echo $price; ?>/db</span>
                            <span itemprop="description" class="product-desc"><?php echo $short_desc; ?></span>
                        </a>

                        <table class="subtotal_table product-desc">
                            <tr>
                                <td>
                                    <label>Mennyiség:</label>
                                </td>
                                <td>
                                    <input class="qty_inp" name="qty" value="<?php echo $items['qty']; ?>" type="number">
                                </td>
                                <td class="subtotal">
                                    <?php echo number_format($items['subtotal'], 0, ',', '.') . " Ft"; ?>
                                </td>
                            </tr>
                        </table>

                    </div>


                    <input class="szurke-gomb torles-gomb" name="call_just_this_main_function" type="submit" value="Törlés" />

                    <input name="call_main_function" value="updateCart" type="hidden">
                    <input type="hidden" name="rowid" value="<?php echo $items['rowid']; ?>" />
                    <input type="hidden" name="product_id" value="<?php echo $items['id']; ?>" />
                    <?php if (isset($sku)) : ?>
                    <input type="hidden" name="sku" value="<?php echo $sku; ?>" />
                    <?php endif; ?>


                </div>
            </form>
            
            <?php endforeach; ?>

        </div>
        
        <div class="clear"></div>

        <div id="productlist-footer">
            <?php if (!isset($state) || $state != 'ures_kosar') : ?>
            <p>Összesen: <?php echo $cart_total; ?></p> 
            <a id="penztarhoz" class="kek-gomb nagy-gomb icon-pipa keret-aljara" href="/penztar">Tovább a pénztárhoz</a>
            <?php endif; ?>

        </div>

        
        
    </div>
    
        <?php echo $gombok; ?>
    
</section>

