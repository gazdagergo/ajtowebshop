<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Base extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load_models();
        
        if ($this->input->post('call_just_this_main_function')) {
            $functionCalling = $this->input->post('call_just_this_main_function');
            $this->$functionCalling();            
        }
        else if ($this->input->post('call_main_function')) {
            $functionCalling = $this->input->post('call_main_function');
            $this->$functionCalling();
        }
        
        
        if ($this->input->post('scroll')) {
            $cookie = array(
                'name'   => 'last_scroll',
                'value'  => $this->input->post('scroll'),
                'expire' => time()+86500,
            );
            delete_cookie('last_scroll');            
            set_cookie($cookie);            
        } 
        
        
    }

    
    public function _remap($method, $params = array())  {
        if (!method_exists($this, $method) AND !empty($params)) {
            $this->alkategoria($params);                
        }
        else if (method_exists($this, $method) AND !empty($params)) {
            $this->{$method}($params[0]);
        } else if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            if ($this->product_model->category_exists($method)) {
                $this->kategoria($method);
            } else {
                $this->szovegoldal($method);
            }
        }

    }
    

	public function index() {
        $this->load_view(__FUNCTION__);
	}
    

    public function piacter($products, $id) {
        $data['products'] = $products;             
        $data['id'] = $id;    
        
        $data = $this->customize(__FUNCTION__, $data);

        $this->load_view(__FUNCTION__, $data);
    }
    
    
    public function kosar() {
        $data = array();
        
            if ($this->cart->total_items() == 0) {
                $data['state'] = 'ures_kosar';    
                $data['uzenet'] = "A kosarad jelenleg üres.";
            }

        $this->load_view(__FUNCTION__, $data);

    }
    
    
    public function kategoria($kategoria) {
        $products = $this->product_model->get_products($kategoria);        
        $this->piacter($products, $kategoria);
    }
    
    
    public function alkategoria($alkategoria) {
        $products = $this->product_model->get_products(NULL, $alkategoria[0]);    
        $this->piacter($products, $alkategoria);
    }
    
    
    public function termekek($url) {
        $product_details = $this->product_model->get_product_details($url);

            if (!$product_details) {
                $this->szovegoldal('404');   
                return;
            }
        $data['hasonlok'] = $this->product_model->get_hasonlo_termekek($url, 9);
        $group_id = $product_details->product_group;
        $data['group_members'] = $this->product_model->get_product_group_members($group_id);
        $product_group_image = $this->product_model->get_product_group_image($group_id);
        $data['product_group_image'] = $product_group_image;
        if ($product_details->file_1_url == '') $product_details->file_1_url = $product_group_image;
        $options = $this->product_model->get_product_options($product_details->id);
        if ($options) {
            $default_options_string = $this->product_model->get_default_options_string($options);
            if (uri_string() == 'termekek/' . $url)
            redirect('termekek/' . $url . '/'. $default_options_string);
            $selected_options = $this->product_model->get_selected_options($options);
        }
        $data['sku'] = $sku = $this->product_model->get_sku($product_details->id);
        $data['options'] = $options;
        $data['product_in_cart'] = $this->product_model->get_cart_product_qty($product_details->id, $sku);
        $product_details = $this->product_model->modify_attributes_by_sku($product_details, $sku);
        $data['attribute'] = $this->product_model->print_product_attributes($product_details);
        //$option_price = $this->product_model->get_option_price($product_details->id, $options);
        //$product_details->price += $option_price;
        
        $data['product'] = $product_details;     
        
        $data = $this->customize(__FUNCTION__, $data);
        
        $data['product_cart_form_hiddens'] = $this->product_model->print_product_cart_form_hiddens($product_details, $options, $sku); 
        
        $this->load_view(__FUNCTION__, $data);
        
    }
    
    
    public function megrendeles() {
        $this->cart->destroy();
        redirect('kosar');
    }
    
    
    public function kapcsolat() {

        $data['response'] = '';
        $data['resp_class'] = '';
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kapcsolat_email', 'z e-mail cím', 'required|valid_email');
        $this->form_validation->set_rules('kapcsolat_nev', ' név', 'required');
        $this->form_validation->set_rules('kapcsolat_phone', ' telefonszám', 'required');
        $this->form_validation->set_error_delimiters('<div class="form_error">', '</div>');         
        
        
            if ($this->form_validation->run() == FALSE) {
                
            } else if ($this->input->post('kapcsolat_submit') AND $this->email_model->uzenet_honlaprol()) {
                    $data['response'] = 'Az üzenetet elküldtük';
                    $data['resp_class'] = 'resume';
            } else if ($this->input->post('kapcsolat_submit')) {
                    $data['response'] = 'Hiba az üzenet küldése közben';
                    $data['resp_class'] = 'alert';
            };
        
        $this->load_view(__FUNCTION__, $data);
        
    }
    
        
    public function kereses($kereses = NULL) {

        $kereses = rawurldecode($kereses);
        
        $products = $this->product_model->get_products(NULL, NULL, $kereses);
        $data['products'] = $products;     

        $data['id'] = 'kereses';     
        
        $this->load_view(__FUNCTION__, $data);
        
    }
    
    
    public function szovegoldal($oldal) {
        $this->header();    
        $this->view_model->szovegoldal_body($oldal);
        $this->view_model->footer();                
    }
    
    
    public function addCart() {
        
        
        foreach ($this->input->post() as $key => $value) {
            $$key = $value;   
        }
        
        
         $options = array();
         
            $sku = $this->product_model->get_sku($id);
        
            if ($sku != NULL) $options[CIKKSZAM] = $sku;
        
            if ($this->input->post('option-number')) {

                $option_number = $this->input->post('option-number');

                    for ($i = 1; $i <= $option_number; $i++) {
                        $options[$this->input->post("option-name-$i")] = $this->input->post("option-value-$i");
                        
                    }
            }
        
         $data = array(
                       'id'      => $id,
                       'qty'     => $qty,
                       'price'   => $price,
                       'name'    => $name,
                       'options' => $options
                    );

        
            foreach ($this->cart->contents() as $items) {
                
                $stock = $this->product_model->get_stock($id, $sku);

                $keszlet_tullepes = $qty + $items['qty'] > $stock ? true : false;    
                
                    if ($items['id'] == $id && $keszlet_tullepes) {
                        return false;   
                    }

            }
        
        
        $this->cart->insert($data);    
        
    
    }
    
    
    public function updateCart() {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $product_id = $this->input->post('product_id');
        $sku = $this->input->post('sku');
        $stock = $this->product_model->get_stock($product_id, $sku);
        if ($qty == 0) $qty = 1;
        if ($qty > round($stock)) $qty = $stock;
        
        $uzenet = "A raktárkészlet $stock db";
        
        $this->cart->update(array('rowid' => $rowid, 'qty' => $qty));
    }
    
    
    public function Törlés() {
        $rowid = $this->input->post('rowid');
        $qty = 0;
        $this->cart->update(array('rowid' => $rowid, 'qty' => $qty));
    }
    
    
    public function goToGroupMember() {

        redirect('termekek/'.$this->input->post('group_member'));
        
    }
    
    
    public function setProductOption() {
        $option = $this->input->post('product_option');
        redirect('termekek/'.$this->uri->segment(2).'/'.$option);
    }
    
    
    public function download_pdf($filename) {
        $this->load->helper('download');
        $data   = file_get_contents(FCPATH.'assets/doc/'.$filename);
       force_download($filename, $data);        
    }
    
    
    public function view_pdf($filename) {
        
        $path    = FCPATH.'assets/doc/'.$filename;
        header("Content-type:application/pdf");
        //header('Content-Length: ' . filesize($path));
        readfile($path);

    }    
    
    
}
