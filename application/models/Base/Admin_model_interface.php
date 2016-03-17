<?php

interface Admin_model_interface {
    
    function product_url_string($post_array, $primary_key);
    
    function customize($method, $crud);

}