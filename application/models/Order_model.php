<?php

require 'Base/Order_Base_model.php';

class Order_model extends Order_Base_model {
  
    function destock_order_items($order_id) {
        return true;
    }
    
    function szamla_keszites($order_id) {
        
            if (!$this->check_order_status($order_id, 'ok_to_destock')) {
                return false;
            }
        
        $order = $this->db->where('id', $order_id)
            ->get('orders')
            ->row();
        
        
        $items = $this->db
            ->where('order_id', $order_id)
            ->get('order_items')
            ->result();

        
        $szamla_link = $this->fx4_model->uj($order_id);
        
        return $szamla_link;

        
        
/*            foreach ($items as $item) {
                $this->db
                    ->query(
                        "UPDATE `products`
                        SET stock = stock - $item->qty 
                        WHERE id = $item->item_id"
                    );
            }   */     
    }
    
    
}