<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>
 
<?php


    $loggedin = $this->authentication->is_loggedin();
    $szerkesztes = $this->input->post('szerkesztes');

    $edited_product_id = -1;


    if (isset($szerkesztes) AND $szerkesztes == 'Képszerkesztés') {
        $edited_product_id = $this->input->post('edited_product_id');
    };
    

    if ($this->input->post('kepformazas_mentes') == 'Ment') {
        
        $this->admin_model->edit_picture();
        
    }


?>

<?php
    if (isset($szerkesztes) AND $szerkesztes == 'Képszerkesztés') {
    $this->admin_model->navigation_proba($edited_product_id);
    }

?>    


    <section id="product_wrap" class="wrapper <?php if ($loggedin) echo 'pad-bot'; ?>">    
    <div class="product_row">
        
    <?php 
    $i = 0;
    $group_ids = array();

    foreach ($products as $product) : 

        $product_class_name = '';
        
        if ($product->product_group == NULL) {
            $thumb_name = thumb_name(TERMEKLISTA_THUMB_WIDTH, $product->file_1_url);
            $thumb = "/" . PICTURE_UPLOAD_DIR . $thumb_name;
            $url = empty($product->url_string) ? $product->id : $product->url_string;
            $edit_image_name = $product->file_1_url;
            $postprice = '';            
            
        } 
        else if (in_array($product->product_group, $group_ids)) {
            continue;
        }
        else {
            $group_id = $product->product_group;
            $group_ids[] = $group_id;   
            $group = $this->product_model->get_group_details($group_id);
            
            $thumb_name = thumb_name(TERMEKLISTA_THUMB_WIDTH, $group->file_url);
            $thumb = "/" . PICTURE_UPLOAD_DIR . $thumb_name;
            $url = empty($product->url_string) ? $product->id : $product->url_string;
            $product->name = $group->group_name;
            $product->short_description = $group->num_members . " termék";      
            $product->price = $group->min_price;
            $edit_image_name = $group->file_url;
            $postprice = '-tól';
            $product_class_name = "product-group";

        }

        if ($edited_product_id == $product->id) $product_class_name .= " szerkesztett";
        if ($loggedin) $thumb = $thumb . "?" . rand();   
        if ($product->price >0) {
            $price = number_format($product->price, 0, ',', '.') . " Ft" . $postprice;
        } else {
            $price = '';
        }

        
    ?>


    
            <div class="product <?php echo $product_class_name;?>" itemtype="http://schema.org/ItemList" style="<?php 
                    echo "min-width: " . TERMEKLISTA_THUMB_WIDTH . "px; min-height: " . TERMEKLISTA_THUMB_HEIGHT . "px;";
                                                                         ?>">        
                <a itemprop="url" href="/termekek/<?php echo $url; ?>">
                    <div itemprop="itemListElement" itemtype="http://schema.org/Product">       
                        <?php if ($edited_product_id == $product->id) : ?>
                            <div id="edit_wrap">
                                <div id="img_wrap">
                                    <img id="edited_img" src="/<?php echo PICTURE_UPLOAD_DIR . $edit_image_name; ?>" />  
                                </div>
                            </div>
                        <?php else : ?>
                            <img class="product_thumb" alt="<?php echo $product->name; ?>" itemprop="image" data-src="<?php echo $thumb; ?>"/>
                        <?php endif; ?>
                        <div class="price_wrap">
                            <span itemprop="name"><?php echo $product->name; ?></span>
                            <span itemprop="description"><?php echo $product->short_description; ?></span>
                            <span itemprop="price">
                                <?php echo $price; ?>
                            </span>
                        </div>    
                    </div>
                </a>
                

    <form method="post">
        <input type="hidden" name="call_main_function" value="addCart" />
        <input type="hidden" name="name" value="<?php echo $product->name; ?>" />
        <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
        <input type="hidden" name="price" value="<?php echo $product->price; ?>" />
        <input type="hidden" name="qty" value="1" />
        
        <?php if ($product->price > 0 AND $product->stock > 0) : ?>
        <input class="lista_kosar_gomb" type="submit" value="Kosárba" />
        <?php endif; ?>
        
    
    </form>
        <?php         
            if ($loggedin && !strpos($thumb_name, 'noimage')) {
                    $this->admin_model->print_termekszerkesztes_gomb($product->id);
                    $this->admin_model->print_kepszerkesztes_gomb($product->id);
                
                if ($edited_product_id == $product->id) {
                    $this->admin_model->print_kepszerkesztes_form($product);
                }
            }
                ?>                
            </div>
        <?php

        $i++;
            if ($i % 3 == 0) {
                echo '</div><div class="product_row">';
            }

        $last_product_id = $product->id;
        
    endforeach; ?>

        </div>
            

    </section>


<script>
    <?php 

    if ($loggedin) {
        
        echo "
        $('.product').fadeIn();
        
        ";
    }


    ?>
</script>        
        


    
