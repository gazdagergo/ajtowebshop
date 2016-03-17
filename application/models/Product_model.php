<?php

require 'Base/Product_Base_model.php';
require 'Base/Product_model_interface.php';

class Product_model extends Product_Base_model implements Product_model_interface {
      
    
    public function get_stock($product_id, $sku = NULL) {

        $termek = $this->fx4_model->keszlet('', $sku);
        return $termek['stock'];
        
    }
    
    
    public function get_url_string_by_sku($sku) {
        $product_group = substr($sku, 0, 1);
        
        if ($product_group == 'A') {
        
        $sku_parts = array();
        $product_sku = substr($sku, 0, 4);        
        $sku_parts[] = substr($sku, 5, 2);
        $sku_parts[] = substr($sku, 7, 2);
        $sku_parts[] = substr($sku, 10, 1);
        $sku_parts[] = substr($sku, 11, 2);
        
        $sku_names = array('Minta', 'Szín', 'Nyitásirány', 'Méret');
        
        $product_row = 
        $this->db
            ->where('sku', $product_sku)
            ->get('products')
            ->row()
            ;
        
        $product_id = $product_row->id;
        $product_url = $product_row->url_string;
        
        $url_parts = array();
        $querytxt = '';
        
        $i = 0;
        foreach ($sku_parts as $sku_string) {
            $query =
                $this->db
                ->where('sku_string', $sku_string)
                ->where('product_id', $product_id)
                ->where('attribute_name', $sku_names[$i])
                ->get('product_options')
                ;
            
             //$querytxt .= $this->db->last_query() . '; ';
            
            if ($query->num_rows() > 0) {
                $url_parts[] = $query->row()->url_string;
                $van_pos = $query->row()->sku_pos == 0 ? false : true;
            }
    
            if ($van_pos) {
                $url_parts_bypos[$query->row()->sku_pos] = $query->row()->url_string;
            }
            
            $i++;
        }
            
        if ($van_pos) {


        }
            
        
        return $product_url . '/' . $url_parts[3].'/'.$url_parts[0].'/'.$url_parts[2].'/'.$url_parts[1];
            
        } else 
            if ($product_group == 'T') {
            
                $sku_parts = array();
                $product_sku = substr($sku, 0, 4);        
                $product_sub = substr($sku, 4, 2);


            $query = 
                $this->db
                ->where('sku', $product_sku . $product_sub)
                ->get('products')
                ;
            
            
            if ($query->num_rows() > 0) {
                return $query
                    ->row()
                    ->url_string
                    ;
            }
            
            
        $product_row = 
        $this->db
            ->where('sku', $product_sku)
            ->get('products')
            ->row()
            ;
        
        $product_id = $product_row->id;
        $product_url = $product_row->url_string;            
            
            $query =
                $this->db
                ->where('sku_string', $product_sub)
                ->where('product_id', $product_id)
                ->get('product_options')
                ;            
            
            if ($query->num_rows() > 0) 
                $sub_url = 
                $query
                ->row()
                ->url_string
                ;
            
            else {
                
                
            $query_0 =
                $this->db
                ->where('product_id', $product_id)
                ->where('sku_string', substr($product_sub, 0, 1))
                ->get('product_options')
                ;            
                
            $query_1 =
                $this->db
                ->where('product_id', $product_id)
                ->where('sku_string', substr($product_sub, 1, 1))
                ->get('product_options')
                ;            
                
                if ($query_0->num_rows() > 0 AND $query_1->num_rows() > 0) {
                    $sub_url_0 = 
                    $query_0
                    ->row()
                    ->url_string
                    ;

                    $sub_url_1 = 
                    $query_1
                    ->row()
                    ->url_string
                    ;

                    $sub_url = $sub_url_0 . '/' . $sub_url_1;

                }
            }
                
            
            
         return $product_url . '/' . $sub_url;   
            
            
        } else
            if ($product_group == 'B') {
        $sku_parts = array();
        $product_sku = substr($sku, 0, 4);        
        $sku_parts[] = substr($sku, 5, 2);
        $sku_parts[] = substr($sku, 7, 2);
        $sku_parts[] = substr($sku, 10, 1);
        $sku_parts[] = substr($sku, 11, 2);
        
        $sku_names = array('Szín', 'Beépítési méret', 'Nyitásirány', 'Szélesség');
        
        $product_row = 
        $this->db
            ->where('sku', $product_sku)
            ->get('products')
            ->row()
            ;
        
        $product_id = $product_row->id;
        $product_url = $product_row->url_string;
        
        $url_parts = array();
        $querytxt = '';
        
        $i = 0;
        foreach ($sku_parts as $sku_string) {
            if (empty($sku_string)) continue;
            $query =
                $this->db
                ->where('sku_string', $sku_string)
                ->where('product_id', $product_id)
               // ->where('attribute_name', $sku_names[$i])
                ->get('product_options')
                ;
            
             $querytxt .= $this->db->last_query() . ';<br> ';
            
            if ($query->num_rows() > 0) 
                $url_parts[] = 
                $query
                ->row()
                ->url_string
                ;
            
            $i++;
        }
        
/*
            a_print($sku_parts);
            a_print($url_parts);
*/
            
        $url = $product_url . '/';
        if (array_key_exists(3, $url_parts))
            $url .= $url_parts[3].'/';
        if (array_key_exists(1, $url_parts))
            $url .= $url_parts[1].'/';
        if (array_key_exists(2, $url_parts))
            $url .= $url_parts[2].'/';
        if (array_key_exists(0, $url_parts))
            $url .= $url_parts[0];
            
            
    
      return $url;            
            
            
        }

        
        
    }
    

    public function get_sku($product_id) {
        
        $sku_array = array();
        $van_pos = false;
        
        $sku = 
            $this->db
            ->where('id', $product_id)
            ->get('products')
            ->row()
            ->sku
            ;
        
        $options = explode('/', uri_string());
        array_shift($options);
        array_shift($options);
        
            foreach ($options as $option) {
                $query = $this->db
                    ->where('product_id', $product_id)
                    ->where('url_string', $option)
                    ->get('product_options')
                    ;
                if ($query->num_rows() > 0) {
                    $sku_array[] = 
                    $query
                    ->row()
                    ->sku_string
                    ;
            
                    $van_pos = $query->row()->sku_pos != 0 ? true : false;
                    
                    if ($van_pos)
                        $sku_array_bypos[$query->row()->sku_pos] = $query->row()->sku_string;
                }
                
            }
        
        if ($van_pos) {
            $sku_bypos = $sku;
            if (array_key_exists(7, $sku_array_bypos) AND
                array_key_exists(8, $sku_array_bypos)) { 
                $sku_bypos .= $sku_array_bypos[7] . $sku_array_bypos[8];
            } 
            else 
            if (array_key_exists(2, $sku_array_bypos) AND
                array_key_exists(3, $sku_array_bypos)) { 
                $sku_bypos .= '-' . $sku_array_bypos[2] . $sku_array_bypos[3];
            }
            
            if (array_key_exists(4, $sku_array_bypos)) { 
                $sku_bypos .= '-' . $sku_array_bypos[4];
            }

            if (array_key_exists(5, $sku_array_bypos)) { 
                $sku_bypos .= $sku_array_bypos[5];
            }
            
            if (array_key_exists(6, $sku_array_bypos)) { 
                $sku_bypos .= $sku_array_bypos[6];
            }
            
            return $sku_bypos;
        }
        
        $sorrend = NULL;
        
        if (substr($sku, 0, 1) == 'A') {
            $sorrend = array(1,3,2,0);
            $prefix_array = array('','-','-', '');
        }
        
        if (substr($sku, 0, 1) == 'T' AND sizeof($options) < 2) {
            $sorrend = array(1,3,2,0);
            $prefix_array = array('','-','-', '');
        }
        
        if (substr($sku, 0, 1) == 'T' AND sizeof($options) == 2) {
            $sorrend = array(3,2,0,1);
            $prefix_array = array('','','-', '');
        }
        
        if (substr($sku, 0, 1) == 'B') {
            $sorrend = array(3,0,1,2);
            $prefix_array = array('','-','', '-');
        }

        
        if ($sorrend != NULL) {
        
            
            foreach ($sorrend as $i) {
                if (array_key_exists($i, $prefix_array) AND array_key_exists($i, $sku_array))
                    $sku .= $prefix_array[$i];
                if (array_key_exists($i, $sku_array))
                    $sku .= $sku_array[$i];
            }
        } else {
            $sku .= implode($sku_array);
        }
        
        return $sku;

    }
    
    
    public function modify_attributes_by_sku($product_details, $sku) {
        
        $attributes = $this->db
            ->get('product_attributes')
            ->result()
            ;
        
            foreach ($attributes as $attribute) {
                $query = $this->db
                    ->where('sku', $sku)
                    ->where('attribute', $attribute->id)
                    ->get('product_attribute_sku')
                ;

                if ($query->num_rows() > 0) {
                    $val_by_sku = $query->row()->attribute_value;
                    $product_details->{$attribute->col_name} = $val_by_sku;
                }
            }
        
        
        return $product_details;
    }    
        
    
}

