<?php
defined('BASEPATH') or exit('Access denied');

class Unisec_szallito_model extends CI_Model {
 
    
    private $cs = 1; //csomagolas vastagsag
    private $paying_method, $delivery_mode;
    private $all_order_details;
    private $AFA = 1.27; 

    
    function __construct() {
        parent::__construct();   
        
        //$this->load->model('order_model');
        
        $this->order_id = $this->input->cookie('order_id');
        $this->all_order_details = $this->order_model->get_all_order_detail($this->order_id);
        $this->paying_method = $this->all_order_details->paying_method;
        $this->delivery_mode = $this->all_order_details->delivery_mode;
        $this->order_items = $this->order_model->get_order_items($this->order_id);
        $this->itemnum = $this->order_get_items_num();
        $this->total_goods = $this->all_order_details->total_goods;
        
        //a_print($this->all_order_details);
        
    }
    
    
    function calculate_fee() {
        
        $utanvet = 0;
        $delivery_fee = $this->get_delivery_fee();
        
        
        $delivery_fees = array(
            'delivery_fee'  =>  $delivery_fee,
            'utanvet' => $utanvet,
            'total_delivery' => $utanvet + $delivery_fee,
            'delivery_note' =>  $this->get_delivery_note(),
            'delivery_error' => $this->get_delivery_error(),
            );
        
        return $delivery_fees;
        
    }
    
    
    private function get_delivery_fee() {
        
        $fee = 0;
        
        if ($this->delivery_mode == 'HOME_DLV')  {
         
            $i = 1;
            foreach ($this->order_items as $item) {
                if (substr($item->options[CIKKSZAM], 0, 1) == 'A')
                    $fee += $item->qty * 12700;
                $i++;
            }
            
            if ($fee == 0) $fee = 12700;
            
        }
        
        return $fee;
    }
    
    
    private function order_get_items_num() {
        $items_qty = 0;
            foreach ($this->order_items as $item) {
                $items_qty += $item->qty;
            }
        
        return $items_qty;
    }

    
    
    
    private function get_delivery_note() {
      //  if ($this->itemnum > 1) return 'Egyedi szállítási díj';

    }

    
    private function get_delivery_error() {
//        if ($this->itemnum > 1) return 'Tött ajtó esetén egyedi szállítási díj kerül meghatározásra. Kérjük, vegye fel velünk a kapcsolatot.';

    }
    
    
    
}