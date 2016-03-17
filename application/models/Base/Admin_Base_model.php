<?php

class Admin_Base_model extends CI_Model {
    
    public $id_for_option;
    public $order_id;
    
 
    public function products() {
        $crud = new grocery_CRUD();
        $crud->set_language("hungarian");      
        $this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
        $crud
            ->set_table('products')
            ->set_theme('bootstrap')
            ;
        
        $StateInfo = $crud->getStateInfo();
        if (isset($StateInfo->primary_key)) {
            $product_id = $StateInfo->primary_key;
            
            $product_options = $this->db
                ->where('product_id', $product_id)
                ->get('product_options')
                ->result()
                ;
        }

        
        $product_attributes = $this->db
            ->get('product_attributes')
            ->result()
            ;
        
        $unset_columns = array('url_string', 'custom_postal_fee');
        $fields = array('name', 'short_description', 'long_description', 'price', 'stock', 'options', 'active', 'file_1_url', 'file_2_url', 'file_3_url', 'file_4_url', 'file_5_url', 'url_string', 'custom_postal_fee');
        
            foreach ($product_attributes as $attribute) {
                
                if ($attribute->active == 1) {
                    $fields[] = $attribute->col_name;
                    $crud->display_as($attribute->col_name, $attribute->display_name);                
                } else {
                    $unset_fields[] = $attribute->col_name;
                    $unset_columns[] = $attribute->col_name;
                }
            }
        
        $crud->unset_columns($unset_columns);
        $crud->unset_fields($unset_fields);
        
        $fields[] = 'Kategóriák';
        $fields[] = 'Alkategóriák';
        
        $crud
            //->fields($fields)
            ->display_as('file_1_url','Termék fotó')
            ->display_as('name','Termék neve')
            ->display_as('price','Ár')           
            ->display_as('stock','Készlet')
            ->display_as('short_description', 'Rövid leírás')                
            ->display_as('long_description', 'Hosszú leírás')                
            ->display_as('product_group', 'Összevont név')
            ->display_as('custom_postal_fee', 'Egyedi postázási ár')
            ->display_as('active', 'Aktív')
            ->set_field_upload('file_1_url',PICTURE_UPLOAD_DIR)
            ->set_field_upload('file_2_url',PICTURE_UPLOAD_DIR)
            ->set_field_upload('file_3_url',PICTURE_UPLOAD_DIR)
            ->set_field_upload('file_4_url',PICTURE_UPLOAD_DIR)
            ->set_field_upload('file_5_url',PICTURE_UPLOAD_DIR)    
            ->callback_before_upload(array($this,'rename_if_filename_exists'))
            ->callback_after_upload(array($this,'resize_after_upload'))
            ->callback_after_delete(array($this,'product_after_delete'))            
            ->add_action('Termék lemásolása', '/assets/grocery_crud/themes/flexigrid/css/images/copy.png', 'admin/duplicate')
            ->order_by('name','asc')
            ->change_field_type('active', 'true_false')
            ->set_relation_n_n('Kategóriák', 'products_categories', 'categories', 'product_id', 'category_id', 'category')
            ->set_relation_n_n('Alkategóriák', 'products_subcategories', 'subcategories', 'product_id', 'subcategory_id', 'subcategory')
            ->set_relation('product_group', 'product_groups', 'group_name')
            ->callback_field('url_string',function($value= ''){
              return $value;
            })
            ->callback_after_insert(array($this, 'product_callback_functions'))
            ->callback_after_update(array($this, 'product_url_string'))
            //->callback_add_field('options',array($this,'options_field_add_callback'))

            ;      
        
        $etc = array($unset_columns, $unset_fields);
        
        $crud = $this->customize(__FUNCTION__, $crud, $etc);
        $output = $crud->render();
        
        return $output;
           
    }
    
    
    
    public function product_after_delete($primary_key) {
        $this->db
            ->where('product_id', $primary_key)
            ->delete('product_options')
            ;
            
    }
    
/*    function options_field_add_callback() {
         return '<input type="text" maxlength="50" value="ddd" name="amount">';
    }*/
    
    
    public function categories() {
        $crud = new grocery_CRUD();
        $crud->set_language("hungarian");      
        $crud->set_table('categories')
            ->set_theme('bootstrap')
            ->display_as('category','Kategória')
            ->display_as('default_cat', 'Alapértelmezett')
           // ->callback_before_upload(array($this,'rename_if_filename_exists'))
          //->callback_after_upload(array($this,'resize_after_upload'))    
            ->callback_after_insert(array($this, 'cat_url_string'))
            ->callback_after_update(array($this, 'cat_url_string'))
            ->unset_columns('url_string')
            ->set_relation_n_n('Alkategóriák', 'categories_subcategories', 'subcategories', 'category_id', 'subcategory_id', 'subcategory')
		  ->columns('category', 'Alkategóriák', 'Rejtett')
		->fields('category', 'Alkategóriák', 'default_cat', 'url_string', 'hidden')
        ->field_type('default_cat', 'dropdown', array('1' => 'Igen', '0' => 'Nem'))
        ->callback_edit_field('url_string',function($value= ''){
              return $value;
        });        

        
        $crud = $this->customize($this->router->fetch_method(), $crud);

        $output = $crud->render();
        
        return $output;
           
    }
    
    
    public function orders($view = 'current') {
        $crud = new grocery_CRUD();
        
        $StateInfo = $crud->getStateInfo();
        if (isset($StateInfo->primary_key)) $this->order_id = $StateInfo->primary_key;
        
        $fields = array('id', 'total_goods', 'total_delivery', 'customer_details_id', 'address_id', 'bill_address_id', 'paying_method', 'delivery_mode', 'status', 'order_time', 'updated', 'items', 'annotation', 'postal_notes', 'user_notes');
        $columns = array('id', 'customer_details_id', 'total_goods', 'total_delivery', 'address_id', 'bill_address_id', 'paying_method', 'delivery_mode', 'status', 'order_time', 'updated', 'annotation', 'postal_notes', 'user_notes');
        
        $crud->set_language("hungarian")
            ->set_table('orders')
            ->set_theme('bootstrap')
            ->columns($columns)
            ->fields($fields)            
            
            ->field_type('total_goods', 'readonly')
            ->field_type('total_delivery', 'readonly')
            ->field_type('customer_details_id', 'readonly')
            ->field_type('id', 'readonly')
            ->field_type('address_id', 'readonly')
            ->field_type('bill_address_id', 'readonly')
            ->field_type('paying_method', 'readonly')
            ->field_type('delivery_mode', 'readonly')
            ->field_type('updated', 'readonly')
            ->field_type('order_time', 'readonly')
            ->field_type('items', 'readonly')
            ->field_type('postal_notes', 'readonly')
            ->field_type('user_notes', 'readonly')
            
            ->display_as('total_goods', 'Áruk összesen')
            ->display_as('total_delivery', 'Szállítási díj')
            ->display_as('customer_details_id', 'Ügyfél adatok')
            ->display_as('id', 'Rendelés száma')
            ->display_as('address_id', 'Szállítási cím')
            ->display_as('bill_address_id', 'Számlázási cím')
            ->display_as('paying_method', 'Fizetési mód')
            ->display_as('delivery_mode', 'Szállítási mód')
            ->display_as('status', 'Rendelés státusza')
            ->display_as('updated', 'Legutóbbi módosítás')
            ->display_as('order_time', 'Rendelés ideje')
            ->display_as('items', 'Rendelt termékek')
            ->display_as('annotation', 'Megjegyzés')
            ->display_as('postal_notes', 'Postázási infók')
            ->display_as('user_notes', 'Ügyfél megjegyzése')
            
            ->order_by('id', 'desc')
            
            ->unset_texteditor('annotation')
            
            
            ->callback_edit_field('total_goods',function($value= ''){
              return $value . ' Ft';
            })                 
            ->callback_edit_field('total_delivery',function($value= ''){
              return $value . ' Ft';
            })                 
            ->callback_edit_field('paying_method', array($this,'paying_method_callback'))            
            ->callback_edit_field('items', array($this,'items_callback'))            
            ->callback_column('paying_method', array($this,'paying_method_callback'))            
            ->callback_edit_field('delivery_mode', array($this,'delivery_mode_callback'))            
            ->callback_column('delivery_mode', array($this,'delivery_mode_callback'))            
            
            ->set_relation('customer_details_id', 'order_customers', '<strong>{name}</strong> <br/>E-mail: <strong>{email}</strong> <br/>Telefon: <strong>{phone}</strong>')
            ->set_relation('address_id', 'order_addresses', '<strong>{zip} {city}</strong> <br/><strong>{address}</strong>')
            ->set_relation('bill_address_id', 'order_bill_addresses', '<strong>{bill_company}<br>{bill_zip} {bill_city}</strong> <br/><strong>{bill_address}</strong>')            
            ->set_relation('status', 'order_status_list', 'text')
            ;
                
        if ($view == 'current' OR empty($view)) {
            $crud            
                ->where('status', 'ORDERED')
                ->or_where('status', 'BFR_PAY')
                ->or_where('status', 'SENT')
                ;   
        } 
        else
        if ($view == 'aborted') {
            $crud            
                ->where('status', 'ABRT_PAY')
                ;
        } 
        else
        if ($view == 'all') {
        }
        else
        if ($view == 'past') {
            $crud            
                ->where('status', 'DLIVERED')
                ;   
        } 
        
        
        $etc = array($fields, $columns);
        $crud = $this->customize(__FUNCTION__, $crud, $etc);

        $output = $crud->render();
        
        return $output;
           
    }


    function paying_method_callback($value = '', $primary_key = NULL) {
        $query = $this->db
            ->where('code', $value)
            ->where('field', 'paying_method')
            ->get('lists');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->text;
        } else {
            return '';
        }

    }
    
    
    function delivery_mode_callback($value = '', $primary_key = NULL) {
        $query = $this->db
            ->where('code', $value)
            ->where('field', 'delivery_mode')
            ->get('lists');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->text;
        } else {
            return '';
        }
    }
    
    
    function items_callback($value = '', $primary_key = NULL) {
        
        $items = $this->db
            ->where('order_id', $this->order_id)
            ->join('products', 'order_items.item_id = products.id', 'left')
            ->get('order_items')
            ->result();
            
        $TXT = "<table cellpadding='8'>";
        
        foreach ($items as $item) {
            $TXT .= "<tr>";
            $TXT .= "<td style='padding:6px;'>";
            $TXT .= "<a href='/admin/products/read/$item->id' target='_blank'>";
            $TXT .= "<img style='width: 50px;' src='/" . PICTURE_UPLOAD_DIR . $item->file_1_url. "' />";
            $TXT .= "</a>";
            $TXT .= "</td>";
            $TXT .= "<td style='padding:6px;'>";
            $TXT .= "<a href='/admin/products/read/$item->id' target='_blank'>";
            $TXT .= $item->name;
            $TXT .= "</a>";
            $TXT .= "</td>";
            $TXT .= "<td>";
            if (!empty($item->options)) 
                foreach (unserialize($item->options) as $key => $option) {
                    $TXT .= "$key: $option, ";
                    
                }
            $TXT .= "</td>";
            $TXT .= "<td style='text-align:right;padding:8px;'>$item->qty db</td>";
            $subtotal = $item->qty * $item->order_price;
            $TXT .= "<td style='text-align:right;'>$subtotal Ft</td>";
            $TXT .= "</a>";
            $TXT .= "</tr>";
               
        }
        
        $TXT .= "</table>";
        
        return $TXT;   
    }
    
    
    public function subcategories() {
        $crud = new grocery_CRUD();
        $crud->set_language("hungarian");      
        $crud->set_table('subcategories');
        $crud->display_as('subcategory','Alkategória')
                ->set_theme('bootstrap');                
        $crud->callback_after_insert(array($this, 'sub_url_string'));
        $crud->callback_after_update(array($this, 'sub_url_string'));      
        $crud->unset_columns('url_string');
        $crud->callback_edit_field('url_string',function($value= ''){
              return $value;
        });        
        
        $output = $crud->render();
        
        return $output;
           
    }
    
    
    public function product_groups() {
        $crud = new grocery_CRUD();
        $this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');        
        
        $crud->set_language("hungarian")
            ->set_table('product_groups')
            ->set_theme('bootstrap')
            ->set_field_upload('file_url',PICTURE_UPLOAD_DIR)            
            ->display_as('group_name','Összevon név')            
            ->display_as('file_url','Lista kép')     
            ->callback_before_upload(array($this,'rename_if_filename_exists'))
            ->callback_after_upload(array($this,'resize_after_upload'))
            ->unset_fields('id');
        
         $crud->callback_after_delete(array($this,'group_after_delete'));
        
        $output = $crud->render();
        
        return $output;
           
    }
    
    
    public function group_after_delete($primary_key) {
        $this->db
            ->where('product_group', $primary_key)
            ->update('products', array('product_group' => NULL));
    }
    
    
    function resize_after_upload($uploader_response,$field_info, $files_to_upload) {
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
        
        $this->image_moo
            ->load($file_uploaded)
            ->resize(600,800)
            ->save($file_uploaded,true);

        $thumb_name_1 = thumb_name(TERMEKLISTA_THUMB_WIDTH, $uploader_response[0]->name, 'write'); 
        $thumb_name_2 = thumb_name(TERMEK_IMAGE_WIDTH, $uploader_response[0]->name, 'write'); 
        $thumb_name_3 = thumb_name(RACS_THUMB_WIDTH, $uploader_response[0]->name, 'write'); 

        $thumbnail1 = $field_info->upload_path.'/'.$thumb_name_1;
        $thumbnail2 = $field_info->upload_path.'/'.$thumb_name_2;
        $thumbnail3 = $field_info->upload_path.'/'.$thumb_name_3;
        
        $this->image_moo
            ->load($file_uploaded)
            ->resize(TERMEKLISTA_THUMB_WIDTH,TERMEKLISTA_THUMB_HEIGHT)
            ->save($thumbnail1,true)
            ->resize(TERMEK_IMAGE_WIDTH, TERMEK_IMAGE_HEIGHT, true)
            ->save($thumbnail2,true)
            ->resize(RACS_THUMB_WIDTH, RACS_THUMB_HEIGHT, true)
            ->save($thumbnail3,true);

        return true;
    }    
    
    
    function sub_url_string($post_array,$primary_key) {

        $to_insert = array(
            "url_string" => underscore(convert_accented_characters($post_array['subcategory']))
        );

        $this->db->where('id', $primary_key);
        $this->db->update('subcategories',$to_insert);

        return true;
    }
    

    function cat_url_string($post_array,$primary_key) {

        $to_insert = array(
            "url_string" => underscore(convert_accented_characters($post_array['category']))
        );

        $this->db->where('id', $primary_key);
        $this->db->update('categories',$to_insert);

        return true;
    }


    function add_default_categories($post_array,$primary_key) {
        $default_categories = $this->db
            ->where('default_cat', 1)
            ->get('categories')
            ->result();
        
                foreach ($default_categories as $cat) {

                    $insert = array(
                        'id' => NULL, 
                        'product_id' => $primary_key, 
                        'category_id' => $cat->id)
                        ;

                    $this->db->insert('products_categories', $insert);

                }
        
        return true;
        
    }
    
    
    function batch_resize($dir) {
        $files = scandir(FCPATH.$dir);
                        
            foreach($files as $file) {
                if (in_array($file, array('.', '..', '.DS_Store'))) continue;
                
                if (in_array(substr($file, -8, 4), array('-600', '-356'))) continue;
                echo $file . "<br>";
                
                                

                $append = "-".TERMEK_IMAGE_WIDTH;

                $this->image_moo
                    ->load(FCPATH.$dir.'/'.$file)
                    ->resize(TERMEK_IMAGE_WIDTH, TERMEK_IMAGE_HEIGHT)
                    ->save_pa($prepend="", $append=$append, $overwrite=FALSE);

                
                $append = "-".TERMEKLISTA_THUMB_WIDTH;

                $this->image_moo
                    ->load(FCPATH.$dir.'/'.$file)
                    ->resize_crop(TERMEKLISTA_THUMB_WIDTH, TERMEKLISTA_THUMB_HEIGHT)
                    ->save_pa($prepend="", $append=$append, $overwrite=FALSE);


            }   
        
    }
    
    
    function print_kepszerkesztes_gomb($product_id) {
        echo form_open('', array('class' => 'kepszerkesztes', 'method' => 'post'));                
        echo form_input(array('type' => 'submit', 'name' => 'szerkesztes', 'value' => 'Képszerkesztés'));
        echo form_hidden(array('edited_product_id' => $product_id));
        echo form_close();        
        
    }
    
    
    function print_kepszerkesztes_form($product, $edit_image_name) {
        //$edit_image_name = $product->file_1_url;    
        $thumb_name = thumb_name(TERMEKLISTA_THUMB_WIDTH, $edit_image_name);        
        $imagesize = getimagesize(FCPATH.PICTURE_UPLOAD_DIR.$edit_image_name);

        $translateX_val = -($imagesize[0] - TERMEKLISTA_THUMB_WIDTH) / 2;
        $translateY_val = ($imagesize[1] - TERMEKLISTA_THUMB_HEIGHT) / 2;
        $scale_val = round(min(TERMEKLISTA_THUMB_WIDTH / $imagesize[0], TERMEKLISTA_THUMB_HEIGHT / $imagesize[1]),2);

        echo form_open('', array(
            'id' => 'kepform', 
            'method' => 'post',
            'novalidate' => 'novalidate'
        ));
        echo form_label('Vízszintes igazítás: ', 'horizontal');
        echo form_input(array(
            'type' => 'number', 
            'name' => 'translateX', 
            'value' => $translateX_val, 
            'data-dim' => 'px'
            )) . "<br>";
        
        echo form_label('Függőleges igazítás: ', 'vertical');
        echo form_input(array(
            'type' => 'number', 
            'name' => 'translateY', 
            'value' => $translateY_val, 
            'data-dim' => 'px'
            )) . "<br>";
        
        echo form_label('Nagyítás: ', 'zoom');                
        echo form_input(array(
            'type' => 'number', 
            'name' => 'scale', 
            'value' => round($scale_val,1), 
            'data-dim' => '', 
            'step' => '0.02'
            )) . "<br>";
        
        echo form_label('Forgatás: ', 'rotate');                                
        echo form_input(array(
            'type' => 'number', 
            'name' => 'rotate', 
            'value' => '0', 
            'data-dim' => 'deg'
            ))."<br>";
        
        echo form_hidden(array('thumb_url' => $thumb_name, 
                               'orig_url' => $edit_image_name,
                                'thumb_width' => TERMEKLISTA_THUMB_WIDTH,
                                'thumb_height' => TERMEKLISTA_THUMB_HEIGHT,
                               'x1' => 0,
                               'y1' => 0,
                               'x2' => 0,
                               'y2' => 0,
                               'rotate' => 0,
                              ));

        
        echo form_submit('kepformazas_mentes', 'Ment');
        echo form_submit('kepformazas_mentes', 'Mégsem');

        echo form_close();        

    }
    
    
    function print_termekszerkesztes_gomb($id) {
        echo '<form class="termek_szerkesztes" action="/admin/products/edit/'.$id.'" target="_blank">';
        echo '<input type="submit" value="Termék szerkesztés" />';
        echo '</form>';

    }
    
    
    function edit_picture() {

        
        
        foreach ($this->input->post() as $key => $value) {
            $$key = $value;
        }
        
        $orig_path = FCPATH.PICTURE_UPLOAD_DIR.$orig_url;
        $image_size = getimagesize($orig_path);

        $hor_expand = 0;
        $ver_expand = 0;
        
        $rig = $image_size[0] - $x2;
        $bot = $image_size[1] - $y2;

        
           if ($rotate != 0) {
               
               $this->image_moo
                   ->load($orig_path)
                   ->set_background_colour("#FFFFFF")
                   ->resize($image_size[0] + 200, $image_size[1] + 200, true)
                   ->save(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_pre_rotate.jpg", true);

               
                $after_rotate = $this->image_moo
                    ->load(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_pre_rotate.jpg")
                    ->set_background_colour("#FFFFFF")
                    ->rotate(-$rotate)
                    ->save(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_rotate.jpg", true);
               
                $hor_expansion = $after_rotate->new_width - $image_size[0];
                $ver_expansion = $after_rotate->new_height - $image_size[1];
               
                $rx1 = $hor_expansion / 2;
                $ry1 = $ver_expansion / 2;
                $rx2 = $after_rotate->new_width - $hor_expansion / 2;
                $ry2 = $after_rotate->new_height -  $ver_expansion / 2;

                $this->image_moo
                    ->load(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_rotate.jpg")
                    ->crop($rx1,$ry1,$rx2,$ry2)
                    ->save(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_rotate_crop.jpg", true);
               
                $orig_path = FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_rotate_crop.jpg";
               
            }

            if ($x1 < 0 OR $rig < 0) {
                $hor_expand = abs(min($x1, $rig));
            }
        
        
            if ($y1 < 0 OR $bot < 0) {
                $ver_expand = abs(min($y1, $bot));
            }

        
            if ($hor_expand != 0 OR  $ver_expand != 0) {
        
        
                $new_width = $image_size[0] + $hor_expand * 2;
                $new_height = $image_size[1] + $ver_expand * 2;

                $this->image_moo
                    ->load($orig_path)
                    ->set_background_colour("#FFFFFF")
                    ->resize($new_width, $new_height,TRUE)
                    ->save(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_expand.jpg", true);

                $orig_path = FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_expand.jpg";
                
                $x1 += $hor_expand;
                $y1 += $ver_expand;
                $x2 += $hor_expand;
                $y2 += $ver_expand;                    

            }

        
        
        $this->image_moo
            ->load($orig_path)
            ->crop($x1,$y1,$x2,$y2)
            ->save(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_crop.jpg", true);
        
 
        
        $this->image_moo
            ->load(FCPATH.PICTURE_UPLOAD_DIR."TEMP/temp_crop.jpg")
            ->resize_crop($thumb_width,$thumb_height)
            ->save(FCPATH.PICTURE_UPLOAD_DIR.$thumb_url, true);

  
    }
    
    
    public function navigation_proba($id) {
        
        return false;
    
        
/*        
    $this->db->where('id', $id);
    $row  = $this->db
        ->get('products')
        ->row();   
        
    $thumb = $row->file_1_url;
    $imgSrc = PICTURE_UPLOAD_DIR.$thumb;

    
        
        
    echo '<style>
        #proba {
            position: fixed;
            z-index: 10;
            top: 44px;
            border: black solid 1px;
            box-shadow: 0 0 50px rgba(0,0,0,.5);
            overflow:hidden;
        
        }
        
        #thumbdiv {
            border: 1px solid blue;
            position: absolute;
        }
        
        </style>
        ';
        
        
        
        
    echo '<div id="proba">';
    echo '<img src="/'.$imgSrc.' " />';   
        echo '<div id="thumbdiv"></div>';
        echo '</div>';*/
        
    }
    
    
    public function loadtemp() {

       $this->image_moo
           ->load(FCPATH.PICTURE_UPLOAD_DIR."source.jpg")
           ->crop(20,20,80,80)
           ->load_temp()
           ->resize(100, 100)
           ->save(FCPATH.PICTURE_UPLOAD_DIR."result.jpg", true);

        echo "aaa";
    }
    
    
    public function product_options($product_id = NULL) {
        
        $this->id_for_option = $product_id;
        
        $crud = new grocery_CRUD();
        $this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
        
        $fields = array('attribute_name', 'option_text', 'file_url', 'default_opt',  'sku_string');
        
        if ($product_id != NULL) {
            $crud
                ->where('product_id', $product_id)
                ->columns('attribute_name', 'option_text', 'file_url', 'default_opt', 'sku_string')
                ->fields($fields)
                ->display_as('attribute_name', 'Tulajdonság neve')
                ->display_as('option_text', 'Tulajdonság értéke')
                ->display_as('default_opt', 'Alapértelmezett')
                ->display_as('sku_string', 'Cikkszám-részlet')
                
                ;
        }
        
        
        $crud->set_language("hungarian")
            ->set_lang_string('form_inactive','nem') 
            ->set_lang_string('form_active','igen')               
            ->set_field_upload('file_url',PICTURE_UPLOAD_DIR)
            ->set_theme('bootstrap')
            ->set_table('product_options')
            ->set_relation('product_id', 'products', 'name')
            ->callback_after_insert(array($this, 'callback_after_option_insert'))        
            ->callback_after_update(array($this, 'option_url_string'))     
            ->callback_before_upload(array($this,'rename_if_filename_exists'))
            ->callback_after_upload(array($this,'resize_after_upload'))
            ->change_field_type('default_opt', 'true_false')
            ;
        
        $crud = $this->customize(__FUNCTION__, $crud, $fields);
        $output = $crud->render();
        
        return $output;
                   
    }
    
    
    function callback_after_option_insert($post_array,$primary_key) {
        //insert_product_id_to_option
        $this->db
            ->where('id', $primary_key)
            ->update('product_options', array('product_id' => $this->id_for_option));

        $this->option_url_string($post_array,$primary_key);
        
        return true;
    }
    
    
    function option_url_string($post_array,$primary_key) {
        
        $url_string = underscore(convert_accented_characters($post_array['option_text']));
        $url_string = str_replace('/', '_per_', $url_string);
        //option_url_string
        $to_update = array(
            "url_string" => $url_string
        );
        
        $this->db->where('id', $primary_key);
        $this->db->update('product_options',$to_update);
        
        return true;
        
    }
    
    
    function rename_if_filename_exists($files_to_upload,$field_info) {

        
        foreach ($files_to_upload as $file) {

            $file_name = trim(basename(stripslashes($file['name'])), ".\x00..\x20");
            $file_name = preg_replace("/([^a-zA-Z0-9\.\-\_]+?){1}/i", '-', $file_name);
            $file_name = str_replace(" ", "-", $file_name);
            $file_name = strtolower($file_name);
    
            
                $numRows = $this->db
                    ->where('file_1_url', $file_name)
                    ->or_where('file_2_url', $file_name)
                    ->or_where('file_3_url', $file_name)
                    ->or_where('file_4_url', $file_name)
                    ->or_where('file_5_url', $file_name)
                    ->get('products')
                    ->num_rows()
                    ;
            
                $numRows2 = $this->db
                    ->where('file_url', $file_name)
                    ->get('product_options')
                    ->num_rows()
                    ;
                    
                $numRows3 = $this->db
                    ->where('file_url', $file_name)
                    ->get('product_groups')
                    ->num_rows()
                    ;
                    
            
    
        if ($numRows + $numRows2  + $numRows3 > 0) {
            return "A $file[name] fáj már létezik. Kérjük, adjon meg másik fájnevet";   
        }

        }
        
        

    }
    
    
    public function textpages() {
        
        $crud = new grocery_CRUD();
        $crud
            ->set_language("hungarian")
            ->set_table('textpages')
            ->set_theme('bootstrap')
            ->display_as('header', 'Főcím')
            ->display_as('html', 'Tartalom')
            ->display_as('url', 'Hivatkozás')
            ->display_as('codes', 'Használható mezők:')
            ->unset_columns('html')
            ->callback_after_insert(array($this, 'textpage_url_string'))
            ->callback_after_update(array($this, 'textpage_url_string_update'))     
            
            ->fields('header', 'html', 'codes', 'url')
            
            ->callback_field('codes',array($this,'field_callback_codes'));
            
            
            ;
        
        $output = $crud->render();
        
        return $output;
           
        
    }
    
    
    public function field_callback_codes() {
        $this->load->model('etc_model');
        return $this->etc_model->get_html_codes();
    }

    
    function textpage_url_string($post_array,$primary_key) {

        $url = underscore(convert_accented_characters($post_array['header']));
        
        $query = $this->db
            ->where('url', $url)
            ->get('textpages')
            ;
        
        if ($query->num_rows() > 0) $url .= '_' . $primary_key;

        $to_insert = array(
            "url" => $url
        );
        
        
        $this->db->where('id', $primary_key);
        $this->db->update('textpages',$to_insert);

        return true;
    }
    
    
    function textpage_url_string_update($post_array,$primary_key) {

        $url = underscore(convert_accented_characters($post_array['header']));
        
        $query = $this->db
            ->where('url', $url)
            ->get('textpages')
            ;
        
            if ($query->num_rows() > 0) {
                $url .= '_' . $primary_key;

                $to_insert = array(
                    "url" => $url
                );

                $this->db->where('id', $primary_key);
                $this->db->update('textpages',$to_insert);
            }
        
        return true;
    }
    
    
    public function product_callback_functions($post_array,$primary_key) {
        if ($this->product_url_string($post_array,$primary_key) AND
            $this->add_default_categories($post_array,$primary_key))
            return true;
    }
    
    
    public function print_header() {
        
        $urls = array(
            'categories' => 'Kategóriák',
            'products' => 'Termékek',
            'subcategories' => 'Alkategórák',
            'orders' => 'Megrendelések',
            'textpages' => 'Szöveges oldalak',
            'product_groups' => 'Termék összevonások',
            'attribute_by_sku' => 'Egyedi termékparaméterek',
            'opciok' => 'Opciók',            
            
            );
        
        
        $suburls = array(
            'current'=> 'aktív megrendelések',
            'aborted'=> 'megszakított rendelések',
            'all'    => 'összes rendelés',
            'past'   => 'leszállított rendelések',  
            'edit'   => 'szerkesztés',
            'add'    => 'új felvitel',
            );
        
        if (key_exists($this->uri->segment(2), $urls)) echo '<a href="/admin/'.$this->uri->segment(2).'">' . $urls[$this->uri->segment(2)] . '</a>';   
        if (key_exists($this->uri->segment(3), $suburls)) echo ' <span class="subheader">| ' . $suburls[$this->uri->segment(3)] . '</span>';   
        
        $subname_array = array('opciok' => 'opciók', 
                               'attribute_by_sku' => 'Egyedi paraméterek',
                              );
        
        foreach ($subname_array as $url => $subname) {
        
            if ($this->uri->segment(2) == $url AND $this->uri->segment(3)) {
                $product_name = $this->db
                    ->where('id', $this->uri->segment(3))
                    ->get('products')
                    ->row()
                    ->name
                    ;

                echo " <span class='subheader'>| $product_name</span>";
            }
        }
        
    }
    
    
    public function sliders() {
        $crud = new grocery_CRUD();
        $this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png');
        

        $crud->set_language("hungarian")
            ->set_theme('bootstrap')
            ->set_table('sliders')
            ->change_field_type('active', 'true_false')
            
            ->set_lang_string('form_inactive','nem') 
            ->set_lang_string('form_active','igen')               
            ->set_field_upload('file_url',PICTURE_UPLOAD_DIR)
            
            ->display_as('gallery', 'Galéria neve')
            ->display_as('active', 'Bekapcsolva')
            ->display_as('file_url', 'Kép')
            ->display_as('href', 'Hivatkozás')
                        
            ;
        
        $output = $crud->render();
        
        return $output;        
    }
    
    
    public function attribute_by_sku($product_id) {
        $query = $this->db
            ->where('id', $product_id)
            ->get('products')
            ;
        
        $sku = '';
        
        if ($query->num_rows() > 0)
            $sku = $query->row()->sku;
        
        $crud = new grocery_CRUD();
        $crud->set_language("hungarian")
            ->set_theme('bootstrap')
            ->set_table('product_attribute_sku')
            ->set_relation('attribute', 'product_attributes', 'display_name')
            
            ->like('sku', $sku)
            
            ->display_as('sku', CIKKSZAM)
            ->display_as('attribute', 'Tulajdonság')
            ->display_as('attribute_value', 'Érték')
            
            ->required_fields('attribute', 'sku', 'attribute_value');    
            ;
            
        $output = $crud->render();
        
        return $output;        
            

    }
    
    
               

}


