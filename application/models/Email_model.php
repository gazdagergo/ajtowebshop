<?php
defined('BASEPATH') or exit('Access denied');

require 'Base/Email_Base_model.php';
require 'Base/Email_model_interface.php';

class Email_model extends Email_Base_model implements Email_model_interface {

    
    function collect_data_for_visszaigazolas_email($order_id) {
 
        $details = $this->order_model->get_all_order_detail($order_id);   
 
        $items = $this->order_model->get_order_items($details->id);
        $total = $details->total_goods + $details->total_delivery;
        
        $data['details'] = $details;
        $data['items'] = $items;
        $data['total'] = $total;
        $data['paying_method'] = $this->order_model->resolve_list_text('paying_method', $details->paying_method);
        $data['delivery_mode'] = $this->order_model->resolve_list_text('delivery_mode', $details->delivery_mode);  
    
            if ($details->paying_method == 'BANK_TRF') {
                $query = $this->db
                    ->where('url', 'email_szoveg_elore_utalas')
                    ->get('textpages')
                    ;
            } else {
                $query = $this->db
                    ->where('url', 'email_szoveg')
                    ->get('textpages')
                    ;
            }

            if ($query->num_rows() > 0)
                $email_text = $query->row()->html;
            else
                $email_text = '';
        
        $data['email_text'] = $this->etc_model->html_codes($email_text, NULL, $details->id);
        
        return $data;
    }
    
}