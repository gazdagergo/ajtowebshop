<?php
defined('BASEPATH') or exit('Access denied');

class Etc_model extends CI_Model {
    
    
    private $code_change_array = array(
            'RENDELESZAM'           => 'order_id',          
            'MEGRENDELO'            => 'name',    
            'RENDELES_VEGOSSZEGE'   => 'total',   
            'PAYREFNO'              => 'payrefno',
            'RENDELES_DATUMA'       => 'date',  
            );
    
    function __construct() {
        parent::__construct();
    }

    
    
    public function html_codes($html, $data, $order_id = NULL) {
        
        if ($order_id != NULL) {
            $order_details = $this->order_model->get_all_order_detail($order_id);
            $data = json_decode(json_encode($order_details), true);
        }
        
        $codes = array();
        $values = array();        
        
            foreach ($this->code_change_array as $key => $array_index) {
                if (isset($data[$array_index])) {
                    $codes[] = "[" . $key . "]";
                    $values[] = $data[$array_index];
                }
            }

        
        return str_replace($codes, $values, $html);
        
    }    
    
    
    public function get_html_codes() {
     $output = '';
        
        foreach ($this->code_change_array as $key => $value) {
            $output .= "[$key] &nbsp; ";
        }
        
        return $output;
    }
    
    
    
    
}
    