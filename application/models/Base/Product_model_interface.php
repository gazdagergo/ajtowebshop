<?php

interface Product_model_interface {
    
    public function get_sku($product_id); 
    
    public function get_stock($product_id); 
    
    public function modify_attributes_by_sku($product_details, $sku);    
}