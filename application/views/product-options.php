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
                       ?>" />
                    
                <input type="hidden" name="current_uri" value="<?php echo uri_string(); ?>"/>
                <input type="hidden" name="attribute_name" value="<?php echo $option_group_name; ?>" />
                <input type="hidden" name="option_nr" value="<?php echo $i-2; ?>" />
                    
                <div class="select-style termekopciok">
                        
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