<?php

class Product_Base_model extends CI_Model {
    
 
    public function get_products($kategoria = NULL, $alkategoria = NULL, $kereses = NULL) {
        
        $product_fields = '';

            foreach ($this->db->list_fields('products') as $col_name) {
                $product_fields .= 'products.' . $col_name . ',';

            }
                
            if (!empty($kategoria)) {

                $query_by_category = $this->db
                    ->select($product_fields)
                    ->join('products_categories', 'products.id = products_categories.product_id', 'left')
                    ->join('categories', 'products_categories.category_id = categories.id', 'left')
                    ->like('categories.url_string', $kategoria, 'none')
                    ->where('active', 1)
                    ->get('products');
    
                $query_by_subcategory = $this->db
                    ->select($product_fields)                
                    ->join('products_subcategories',   'products.id                            = products_subcategories.product_id',           'left')
                    ->join('categories_subcategories', 'products_subcategories.subcategory_id  = categories_subcategories.subcategory_id',     'left')
                    ->join('categories',               'categories_subcategories.category_id   = categories.id',                               'left')
                    ->like('categories.url_string', $kategoria, 'none')
                    ->where('active', 1)
                    ->get('products');
                
                
                $objects = array_merge($query_by_category->result(), $query_by_subcategory->result());
                
                return array_filter($objects,array($this,'unique_obj'));                
                
            } else if (!empty($alkategoria)) {

                $query = $this->db
                    ->select($product_fields)
                    ->join('products_subcategories', 'products.id = products_subcategories.product_id', 'left')
                    ->join('subcategories', 'products_subcategories.subcategory_id = subcategories.id', 'left')
                    ->like('subcategories.url_string', $alkategoria, 'none')                    
                    ->where('active', 1)                
                    ->get('products');
                return $query->result();
                
                
            } else if (!empty($kereses)) {
                
                $search_in = array('url_string', 'name', 'short_description',);
                $like_fields = array();
                
                foreach ($search_in as $field) $like_fields['products.'.$field] = $kereses;       
                $query = $this->db
                    ->select($product_fields)
                    ->group_start()
                    ->or_like($like_fields, 'both')                              
                    ->group_end()
                    ->where('active', 1)                
                    ->get('products');
                return $query->result();
                
            } else {
                $query = $this->db->get('products');
                return $query->result();
        
            }
        
        
    }
    

    public function get_product_field($product_id, $field) {
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        $row = $query->row();
        
        return $row->$field;
    }
    
    
    public function get_subcategories($category_id) {
        $query = $this->db
            ->where('category_id', $category_id)
            ->join('subcategories', 'categories_subcategories.subcategory_id = subcategories.id')
            ->order_by('url_string')
            ->get('categories_subcategories');
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    
    public function get_category_menu() {
        $query = $this->db
            ->where('hidden', 0)
            ->get('categories');   
            
        $categories  = array();
        
            foreach ($query->result() as $cat) {
                
                $subcategories = array();
                
                    if ($this->get_subcategories($cat->id) !== false) { 
                        $subcats = $this->get_subcategories($cat->id);
                        
                            foreach ($subcats as $subcat) {
                                $subcategories[] = array('name' => $subcat->subcategory, 'url' =>$subcat->url_string);
                            }
                        
                            
                    } else {
                        $subcategories = NULL;
                    };  
                
                $categories[] = array(
                    'category_id' => $cat->id,
                    'name' => $cat->category,
                    'url' => $cat->url_string,
                    'subcategories' => $subcategories
                );

                
            } 
        
        return $categories;


    }
    

    public function print_categories($id = NULL, $ob = FALSE, $sub = TRUE) {
        $menu = $this->get_category_menu();   
        
        $activeCat = $this->uri->segment(1);
        $activeSubcat = $this->uri->segment(2);
        
        if ($ob) ob_start();
        
        echo "<ul";
        
        if ($id != NULL) echo " id='$id'";
        
        echo ">";
        
            foreach ($menu as $category) {
                echo  '<li class="';
                
                    if (!empty($category['subcategories']) AND $sub) {
                        echo 'has_sub ';
                    }
                
                    if ($activeCat == $category['url']) {
                        echo 'active';   
                    }
                
                echo '"><a href="/'.$category['url'].'">';
                echo $category['name'];
                echo "</a>";
                    
                    if (!empty($category['subcategories']) AND $sub) {
                        echo '<ul class="sub">';
                            foreach ($category['subcategories'] as $subcategory) {
                                echo '<li class="';
                                    if ($activeSubcat == $subcategory['url']) {
                                        echo "active";
                                    }
                                echo '">';
                                echo "<a href='/$category[url]/$subcategory[url]'>";
                                echo $subcategory['name'];
                                echo "</a>";
                                echo "</li>";
                            }
                        echo "</ul>";
                    }
                    
                echo "</li>";
            }
        
        echo "</ul>";
        
        if ($ob) {
            $output = ob_get_clean();
            return $output;
        }

    }
    
    
    public function get_product_details($id) {
        $this->db->where('url_string', $id);
        $this->db->or_where('id', $id);
        $result = $this->db->get('products');
        return $result->row();
    }
    
    
    public function get_main_categories() {
        $query = $this->db->get('categories');   
        
        return $query->result();
            
    }
    
    
    public function get_hasonlo_termekek($product_url, $limit = 30) {
        
        $this->db->where('url_string', $product_url);
        $query = $this->db->get('products');
        
        if ($query->num_rows() == 0) return false;
        
        $product_id = $query->row()->id;
        
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('products_categories');

        if ($query->num_rows() == 1 AND $query->row()->category_id == MINDENUNK_CATEGORY_ID) return false;

        $this->db->group_start();
        
            foreach ($query->result() as $row) {
                if ($row->category_id == MINDENUNK_CATEGORY_ID) continue;
                if ($row->category_id == STILUSOK_CATEGORY_ID) continue;
                $this->db->or_where('category_id', $row->category_id);
            }
        
            if ($query->num_rows() == 0) $this->db->or_where(1);
        $this->db->group_end();
        
        $this->db->select('products.name, products.file_1_url, products.url_string, products.id')
            ->join('products', 'products_categories.product_id = products.id')
            ->group_by('products.id')
            ->limit($limit)    
            ->where('file_1_url !=', '')
            ->where('url_string !=', $product_url)
            ->order_by('rand()')
            ;
        
        $query = $this->db->get('products_categories');
        
        return $query->result();


    }
    

    public function get_group_details($group_id) {
        $group = $this->db->where('id', $group_id)
            ->get('product_groups')
            ->row();
        
        $members = $this->db
            ->select_min('price')
            ->where('product_group', $group_id)
            ->get('products')
            ->row();            
        
        $num = $this->db
            ->where('product_group', $group_id)
            ->from('products')
            ->count_all_results();

        
        //$num = $query->num_rows();
        
        $group->min_price = $members->price;
        $group->num_members = $num;
        

        return $group;
        
        
        
    }
    
    
    public function get_product_group_members($group_id) {
        
        if ($group_id != NULL){
            $query = $this->db
                ->select('short_description, id, url_string')
                ->where('product_group', $group_id)
                ->get('products');
            return $query->result();
        } else {
            return false;
        }
        
    }
    
        
    public function get_product_options($product_id) {

        
        $query = $this->db
            ->group_by('attribute_name')
            ->where('product_id', $product_id)
            ->get('product_options')
            ;
        
            if ($query->num_rows() > 0) {
                
                $result_arr = array();

                $attributes = $query->result();


                    foreach ($attributes as $attribute) {
                        
                        $result = $this->db
                            ->where('product_id', $product_id)
                            ->where('attribute_name', $attribute->attribute_name)
                            ->get('product_options')
                            ->result();

                        $result_arr[$attribute->attribute_name] = $result;

                        $objects = (object) $result_arr;

                       
                    }
                    return $objects;

            } else {
                return false;
            }
        
        
    }
    
    
    public function print_product_attributes($product_details) {
        
        $attributes = array();
        
        
        $product_attributes = $this->db
            ->get('product_attributes')   
            ->result()
            ;
        
        
            foreach ($product_attributes as $attribute) {

                ob_start();
                
                if (!empty($product_details->{$attribute->col_name})) {
                
                        if ($attribute->unit != NULL) {
                            echo "<span itemprop='$attribute->schema_name' ";
                            echo "itemscope itemtype='http://schema.org/QuantitativeValue'>";
                            echo "<span itemprop='value'>";
                            echo $product_details->{$attribute->col_name};
                            echo "</span>&thinsp;";
                            echo $attribute->unit;
                            echo "<meta itemprop='unitCode' content='$attribute->schema_unit'>";
                            echo "</span>";

                        } else {
                            echo "<span itemprop='$attribute->schema_name'>";
                            echo $product_details->{$attribute->col_name};
                            echo "</span>";
                        } 

                    $attributes[$attribute->schema_name] = ob_get_clean();
                    
                } else {
                    $attributes[$attribute->schema_name] = '';
                }
            } 
        
        return $attributes;
        
    }
    
    
    
    public function print_product_cart_form_hiddens($product, $options = false) {
     
        ob_start();
        echo "<input type='hidden' name='call_main_function' value='addCart' />";
        echo "<input type='hidden' name='name' value=' $product->name' />";
        echo "<input type='hidden' name='id' value='$product->id' />";
        echo "<input type='hidden' name='price' value='$product->price' />";
        echo "<input type='hidden' name='stock' value='$product->stock' />";
        
            if ($options) {


                $selected_options = $this->get_selected_options($options);    
                $i=0;
                foreach ($selected_options as $key => $value) {
                    $i++;
                    echo "<input type='hidden' name='option-name-$i' value='$key' />";
                    echo "<input type='hidden' name='option-value-$i' value='$value' />";
                }
                echo "<input type='hidden' name='option-number' value='$i' />";
            }

        $output = ob_get_clean();
        return $output;
    }
    
    
    public function unique_obj($obj) {
        static $idList = array();
        if(in_array($obj->id,$idList)) {
            return false;
        }
        $idList []= $obj->id;
        return true;
    }
    
    
    public function get_cart_product_qty($product_id, $sku = NULL) {
            foreach ($this->cart->contents() as $item) {
                
                if ($item['id'] == $product_id) {

                    if (array_key_exists(CIKKSZAM, $item['options'])) {
                        $sku_option = $item['options'][CIKKSZAM];
                    } else {
                        return $item['qty'];
                    }

                    if ($sku == '') return $item['qty'];
                    if ($sku_option == $sku) return $item['qty'];   
                }
                
            }

    }
    
    
    public function print_product_galery($product) {
        $uresek = 0;
        $galery = '';

            for ($i = 1; $i <= GALERIA_KEPEK; $i++) {

                    if (empty($product->{"file_".$i."_url"})) {
                        $uresek++;   
                        continue;
                    }
                $galery .= '<div style="min-width: '.TERMEKLISTA_THUMB_WIDTH.'px;">';
                $galery .= '<img src="/' . PICTURE_UPLOAD_DIR;
                $galery .= thumb_name(TERMEKLISTA_THUMB_WIDTH, $product->{"file_".$i."_url"});
                $galery .= '"  data-src="';
                $galery .= thumb_name(TERMEK_IMAGE_WIDTH, $product->{"file_".$i."_url"}); 
                $galery .= '" />';
                $galery .= '</div>';

            }

            if ($uresek < GALERIA_KEPEK - 1) return $galery;
            return '';
    }
 
    
    public function get_current_category(){
        $category_url = $this->uri->segment(1);
        
        $query = $this->db
            ->where('url_string', $category_url)
            ->get('categories');
            
            if ($query->num_rows() == 0) return false; 
            $res = $query->row();
        
        $category = $res->category;
        return $category;
        
    }
    
    
    public function get_current_subcategory(){
        
        $subcategory_url = $this->uri->segment(2);
        
        $query = $this->db
            ->where('url_string', $subcategory_url)
            ->get('subcategories');
        
        if ($query->num_rows() == 0) return false; 

            $res = $query->row();
            $subcategory = $res->subcategory;
            return $subcategory;
    }
    
    
    public function category_exists($category) {
        $query = $this->db
            ->where('url_string', $category)
            ->get('categories');
        
        if ($query->num_rows() > 0) {
            return true;   
        } else {
            return false; 
        }
            
    }
    

    public function get_selected_options($options) {
        $uri_segment = 3;    
        $selected_options = array();     
        
            foreach ($options as $option_group_name => $option_group) {
                foreach ($option_group as $option) {
                    if ($this->uri->segment($uri_segment) == $option->url_string) {
                        $selected_options[$option_group_name] = $option->option_text;
                    }

                }         
                $uri_segment++;                
            }
        
            return $selected_options;         
    }
    
    
    public function get_product_group_image($group_id = NULL) {
        
        $query = $this->db
            ->where('id', $group_id)
            ->get('product_groups')
            ;
        
        if ($query->num_rows() > 0) {
           $group = $query->row();
    
            if ($group->file_url != '') {
                return  $group->file_url;  
            }
        }
        
        $query = $this->db
            ->select('file_1_url')
            ->where('product_group', $group_id)
            ->get('products');            

            if ($group_id != NULL AND $query->result() > 0){
                $products = $query->result();
        
                foreach ($products as $product) {
                    if ($product->file_1_url != '') {
                       return $product->file_1_url;
                    }
                }
                
            }

        
            return '';
        
    }
    
    
    public function get_default_options_string($options) {
        $string = '';
        
        foreach ($options as $option_group) { 
            $first_opt = $option_group[0]->url_string;  
                
                $van_defalut = false;
                foreach ($option_group as $option) {
                    if (property_exists($option, 'default_opt') AND $option->default_opt == 1) {
                        $string .= $option->url_string;
                        $van_defalut = true;
                    }
                }
                if (!$van_defalut) $string .= $first_opt;   
            
            $string .= '/';
        }
        return $string;
        
    }
    
    
    public function get_option_price($product_id, $options = NULL) {
        
        if ($options == NULL) return 0;
        
        $option_price = 0;
        $selected_options = $this->get_selected_options($options);
        
            $product_options = $this->db
                ->where('product_id', $product_id)
                ->get('product_options')
                ->result()
                ;
                
            foreach ($selected_options as $key => $value) {
                foreach ($product_options as $product_option) {
                    if ($product_option->attribute_name == $key AND $product_option->option_text == $value)
                        $option_price += $product_option->option_price;

                }
            }
        
        return $option_price;
        
    }
    

    public function get_stock($product_id, $sku = NULL) {
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        $row = $query->row();
        return $row->stock;
        
    }    
    
}

