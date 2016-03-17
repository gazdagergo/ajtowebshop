<?php
defined('BASEPATH') or exit('Access denied');

class Email_Base_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load
            ->model('order_model');
    }
    
    
    function rendelesrol_level_adminnak($order_id) {
        
        
        $details = $this->order_model->get_all_order_detail($order_id);   

        $email = $details->email;
        $items = $this->order_model->get_order_items($details->id);
        $total = $details->total_goods + $details->total_delivery;
        
        $data['details'] = $details;
        $data['items'] = $items;
        $data['total'] = $total;
        $data['paying_method'] = $this->order_model->resolve_list_text('paying_method', $details->paying_method);
        $data['delivery_mode'] = $this->order_model->resolve_list_text('delivery_mode', $details->delivery_mode);
        
        $message = $this->load->view('/email/rendeles_adminnak', $data, TRUE);
        
        //echo $message;
        
        $this->config->item('protocol');
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from(FROM_EMAIL, FROM_NAME);
        $recipients = array(ADMIN_EMAIL1);
        $this->email->to($recipients);
        $this->email->subject('Rendelés érkezett a ' . substr(base_url(),7) . ' honlapról');
        $this->email->message($message);
        $this->email->send();
    
    }
    
   
    function rendeles_visszaigazolas($order_id) {
        
        $data = $this->collect_data_for_visszaigazolas_email($order_id);
        $email = $data['details']->email;

        
        $message = $this->load->view('/email/rendeles_visszaigazolas', $data, TRUE);
        
       //  echo $message; //!
        
        $this->config->item('protocol');
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from(FROM_EMAIL, FROM_NAME);
        $recipients = array($email);
        $this->email->to($recipients);
        $this->email->subject('Visszaigazolás rendelésről');
        $this->email->message($message);
       /*//!*/ $this->email->send();
    
    }
    
    
    function uzenet_honlaprol() {
        
            foreach ($this->input->post() as $key => $value) {
                $$key = $value;
            }
        
        $message = "
        <h2>Üzenet érkezett az ajtowebshop.hu honlapról</h2>
        <p><strong>A feladó neve:</strong> $kapcsolat_nev<br>
        <strong>A feladó email címe:</strong> $kapcsolat_email<br>
        <strong>A feladó telefonszáma:</strong> $kapcsolat_phone<br>
        <strong>Az üzenet:</strong><br>
        $kapcsolat_uzenet
        ";

        $this->config->item('protocol');
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('info@ajtowebshop.hu', 'Ajtó webshop');
        $recipients = array_merge(array(ADMIN_EMAIL1), unserialize(SALES_EMAILS));
        $this->email->to($recipients);
        $this->email->subject('Üzenet a honlapról');
        $this->email->message($message);
        return $this->email->send();
    }
    
}