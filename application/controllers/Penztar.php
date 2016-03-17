<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Base/Penztar_Base.php';
require 'Base/Penztar_interface.php';

class Penztar extends Penztar_Base implements Penztar_interface {
    
    public $szallitas_model = 'unisec_szallito_model';

    
    public function load_models() {
        fx4();
        
        $this->load
            ->model('order_model')
            ->model('product_model')
            ->model('email_model')
            ->model('etc_model')
            ->model('fx4_model')
            ->model('view_model')
            ;
    }   
    

    public function config_payu() {
        
        $config = array(
            'HUF_MERCHANT' => "S005801", //"P143901", 
            'HUF_SECRET_KEY' => "VfB4Rxll41BKLqnO61Z211zqX5ZsX3L7", //secret key for account ID (HUF)    
            'EUR_MERCHANT' => "", //merchant account ID (EUR)
            'EUR_SECRET_KEY' => "", //secret key for account ID (EUR)
            'USD_MERCHANT' => "", //merchant account ID (USD)
            'USD_SECRET_KEY' => "", //secret key for account ID (USD)
            'METHOD' => "CCVISAMC",                                             //payment method     empty -> select payment method on PayU payment page OR [ CCVISAMC, WIRE ]
            'ORDER_DATE' => date("Y-m-d H:i:s"),                                //date of transaction
            'LOGGER' => true,                                                   //transaction log
            'LOG_PATH' => '/assets/log',                                                //path of log file
            'BACK_REF' => 'http://'.$_SERVER['HTTP_HOST'].'/penztar/megrendelve/kartya',        //url of payu payment backref page
            'TIMEOUT_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/penztar/fizetes_sikertelen', //url of payu payment timeout page
            'IRN_BACK_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/penztar/irn',        //url of payu payment irn page
            'IDN_BACK_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/penztar/idn',        //url of payu payment idn page
            'CURL' => true,
            'ORDER_TIMEOUT' => 300,
            'LANGUAGE' => 'HU',
            'GET_DATA' => $_GET,
            'POST_DATA' => $_POST,
            'SERVER_DATA' => $_SERVER,
            
            'MIGRATION' => true,
            'SANDBOX' => true,            
            
        );            
        
        

        $orderCurrency = 'HUF';

            if (isset($_REQUEST['testcurrency'])) {
                $orderCurrency = $_REQUEST['testcurrency'];
            }

        $modifyConfig = new PayUModifyConfig($config);	
        $config = $modifyConfig->merchantByCurrency($orderCurrency);

        $this->payu_config = $config;
        
        return $config;
    }
    

    public function header($data = array()) {
        $data['almenu'] = $this->product_model->print_categories('almenu', TRUE, FALSE);
        $this->load->view('header', $data);
        $data['gombok'] = $this->load->view('gombok', NULL, TRUE);   
        return $data;
        
    }
    
    
    public function load_view($page, $data) {
        
        $data['button_class'] = "kek-gomb nagy-gomb icon-pipa";
                
        
                $data = $this->header($data);    

                    if ($page == 'megrendelve') {
                        $oldal = "megrendelve_$data[fizetesi_mod]";
                        $body_views = array(
                                            'penztar/google_conversion',
                        );
                        
                        if (isset($data['szamla_link'])) {
                            $add_html = '<br><a href="' . $data['szamla_link'] . '" target="_blank">Számla letöltése</a>';
                            $add_html .= ' (A számlát email-ben is elküldtük a megadott címre.)';
                        }
                        else 
                            $add_html = '';
                            
                        $this->view_model->szovegoldal_body($oldal, $data, $body_views, $add_html);
                    } 
                    else
                    if ($page =='adatfelvetel') {
                        $this->load
                            ->view('penztar/adatfelvetel', $data)
                            ->view('penztar/footer_js')                        
                            ;
                    }
                    else
                    if ($page == 'szallitas_fizetes') {
                        $this->load
                            ->view('penztar/szallitas_fizetes', $data)
                            ->view('penztar/footer_js')                        
                            ;
                    } 
                    else     
                    if ($page == 'ellenorzes') {
                        $this->load->view('penztar/ellenorzes', $data);
                        $this->load->view($data['view'], $data);
                        $this->load->view('penztar/ellenorzes_bottom');
                    }
                    else
                    if ($page == 'fizetes') {
                        $this->load->view('payu/atiranyitas', $data);
                    }
                    else
                    if ($page == 'fizetes_sikertelen') {
                        $this->load->view('sikertelen_fizetes', $data);
                    }

                $this->view_model->footer();  
                    
            }
    
    
    public function select_szallito() {
        
        $csak_tartozek = true;
        
        $order_items = $this->order_model->get_order_items($this->order_id);
        foreach ($order_items as $item) {
            if (substr($item->options[CIKKSZAM], 0, 1) != 'T') $csak_tartozek = false;
        }
        
        if ($csak_tartozek)
            return 'mpl_model';   
            return 'unisec_szallito_model';
        
    }
    
    
    public function customize($method, $data) {
        return $data;
    }
    
    public function test_szamla() {
        $data = array();
        $this->set_current_order_id();
        $order_id = $this->order_id;
        $data['szamla_link'] = $this->order_model->szamla_keszites($order_id);   
        $data['fizetesi_mod'] = "kartya";
        
        $data = $this->header($data);    

        
        //-----
        
       // $data['keretcim'] = 'Megrendelés elküldve';
        $oldal = "megrendelve_$data[fizetesi_mod]";
        $body_views = array(
                            'penztar/google_conversion',
        );

        if (isset($data['szamla_link'])) {
            $add_html = '<br><a href="' . $data['szamla_link'] . '" target="_blank">Számla letöltése</a>';
            $add_html .= ' (A számlát email-ben is elküldtük a megadott címre.)';
        }
        else 
            $add_html = '';

        $this->view_model->szovegoldal_body($oldal, $data, $body_views, $add_html);
        
        //----
        
        $this->view_model->footer();  

        
    }

    
}