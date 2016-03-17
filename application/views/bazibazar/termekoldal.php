<?php defined('BASEPATH') OR exit( 'No direct script access allowed'); ?>



<?php  
    $stock = $product->stock > 0 ? 'InStock' : ' SoldOut';   

    $property_fields = array(
        array('dim_width',  'Szélesség',    'cm'),
        array('dim_height', 'Magasság',     'cm'),
        array('dim_length', 'Hosszúság',    'cm'),
        array('dim_depth',  'Mélység',      'cm'),
        array('dim_diagonal','Átmérő',      'cm'),
        array('att_weight',  'Súly',         'kg'),
        array('att_color',   'Szín'              ),
        array('att_material','Anyag'             ),
    ); 

?>


<section class="wrapper" id="product_wrapper">

    <div id="product_detail_wrap" itemscope itemtype="http://schema.org/Product">
        <div id="detail_wrap">
            <span itemprop="name"><?php echo $product->name; ?></span>
            <span itemprop="alternateName"><?php echo $product->short_description; ?></span>            
            <span itemprop="description">
                <?php echo $product->long_description; ?>
            </span> 
            
            <div id="itemprop-wrap">
            <?php 
                    foreach ($property_fields as $property) :
                    
                        if ($product->{$property[0]} != NULL) :
            ?>
            
          <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
              <span itemprop="name"><?php echo $property[1];?>:</span>
              <span itemprop="value"><?php echo $product->{$property[0]}; ?></span>
              <?php if (isset($property[2])) : ?>
              <span itemprop="unitText"><?php echo $property[2]; ?></span>
              <?php endif; ?>
          </div>      
                
            
            <?php 
                      endif;

                    endforeach; 
            ?>
            </div>
            
            
            
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <span itemprop="price" content="<?php echo $product->price; ?>"><?php echo price_format($product->price); ?></span><span itemprop="priceCurrency" content="HUF"><?php echo $product->price ? 'Ft' : ''; ?></span>
                <link itemprop="availability" href="http://schema.org/<?php echo $stock; ?>" />
            </div>

            <?php
                $email_share = "mailto:?subject=Bazi Bazár | Nézd meg ezt a terméket&body=".current_url();
                $pin_share = "http://pinterest.com/pin/create/button/?url=".current_url()."&media=".site_url().PICTURE_UPLOAD_DIR . thumb_name(TERMEK_IMAGE_WIDTH, $product->file_1_url)."&description=".$product->name;
            if (!empty($product->short_description)) $pin_share .= ", " . $product->short_description;
                $facebook_share = "http://www.facebook.com/sharer/sharer.php?u=#".current_url();
            ?>
            
            <div>
                <ul id="share_buttons">
                    <li><a href="<?php echo $facebook_share; ?>" target="_blank"><img src="/assets/images/fb_black.png" alt="share on Facebook" title="Megosztás Facebookon"/></a></li>
                    
                    
                    
                    <li><a href="<?php echo $pin_share; ?>" target="_blank"><img src="/assets/images/pin_black.png" alt="share on Pinterest" title="Megosztás Pinteresten" /></a></li>
                    <li><a href="<?php echo $email_share; ?>"><img src="/assets/images/email_black.png" alt="share via Email" title="Küldés emailben" /></a></li>
                </ul>
            </div>
            

                <?php if ($group_members != false) : ?>
                
                <form method="post" action="" class="valaszto_form">
                    
                    <input type="hidden" name="call_main_function" value="goToGroupMember">
                    
                    <div class="select-style-2" id="meretvalaszto">
                        
                        <select name="group_member">

                        <?php foreach ($group_members as $member) :
                            $url_string = empty($member->url_string) ? $member->id : $member->url_string; 
                         ?>

                        <option <?php

                                if ($this->uri->segment(2) == $member->url_string) echo "selected";

                                ?> value="<?php echo $member->url_string; ?>"><?php echo $member->short_description; ?></option>

                        <?php endforeach; ?>

                        </select>

                    </div>
                       
                </form>
                    
                
                <?php endif; ?>            
            
            
                <?php 
                    if ($options) :
                    
                    $selected_options = array();
                
                    $uri_segment = 3;
                    foreach ($options as $option_group_name => $option_group) :
            
                ?>
            
                <form method="post" action="" class="valaszto_form">
                    
                <input type="hidden" name="uri" 
                       value="/<?php 
                              for ($i = 1; $i <= $uri_segment-1; $i++) {
                                echo $this->uri->segment($i);
                                echo '/';
                              }
                       //echo $this->uri->segment(1) . '/' . $this->uri->segment(2); 
                       ?>" />
                <input type="hidden" name="attribute_name" value="<?php echo $option_group_name; ?>" />
                    
                <div class="select-style-2" id="szinvalaszto">
                        
                    <select name="product_option">
                            
                    <?php 
                        echo "<option selected disabled>". ucfirst($option_group_name)." választás</option>";
                        foreach ($option_group as $option) {
                            echo "<option ";
                            if ($this->uri->segment($uri_segment) == $option->url_string) {
                                echo "selected";
                                $selected_options[$option_group_name] = $option->option_text;
                                   
                            }
                            echo " value='{$option->url_string}'>{$option->option_text}</option>";
                            
                        }
                    ?>
                
                    </select>
                
                    </div>
            </form>
                <?php $uri_segment++; endforeach; endif; ?>
            
            
            <div class="clear"></div>
            
            
            
            <form method="post" id="menny_form">
                <input type="hidden" name="call_main_function" value="addCart" />
                <input type="hidden" name="name" value="<?php echo $product->name; ?>" />
                <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
                <input type="hidden" name="price" value="<?php echo $product->price; ?>" />
                <input type="hidden" name="stock" value="<?php echo $product->stock; ?>" />
                
            <?php $i=0; if ($options) : foreach ($selected_options as $key => $value) :  $i++; ?>
                        
                <input type="hidden" name="option-name-<?php echo$i; ?>" value="<?php echo $key; ?>" />
                <input type="hidden" name="option-value-<?php echo$i; ?>" value="<?php echo $value; ?>" />
    
                
            <?php endforeach; ?>
                
                <input type="hidden" name="option-number" value="<?php echo $i; ?>" />
                
            <?php endif; ?>
                
                
                <?php if ($product->price > 0 AND $product->stock > 0 AND $product->active) : ?>
                <input id="kosarba_gomb" type="submit" value="Kosárba" title="Kosárba helyezés" />
                
                <?php if ($product->stock > 1) : ?>
                <div id="menny_wrap">
                    <input class="menny_valt" type="button" value="-" />
                    <input id="menny_kosarba" name="qty" type="text" value="1" />
                    <input class="menny_valt" type="button" value="+" />
                </div>    
                <?php else : ?>
                    <input type="hidden" name="qty" value="1" />
                <?php endif; ?>
                
                <?php endif; ?>

            </form>

        </div>            

        <div id="prod_image_wrap">
            <div id="prodImage" >
                <img src="/<?php echo PICTURE_UPLOAD_DIR . thumb_name(TERMEK_IMAGE_WIDTH, $product->file_1_url); ?>" alt="<?php echo $product->name; ?>" />
            </div> 
            
            <img src="/assets/images/loading.gif" id="loadingImg" />
            
            <div id="product_gallery">
                
                <?php 

                $uresek = 0;
                $galery = '';

                for ($i = 1; $i <= GALERIA_KEPEK; $i++) {
                    
                        if (empty($product->{"file_".$i."_url"})) {
                            $uresek++;   
                            continue;
                        }
                    
                    $galery .= '<img src="/' . PICTURE_UPLOAD_DIR;
                    $galery .= thumb_name(TERMEKLISTA_THUMB_WIDTH, $product->{"file_".$i."_url"});
                    $galery .= '"  data-src="';
                    $galery .= thumb_name(TERMEK_IMAGE_WIDTH, $product->{"file_".$i."_url"}); 
                    $galery .= '" />';
    
                }

                if ($uresek < GALERIA_KEPEK - 1) echo $galery;

                ?>
            
            </div>
        </div>
        
        
    </div>

        
        <?php if ($hasonlok !== false) : ?>
            <div id="hasonlok_wrap">

            <h4>Hasonló termékeink</h4>
            <div id="hasonlok">

                    <?php                    

                        foreach ($hasonlok as $hasonlo) {

                            //if (empty($hasonlo->file_1_url)) continue;

                            echo '<a title="';
                            echo $hasonlo->name;
                            echo '" href="/termekek/';

                            echo $hasonlo->url_string == '' ? $hasonlo->id : $hasonlo->url_string;
                            echo '"><img src="/' . PICTURE_UPLOAD_DIR;
                            echo thumb_name(TERMEKLISTA_THUMB_WIDTH, $hasonlo->file_1_url);
                            echo '" /></a>';

                        } ?>

            </div>
    </div>

            <?php endif; ?>
            
    


</section>