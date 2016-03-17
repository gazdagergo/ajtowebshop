<?php

require 'Base/Admin_Base_model.php';
require 'Base/Admin_model_interface.php';

class Admin_model extends Admin_base_model implements Admin_model_interface {
    
    
    function product_url_string($post_array,$primary_key) {
        $base_string = $post_array['name'];
        
        $url_string = url_title(convert_accented_characters($base_string));
        
        if (is_numeric(substr($url_string,0,1))) $url_string = substr_replace($url_string, '_', 0, 0);
        
        $this->db->where('url_string', $url_string)
            ->where_not_in('id', array($primary_key)); 
        
        $query = $this->db->get('products');
        
            if ($query->num_rows() > 0) {
                $url_string = $url_string  . '_' . $primary_key;
            }
        
        $to_insert = array(
            "url_string" => $url_string
        );

        $this->db->where('id', $primary_key);
        $this->db->update('products', $to_insert);

        return true;
    }
    

    public function customize($method, $crud, $etc = NULL) {
        
        if ($method == 'categories') {

            $crud
                ->field_type('hidden', 'dropdown', array('1' => 'Igen', '0' => 'Nem'))
                ->display_as('hidden', 'Rejtett')
                
                ;
            
        }
        
        if ($method == 'products') {
            
            
            $unset_columns = $etc[0];
            $unset_fields = $etc[1]; 

            $unset_columns[] = 'stock';
            $unset_columns[] = 'price';
            $unset_columns[] = 'att_color';
            $unset_columns[] = 'att_material';
            $unset_columns[] = 'att_weight';
            $unset_columns[] = 'file_2_url';
            $unset_columns[] = 'file_3_url';
            $unset_columns[] = 'file_4_url';
            $unset_columns[] = 'file_5_url';
            $unset_columns[] = 'dim_width';
            $unset_columns[] = 'dim_height';
            $unset_columns[] = 'dim_width';
            $unset_columns[] = 'long_description';
            $unset_fields[] = 'stock';
            $crud
                ->field_type('stock', 'readonly')
                ->unset_fields($unset_fields)
                ->unset_columns($unset_columns)
                ->callback_field('price',function($value= ''){
                  return 'Az ár a készletező programból kerül automatikusan frissítésre.';
                })            
            ->callback_edit_field('sku', array($this,'sku_callback'))            
                
            ;
            
            
        }
        
        
        
        if ($method == 'orders') {
            
            $fields = $etc[0];
            $columns = $etc[1];
            
            $unset_columns = array(
                'postal_notes',
                'address_id', 
                'bill_address_id',
                'updated',
                'paying_method', 
                'delivery_mode',                
                );
            
            
            if(($key = array_search('postal_notes', $fields)) !== false) {
                unset($fields[$key]);
            }


            foreach ($unset_columns as $unset_col) {

                if(($key = array_search($unset_col, $columns)) !== false) {
                    unset($columns[$key]);
                }
            }
            
            $crud->fields($fields);
            $crud->columns($columns);

        }
        
        if ($method == 'product_options') {
            $fields = $etc;
            $fields[] = 'sku_pos';
            
            $crud
                ->display_as('sku_pos', 'Cikkszám részlet helye')
/*
                ->field_type('sku_pos','dropdown',
                    array('1' => '1', '2' => '2','3' => '3' , '4' => '4'))
*/
                ->fields($fields)
                ->callback_edit_field('sku_pos', array($this, 'option_sku_pos'))
                ->callback_add_field('sku_pos', array($this, 'option_sku_pos'))
                ;
            
        }

        
        
        return $crud;
    }
    

    function option_sku_pos($value = '', $primary_key = NULL) {
                                  
     $TXT = '<input id="field-sku_pos" name="sku_pos" value="'.$value.'" class="numeric form-control" maxlength="11" type="hidden">
     <style>
        #sku-pos-wrap {width:167px;border:gray 1px solid;position:relative;}
        #sku-pos-wrap div {background-color:rgba(0,0,0,.14);position:absolute;cursor:pointer;}
        #sku-pos-wrap div:hover {background-color:rgba(120, 128, 80, 0.55);}
        #sku-pos-wrap div.active {background-color:rgba(204, 232, 49, 0.78);}
        #sku-pos-wrap img {width: 100%;}      
        
        #pos-2 {width: 22px;height: 51px;top: 12px;left: 69px;}
        #pos-3 {width: 22px;height: 51px;top: 12px;left: 92px;}
        #pos-4 {width: 12px;height: 51px;top: 12px;left: 124px;}
        #pos-5 {width: 21px;height: 20px;top: 12px;left: 137px;}
        #pos-6 {width: 21px;height: 20px;top: 71px;left: 58px;}
        #pos-7 {width: 12px;height: 20px;top: 71px;left: 135px;}
        #pos-8 {width: 12px;height: 20px;top: 71px;left: 148px;}
     </style>
     
     <div id="sku-pos-wrap" >
     <img src="/assets/images/skupos.jpg" />
        <div id="pos-2" title="2" data-pos="2"></div>
        <div id="pos-3" title="3" data-pos="3"></div>
        <div id="pos-4" title="4" data-pos="4"></div>
        <div id="pos-5" title="5" data-pos="5"></div>
        <div id="pos-6" title="6" data-pos="6"></div>
        <div id="pos-7" title="7" data-pos="7"></div>
        <div id="pos-8" title="8" data-pos="8"></div>
     </div>
     
     <script type="text/javascript">
        $(document).ready(function(){
            pos = $(`#field-sku_pos`).val();
            $(`#pos-` + pos).addClass(`active`);

        });
     
        $(`#sku-pos-wrap div`).click(function(){
            $(this).siblings().removeClass(`active`);
            $(this).addClass(`active`);
            pos = $(this).attr(`data-pos`);
            $(`#field-sku_pos`).val(pos);
        });
     </script>
     
     ';
     
     return $TXT;
 }
    

    function sku_callback($value = '', $primary_key = NULL) {
        
  
     $TXT = '<input class="col-sm-8" id="field-sku" class="form-control" name="sku" value="'.$value.'" maxlength="64" type="text"><img src="/assets/images/skupos-1.jpg" />';
     
     return $TXT;
     

    }    
               

}


