<?php
class Order_Base_model extends CI_Model {
    
    public $hazhoz_kezbesitesi_dijak;
    public $utanvet;
    
    
    public function insert_or_update_order($order_id = NULL) {
     
        $order_fields = array(
            'delivery_mode', 'paying_method', 'same_address', 'valasztott_postapont', 'delivery_note', 'postapont_id', 'user_notes'
            );
        
        $addresses_fields = array(
            'city', 'address', 'zip'
            );
        
        $customer_fields = array(
            'name', 'email', 'phone'
            );

        $bill_address_fields = array(
            'bill_company', 'bill_address', 'bill_city', 'bill_zip', 'bill_vat'
            );

        
        $total_goods = $this->cart->total();
        
            foreach ($order_fields as $field) {
                $$field = $this->input->post($field);
            }

            if ($order_id == NULL) {
                $order_details = NULL;
                $customer_details_id = NULL;
                $address_id = NULL;
                $bill_address_id = NULL;                
            } else {
                $order_details = $this->get_order_details($order_id);
                $customer_details_id = $order_details['customer_details_id'];
                $address_id = $order_details['address_id'];
                $bill_address_id = $order_details['bill_address_id'];                
            }

        $order_details = array(
            'total_goods' => $total_goods,
            'order_time' => date('Y-m-d H:i:s'),
            'status' => 'BFR_PAY',
        );

            if ($this->input->post('same_checkbox_exists')) {
                
                if ($this->input->post('same_address') != 1) {
                    $bill_address_id = $this->add_or_edit_record('order_bill_addresses', $bill_address_fields, $bill_address_id);
                } else {
                    $bill_address_id = NULL;   
                }
                
            $order_details['same_address'] = $this->input->post('same_address');     
                
            } 
        
        
        $editable_order_details = array(
            'bill_address_id' => $bill_address_id,
            'address_id' => $this->add_or_edit_record('order_addresses', $addresses_fields, $address_id),
            'customer_details_id' => $this->add_or_edit_record('order_customers', $customer_fields, $customer_details_id),
            'delivery_mode' => $delivery_mode,
            'paying_method' => $paying_method,
            'postal_notes' => $valasztott_postapont . ' | Díjszámítás: ' . $delivery_note,
            'postapont_id' => $postapont_id,
            'user_notes' => $user_notes,
        );

            foreach ($editable_order_details as $key => $value) {
                if ($value) {
                    $order_details[$key] = $value;
                } 
            }


            if ($order_id == NULL) {

                $this->db->insert('orders', $order_details);
                $order_id = $this->db->insert_id();
                $this->add_or_modify_order_items($order_id);

            } else {
                $this->add_or_modify_order_items($order_id);
                $this->db->where('id', $order_id)
                    ->update('orders', $order_details);
            }

        $order_details['id'] = $order_id;

        return $order_details;
    }
    
    
    public function get_order_details($order_id, $field = NULL) {
        
        if ($field == NULL) {

            return $this->db
                ->where('id', $order_id)
                ->get('orders')
                ->row_array();
        } else {
            $row = $this->db
                ->where('id', $order_id)
                ->get('orders')
                ->row();
            return $row->$field;
            
        }
    }
    
    
    public function get_all_order_detail($order_id) {
        
        
        $fields = '';

        $tables = array('orders', 'order_addresses', 'order_bill_addresses', 'order_customers');
        
            foreach ($tables as $table) {
                foreach ($this->db->list_fields($table) as $field) {
                    if ($table != 'orders' AND $field == 'id') continue;
                    if ($table == 'orders' AND $field == 'id') $fields .= 'orders.id,';
                    $fields .= $table . '.' . $field . ',';
                };
            }
        
        
        $this->db
            ->select($fields)
            ->join('order_customers', 'orders.customer_details_id = order_customers.id', 'left')            
            ->join('order_addresses', 'orders.address_id = order_addresses.id', 'left')
            ->join('order_bill_addresses', 'orders.bill_address_id = order_bill_addresses.id', 'left')
            ->where('orders.id', $order_id)
            ;
        
        $result = $this->db->get('orders')->row();
        
        $result->total = $result->total_goods + $result->total_delivery;
        $result->order_id = $result->id;
        
        return $result;
        
    }    
    
    
    function add_or_edit_record($table, $fields, $table_id = NULL) {
        
        $input = array();
        
            foreach($fields as $key) {
                if ($this->input->post($key) != NULL) {
                    $input[$key] = $this->input->post($key);
                }
            }
        
            if (empty($input)) {
                return false;
            }
        
            if ($table_id == NULL) {
                
                $this->db->insert($table, $input);
                return $this->db->insert_id();
                
            } else {
                $this->db->where('id', $table_id)
                    ->update($table, $input);
                return $table_id;
            }
        
           
    }
    

    function get_record($table, $id) {
        if ($id == NULL) return NULL;
        
        return $this->db
            ->where('id', $id)   
            ->get($table)
            ->row();
        
    }
    
    
    function add_or_modify_order_items($order_id) {
        
        $this->db
            ->where('order_id', $order_id)
            ->delete('order_items');
            
            foreach ($this->cart->contents() as $item) {

                if (!empty($item['options'])) {
                    $options = serialize($item['options']);
                } else {
                    $options = NULL;   
                }
                
                $this->db
                    ->insert('order_items', array(
                        'order_id' => $order_id,
                        'item_id' => $item['id'],   
                        'qty' => $item['qty'],
                        'order_price' => $item['price'],
                        'options' => $options,
                    ));

            }        
        
    }
    
    
    function set_order_status($order_id, $status) {
        $this->db
            ->where('id', $order_id)
            ->update('orders', array('status' => $status));
    }
    
    
    function get_order_items($order_id){
        $query = $this->db
            ->join('products', 'order_items.item_id = products.id', 'left')
            ->where('order_id', $order_id)
            ->get('order_items');
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
            
            foreach ($result as $key => $row) {
                $options = unserialize($row->options);
                $result[$key]->options = $options;
                
            }
            
            return $result;
            
        }
        
    }
    
    
    function update_total_delivery($delivery_fees, $order_id){
        $this->db
            ->where('id', $order_id)
            ->update('orders', array('total_delivery' => $delivery_fees['total_delivery']))
            ;        
    }
    
    
    function check_order_status($order_id, $question) {
           $ok_to_destock = array(
               'BFR_PAY',
               'ABRT_PAY',
           );
        
        $status = $this->get_order_details($order_id, 'status');
        
        if (in_array($status, $$question)) {
            return true;
        } else {
            return false;
        }
        
    }
    
    
    function get_city_list() {
        return $this->db       
            ->order_by('city')
            ->get('cities')
            ->result();

    }
    
    
    public function get_list($name, $test = NULL) {

        if ($test != NULL) {
            $list = $this->db
                ->where('field', $name)
                ->get('lists')
                ->result();
            
            return $list;
        }
        
        $list = $this->db
            ->where('field', $name)
            ->where('active', 1)
            ->get('lists')
            ->result();
        return $list;
        
            
    }
    
    
    public function resolve_list_text($list, $value) {
        $query = $this->db
            ->where('field', $list)
            ->where('code', $value)
            ->get('lists');
        
        if ($query->num_rows() == 0) {
            return "Nincs megadva";
        } else {
            return $query
            ->row()
            ->text;
        
        }
    }
    
    
    public function get_bill_details($order_id) {
    
        $order_details = $this->get_order_details($order_id);
        $customer_details = $this->get_record('order_customers', $order_details['customer_details_id']);
        
        if ($order_details['same_address'] == 1) {
         
            $address_details = $this->get_record('order_addresses', $order_details['address_id']);
                
            
            $bill_details = array(
                'name' =>    $customer_details->name,
                'zip' =>     $address_details->zip,
                'city' =>    $address_details->city,
                'address' => $address_details->address,
                'vat' => '',
                'email' =>   $customer_details->email,
            );
            
                
        } else {
            
            $bill_address_id = $order_details['bill_address_id'];
            $bill_details = $this->get_record('order_bill_addresses', $bill_address_id);
            
            $bill_details = array(
                'name' =>    $bill_details->bill_company,
                'zip' =>     $bill_details->bill_zip,
                'city' =>    $bill_details->bill_city,
                'address' => $bill_details->bill_address,
                'vat' =>     $bill_details->bill_vat,
                'email' =>   $customer_details->email,
            );
            
        }
        
        return $bill_details;    
    }
    

 
    
}