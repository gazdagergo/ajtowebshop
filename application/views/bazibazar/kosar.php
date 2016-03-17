<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <section id="kosar_wrap" class="wrapper content_wrapper">   

        
        <h3>Kosár tartalma</h3>

        <div id="kosar_lista_wrap">
        
        
<?php if (isset($state) && $state == 'ures_kosar') : ?>

    <div id="ures_kosar"><?php echo $uzenet; ?></div>

<?php endif; ?>

<?php
        foreach ($this->cart->contents() as $items) : 
            $file_url = $this->product_model->get_product_field($items['id'], 'file_1_url');
            $thumb = thumb_name(TERMEKLISTA_THUMB_WIDTH, $file_url);
            $url_string = $this->product_model->get_product_field($items['id'], 'url_string');
            $short_desc = ucfirst($this->product_model->get_product_field($items['id'], 'short_description'));
            
            if (empty($url_string)) {
                $url_string = $items['id'];
            }
            
            $price = number_format($items['price'], 0, ',', '.') . " Ft";
                
                if (!empty($items['options'])) {
                    $options = '';
                    $i=0;
                        foreach ($items['options'] as $key => $value) {
                            if ($i > 0) echo ", ";
                            $options .= ucfirst($key) . ": " . $value;
                            $i++;
                        }

                    $short_desc = $options . " | " . $short_desc;
                }

            
            ?>


            <form id="<?php echo "cart_item_form_$items[id]"; ?>" method="post" action="">
            <div class="cart_item_wrap">
                <div class="kosar_kep_wrap">
                    <a href="/termekek/<?php echo $url_string; ?>">
                        <img src="/<?php echo PICTURE_UPLOAD_DIR . $thumb; ?>" alt="cart_item" />
                    </a>                        
                </div>
                <div class="cart_text">
                    <h4><?php echo $items['name'] . " / " . $price; ?><span class="perdb">/db</span></h4>
                    <p>
 
                    
                    <?php echo $short_desc; ?>
                    </p>
                
                    <table class="subtotal_table">
                        <tr>
                            <td>
                                <label>Mennyiség:</label>
                            </td>
                            <td>
                                <input type="number" class="qty_inp" name="qty" onchange="$(this).closest('form').submit();" value="<?php echo $items['qty']; ?>" /> 
                            </td>
                            <td class="subtotal">
                                <?php echo number_format($items['subtotal'], 0, ',', '.') . " Ft"; ?>
                            </td>                                
                            <td class="torles_gomb">
                                <input type="submit" name="call_just_this_main_function" value="Törlés" />
                            </td>                                
                        </tr>
                    </table>
                    
                    

                </div>

            </div>    
            <input type="hidden" name="call_main_function" value="updateCart" />
            <input type="hidden" name="rowid" value="<?php echo $items['rowid']; ?>" />
            <input type="hidden" name="product_id" value="<?php echo $items['id']; ?>" />

<?php 
            echo form_close(); 

        endforeach; 

?>
                <?php if (!isset($state) || $state != 'ures_kosar') : ?>

            <a id="penztarhoz" class="altalanos_gomb piros_gomb" href="/penztar">Tovább a pénztárhoz</a>

                <?php endif; ?>
    
        </div>
        
