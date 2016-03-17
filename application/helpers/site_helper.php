<?php

if (!function_exists('thumb_name')) {
    
    function thumb_name($res, $filename, $write = NULL) {

        if (empty($filename) AND $write == NULL) {
            return "noimage-$res.png";   
        }
        
        
        $parts = explode('.', $filename);
        $last = array_pop($parts);
        $parts = array(implode('.', $parts), $last);
        $thumbname = $parts[0]; 
        
        $thumbname .= "-$res.";

        $reversedParts = explode('.', strrev($filename), 2);
        $thumbname .= strrev($reversedParts[0]);
        
        if (!file_exists(FCPATH . PICTURE_UPLOAD_DIR . $thumbname) AND  $write == NULL) return "noimage-$res.png"; 
        
        return $thumbname;
        

    }
}


if (!function_exists('price_format')) {
    
    function price_format($price) {
        return ($price == 0) ? '' : number_format(floor($price), 0, ',', '.'); 
    }
}


if (!function_exists('a_print')) {
    
    function a_print($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}
