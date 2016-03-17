<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

    <section id="product_wrap" class="main-wrap wrapper">

        <div id="productlist" class="fokeret kek">

            <div id="productlist-header">
                <h3><?php 
                    if (isset($oldalcim)) {
                        echo $oldalcim;
                    } else {
                        echo $this->product_model->get_current_category(); 
                    }
                    
                    ?></h3>
                <?php 
                    $subcategory = $this->product_model->get_current_subcategory();
                    if ($subcategory) echo "<h4>$subcategory</h4>"; 
                ?>
       

                <!--div class="szuresek">
                    <-?php echo $szuresek; ?>
                </div-->

            </div>


            <div class="clear"></div>

            <div class="productlist-body">

                <?php if (isset($uzenet)) echo "<p class='uzenet'>$uzenet</p>"; ?>
                
                
    <?php 
    $i = 0;
    $group_ids = array();
    $product_class_name = '';

    foreach ($products as $product) : 

//a_print($product);


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
                
                
        if ($product->price < 0) {
            $postprice = '-tól';        
            $product->price *= -1;   
        }
                
        if ($product->price != 0) {
            $price = number_format($product->price, 0, ',', '.') . " Ft" . $postprice;
        } else {
            $price = '';
        }
                

    ?>

                
                
                <div class="product hide" itemtype="http://schema.org/ItemList">
                    <a itemprop="url" href="/termekek/<?php echo $url; ?>">
                        <div itemprop="itemListElement" itemtype="http://schema.org/Product">
                            <div class="list-img-wrap" style="<?php echo "min-width: " . TERMEKLISTA_THUMB_WIDTH . "px; min-height: " . TERMEKLISTA_THUMB_HEIGHT . "px" ?>">
                                <img class="product_thumb" alt="<?php echo $product->name; ?>" itemprop="image" data-src="<?php echo $thumb; ?>" />
                            </div>
                            <div class="price_wrap">
                                <span itemprop="name"><?php echo $product->name; ?></span>
                                <span itemprop="price"><?php echo $price; ?></span>
                                <span itemprop="description" class="product-desc"><?php echo $product->short_description; ?></span>
                            </div>
                        </div>
                        <div class="szurke"></div>
                    </a>


                    <form action="" method="post">
                        
                        <?php echo $this->product_model->print_product_cart_form_hiddens($product); ?>
                        
                        <input type="hidden" name="qty" value="1" />
                        
        <?php $options = $this->product_model->get_product_options($product->id); 
            if ($options) :            
                        
        ?>
                        <a class="opcio-valasztas" href="/termekek/<?php echo $url; ?>">Típus választás</a>
                

        <?php elseif ($product->price > 0 AND $product->stock > 0) :  ?>

                        <input class="lista_kosarba_gomb kosarba_gomb" type="submit" value="Kosárba" />
        <?php endif; ?>

                    </form>

                </div>

        <?php
            $last_product_id = $product->id;
            endforeach; 
        ?>

            </div>


        </div>
    </section>

