<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Penztar_Base extends CI_Controller {
    
    public $order_id;
    public $payu_config;
    public $order_details;
    public $all_order_details;
    public $lu;
    
    function __construct() {
        parent::__construct();
        if ($this->cart->total_items() == 0) redirect('/kosar'); 
        
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        include APPPATH . 'third_party/payu/sdk/PayUPayment.class.php';
        include APPPATH . 'third_party/payu/demo/demo_functions.php';
        
        $this->load_models();
        
        //----
        
        //a_print($this->input->post());
        
        if (!$this->uri->segment(2)) {
            redirect('/penztar/adatfelvetel');   
        }
        
        $this->prevent_deleted_cookie_error();
        
        $this->set_current_order_id();
        
        if (!empty($this->order_id)) $this->all_order_details = $this->order_model->get_all_order_detail($this->order_id);
        
        $this->load->library('form_validation');

		if ($this->input->post('szallitasra_gomb')) {
            
            $this->form_validation->set_error_delimiters('<div class="form_error">', '</div>');         
            $this->form_validation->set_rules('email', 'z e-mail cím', 'required|valid_email');
            $this->form_validation->set_rules('name', ' név', 'required');
            $this->form_validation->set_rules('address', ' cím', 'required');
            $this->form_validation->set_rules('city', ' város', 'required');
            $this->form_validation->set_rules('zip', 'z irányítószám', 'required');
            $this->form_validation->set_rules('phone', ' telefonszám', 'required');
            
                if ($this->form_validation->run() == FALSE) {
                    //print validation errors
                } else if ($this->order_id) {
                    $this->order_model->insert_or_update_order($this->order_id);    
                    redirect('/penztar/szallitas_fizetes');   
                } else {
                    $this->order_id = $this->ujRendelesFelvitele();                    
                    redirect('/penztar/szallitas_fizetes');   
                }
        }
        
	
        if ($this->uri->segment(2) == "szallitas_fizetes") {
            $this->order_model->insert_or_update_order($this->order_id);    
        }
        
        if ($this->input->post('ellenorzesre_gomb')) {
  
            $this->form_validation->set_error_delimiters('<div class="form_error">', '</div>');         
            $this->form_validation->set_rules('delivery_mode', ' szállítási mód', 'required');
            $this->form_validation->set_rules('paying_method', ' fizetési mód', 'required');        
            
            if ($this->form_validation->run() == FALSE) {
                //print validation errors
            } else if ($this->order_id) {
                $this->order_model->insert_or_update_order($this->order_id);                    
                redirect('/penztar/ellenorzes');   
            } else {
                redirect('/penztar/ellenorzes');   
            }
        }

        
        
    }

    
    public function _remap($method, $params = array())  {
        if (method_exists($this, $method) AND !empty($params)) {
            $this->{$method}($params[0]);
        } else if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->szovegoldal($method);
        }

    }    

    
    public function set_current_order_id() {
        
        if ($this->input->cookie('order_id')!='') {//javitas utan
            $this->order_id = $this->input->cookie('order_id');
        }
        else if ($this->input->post() AND $this->input->cookie('order_id')=='') {//uj rendeles
            
        }        
        else if ($this->input->post('order_id')) { //fizetes gomb
            $this->order_id = $this->input->post('order_id');
        } 
        
    }
    
    
    public function prevent_deleted_cookie_error() {
        
        if ($this->input->cookie('order_id')=='' AND
            ! $this->input->post()
            ) {
            
            if ($this->uri->segment(2) == 'szallitas_fizetes' OR
                $this->uri->segment(2) == 'ellenorzes'                
               ) {
                redirect('/penztar/adatfelvetel');   
            }
        }
        
        
    }
    
    
    public function ujRendelesFelvitele() {
        
        $this->order_details = $this->order_model->insert_or_update_order();
        $cookie = array(
            'name'   => 'order_id',
            'value'  => $this->order_details['id'],
            'expire' => time()+86500,
        );
        $this->input->set_cookie($cookie);
        $this->order_id = $this->order_details['id'];

        
    }
    
    
    function index() {
        
        //redirect('/penztar/adatfelvetel');
    }
    
        
    public function init_payu() {
        
        $config = $this->config_payu();

        $lu = new PayULiveUpdate($config);

        $orderCurrency = 'HUF';

            if (isset($_REQUEST['testcurrency'])) {
                $orderCurrency = $_REQUEST['testcurrency'];
            }        
        
        
        $lu->debug = false;

        $lu->setField("PRICES_CURRENCY", $orderCurrency);
        $lu->setField("ORDER_DATE", $config['ORDER_DATE']);
        $lu->setField("BACK_REF", $config['BACK_REF']);
        $lu->setField("TIMEOUT_URL", $config['TIMEOUT_URL']);
        $lu->setField("ORDER_TIMEOUT", $config['ORDER_TIMEOUT']);



            if ($config['METHOD']!='') {
                $lu->setField("PAY_METHOD", $config['METHOD']);
                $lu->setField("AUTOMODE", 1);
            } 
            elseif ($config['METHOD']=='') {
                $lu->setField("PAY_METHOD", '');
                $lu->setField("AUTOMODE", 0);
            } 


        $all_order_details = $this->order_model->get_all_order_detail($this->order_id);
        $this->all_order_details = $all_order_details;


        $lu->setField("ORDER_REF", $all_order_details->id);
        $lu->setField("ORDER_SHIPPING", $all_order_details->total_delivery); 
        $lu->setField("LANGUAGE", LANGUAGE);
        $lu->setField("ORDER_PRICE_TYPE", "GROSS");			// [ GROSS | NET ]



            foreach ($this->cart->contents() as $cart_item) {

                $product_array = array(
                    'name' => $cart_item['name'],		//product name [ string ]
                    'code' => $cart_item['rowid'],			//merchant systemwide unique product ID [ string ]
                    'price' => $cart_item['price'], 	//product price [ HUF: integer | EUR, USD decimal 0.00 ]
                    'vat' => 0,							//product tax rate [ in case of gross price: 0 ] (percent)
                    'qty' => $cart_item['qty']			//product quantity [ integer ] 
                );

                if (!empty($cart_item['options'])) {

                    $info = '';

                        $i=0;
                        foreach($cart_item['options'] as $key => $value) {
                            if ($i>0) $info .= ', ';
                            $info .= "$key: $value";
                            $i++;
                        }

                    $product_array['info'] = $info;

                }

                $lu->addProduct($product_array);

            }


        $lastname = substr(strstr($all_order_details->name, ' '), 1);
        $firstname = strstr($all_order_details->name, ' ', true);


        $lu->setField("BILL_FNAME", $firstname);
        $lu->setField("BILL_LNAME", $lastname);
        $lu->setField("BILL_EMAIL", $all_order_details->email); 
        $lu->setField("BILL_PHONE", $all_order_details->phone);

            if ($all_order_details->same_address != 1) {    
                $lu->setField("BILL_COMPANY", $all_order_details->bill_company);			// optional
                $lu->setField("BILL_COUNTRYCODE", "HU");
                $lu->setField("BILL_STATE", "Hungary");
                $lu->setField("BILL_CITY", $all_order_details->bill_city); 
                $lu->setField("BILL_ADDRESS", $all_order_details->bill_address); 
                $lu->setField("BILL_ZIPCODE", $all_order_details->bill_zip); 
            } else {
                $lu->setField("BILL_COUNTRYCODE", "HU");
                $lu->setField("BILL_STATE", "Hungary");
                $lu->setField("BILL_CITY", $all_order_details->city); 
                $lu->setField("BILL_ADDRESS", $all_order_details->address); 
                $lu->setField("BILL_ZIPCODE", $all_order_details->zip); 
            }


        $lu->setField("DELIVERY_FNAME", $all_order_details->name); 
        $lu->setField("DELIVERY_LNAME", ""); 
        $lu->setField("DELIVERY_EMAIL", $all_order_details->email); 
        $lu->setField("DELIVERY_PHONE", $all_order_details->phone); 
        $lu->setField("DELIVERY_COUNTRYCODE", "HU");
        $lu->setField("DELIVERY_STATE", "Hungary");
        $lu->setField("DELIVERY_CITY", $all_order_details->city);
        $lu->setField("DELIVERY_ADDRESS", $all_order_details->address); 
        $lu->setField("DELIVERY_ZIPCODE", $all_order_details->zip); 


        $lu->logger = $config['LOGGER'];
        $lu->log_path = $config['LOG_PATH'];


        $this->lu = $lu;    

        return $lu;
        
    }
    
    
    public function adatfelvetel() {

        
        $data = array();
        $data['cities'] = $this->order_model->get_city_list(); 

            if ($this->input->cookie('order_id')!='') {
                $form_details = $this->order_model->get_all_order_detail($this->order_id);
                $data['form_details'] = $array = json_decode(json_encode($form_details), true);
            }

        $data['delivery_list'] = $this->order_model->get_list('delivery_mode');
        $data['paying_list'] = $this->order_model->get_list('paying_method');
         
        $this->form_validation->run();
        
        $this->load_view(__FUNCTION__, $data);
        

    }
        

    public function szallitas_fizetes() {
        
        $this->szallitas_model = $this->select_szallito();
        
        $this->load->model($this->szallitas_model);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="form_error">', '</div>');        
        $this->form_validation->set_rules('paying_method', ' fizetési mód', 'required');

        
        $data = array();
        $data['cities'] = $this->order_model->get_city_list(); 

            if ($this->input->cookie('order_id')!='') {
                $form_details = $this->order_model->get_all_order_detail($this->order_id);
                $data['form_details'] = $array = json_decode(json_encode($form_details), true);
            }

        $test = $this->uri->segment(3);
        
        $data['delivery_list'] = $this->order_model->get_list('delivery_mode');
        $data['paying_list'] = $this->order_model->get_list('paying_method', $test  );
         
        $this->form_validation->run();
        
        
        $delivery_fees = $this->{$this->szallitas_model}->calculate_fee();

        $this->order_model->update_total_delivery($delivery_fees, $this->order_id);
        
        $data['delivery_fee'] = $delivery_fees['delivery_fee'];
        $data['utanvet'] = $delivery_fees['utanvet'];
        $order_details = $this->order_model->get_all_order_detail($this->order_id);
        $data['order_details'] = $order_details;      
        

        
            if ($delivery_fees['delivery_error']) {
                $data['error'] = $delivery_fees['delivery_error'];
                $data['disable_submit'] = true;   

            }
        

        $data['delivery_note'] = $delivery_fees['delivery_note'];

        $data = $this->customize(__FUNCTION__, $data);
    
        $this->load_view(__FUNCTION__, $data);
    }
    
    
    public function ellenorzes() {
            
        $this->szallitas_model = $this->select_szallito();
        
        $this->load->model($this->szallitas_model);
        $delivery_fees = $this->{$this->szallitas_model}->calculate_fee();
        $data['delivery_fee'] = $delivery_fees['delivery_fee'];
        $data['utanvet'] = $delivery_fees['utanvet'];
            
        $order_details = $this->all_order_details;
        $data['order_details'] = $order_details;
        $data['config'] = $this->config_payu();
        $data['delivery_note'] = $delivery_fees['delivery_note'];
        
        
        if ($order_details->paying_method == 'BANK_TRF') {
            $data['view'] = 'penztar/rendeles_eloreutalas';
        }
        else if ($order_details->paying_method == 'WS_CARD') {
            $data['view'] = 'payu/huf_paybutton';          
        }
        else if ($order_details->paying_method == 'PAY_RECV') {
            $data['view'] = 'penztar/rendeles_utanvet';          
        }
        
        $this->load_view(__FUNCTION__, $data);
        
        
    }
    
    
    public function fizetes() {
        $lu = $this->init_payu();
        
		$display=false;

            if (isset($_REQUEST['testmethod'])) {

                $lu->setField("PAY_METHOD", "CCVISAMC");
                $display=true;
                $display = $lu->createHtmlForm('PayUForm', 'auto', PAYMENT_BUTTON);					

            }

                $data['display'] = $display;
                $data['config'] = $this->payu_config;



            if ($display) {

                $data['lu'] = $lu;            
                
                $this->load_view(__FUNCTION__, $data);

            }
        
        
    }
    
    
    public function fizetes_sikertelen($order_id = NULL) {

            foreach($_GET as $key => $value) {
                $$key = $value;
            }
        
        if ($order_id == NULL) $order_id = $order_ref;
        $this->order_model->set_order_status($order_id, 'ABRT_PAY');
        
            if (isset($status) AND $status == 'lejart') {
                $data['txt'] = 'A tranzakció sikertelen. A rendelés nem teljesült.';
            } else if (isset($status) AND $status == 'hiba') {
                $data['txt'] = 'A tranzakció sikertelen. A rendelés nem teljesült.';   
            } else {
                $data['txt'] = 'A fizetési folyamat megszakadt. A rendelés nem teljesült';   
            }
        
            if (isset($payrefno))
                $data['txt'] .= '<br>Az Ön Simple tranzakció-azonosítója: <b> ' . $payrefno . '</br>';
            if (isset($order_ref))
                $data['txt'] .= '<br>Rendelés-azonosító: <b> ' . $order_ref . '</br>';
        
        
        delete_cookie('order_id');
        $this->load_view(__FUNCTION__, $data);
        
        
    }
    
    
    public function megrendelve($fizetesi_mod) {
        
        $data['fizetesi_mod'] = $fizetesi_mod;
        
        if ($fizetesi_mod == "kartya") {
        
            foreach($_GET as $key => $value) {
                $$key = $value;
                $data[$key] = $value;
            }

      
            $order_id = $order_ref;
            
            $config = $this->config_payu();
            $backref = new PayUBackRef($config);
            $backref->order_ref = $order_ref;
            $backref->logger = $config['LOGGER'];
            $backref->log_path = $config['LOG_PATH'];            
            
                if ($_GET['RC'] == 999) {
                    redirect('/penztar/fizetes_sikertelen/?order_ref='.$order_ref.'&status=hiba');
                    return false;
                }
                else
            	if(!$backref->checkResponse()){
                
                    redirect('/penztar/fizetes_sikertelen/?order_ref='.$order_ref.'&status=lejart&payrefno='.$payrefno);

                }
                else {
                    $data['szamla_link'] = $this->order_model->szamla_keszites($order_id);                    
                }
            
            
        } else {
            $order_id = $this->input->post('order_id');
        }

        
        $order_details = $this->order_model->get_all_order_detail($order_id);
        
            if ($order_details->status != 'ORDERED') {
                $this->order_model->destock_order_items($order_id);
                $this->order_model->set_order_status($order_id, 'ORDERED');
            /*//!*/    $this->cart->destroy();        
            /*//!*/    delete_cookie('order_id');
                $this->email_model->rendeles_visszaigazolas($order_id);
            /*//!*/    $this->email_model->rendelesrol_level_adminnak($order_id);
            }
        
        $data['order_id'] = $order_id;
        $data['total'] = $order_details->total_goods + $order_details->total_delivery;
        $data['name'] = $order_details->name;
        
        $this->load_view(__FUNCTION__, $data);


        }        

 
    public function szovegoldal($oldal) {
        $this->header();    
        $this->view_model->szovegoldal_body($oldal);
        $this->view_model->footer();                
    }
    
    
    public function irn() {
        //Refound notification
          
        
    }
    
    
    public function idn() {
        //Delivery notification   
    }
    
  
}