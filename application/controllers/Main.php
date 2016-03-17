<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Base/Main_Base.php';

class Main extends Main_Base {
    
    
    public function load_models() {
        fx4();

        $this->load->database();
        $this->load
            ->model('product_model')
            ->model('order_model')
            ->model('email_model')
            ->model('etc_model')
            ->model('admin_model')
            ->model('view_model')
            ->model('fx4_model')
            ;
        
    }
    
    
    public function termekek($url) {
        parent::termekek($url);
        
           
        
        
    }


    public function load_view($page, $data = array()) {

        $data = $this->header($data);    

            $data['gombok'] = $this->load->view('gombok', NULL, TRUE);        

            if ($page == 'index') {
                // $this->authentication->create_user('ajtoadmin', 'ajt0ABla9');
                $data['galeria'] = $this->view_model->get_galeria('Főoldali');
                $data['kiemelt_termekek'] = $this->product_model->get_products('kiemelt');
                $this->load->view("fooldal", $data);            
            }
        
            else
            if ($page == 'piacter') {
                $data['szuresek'] = $this->load->view('szuresek', NULL, TRUE);
                $this->load->view("termeklista", $data);
            }
        
            else
            if ($page == 'kosar') {
                $this->load->view('kosar', $data);
                $this->load->view('js_loader', array('js' => 'kosar-flip'));
                
            }

            else
            if ($page == 'termekek') {
                $data['gallery'] = $this->product_model->print_product_galery($data['product']);
                $data['form_options'] = $this->load->view('product-options', NULL, TRUE);
                $data['form_group'] = $this->load->view('product-groups', NULL, TRUE);
                $data['minta_file'] = $this->view_model->get_minta_file($this->uri->segment(4), $data['product']->id);
                $data['szin_file'] = $this->view_model->get_minta_file($this->uri->segment(6), $data['product']->id);
                $this->load->view('js_loader', array('js' => 'options-sort'));
                $this->load->view('js_loader', array('js' => 'flip-image'));
                $this->load->view('js_loader', array('js' => 'remove-single-select'));
                $this->load->view('js_loader', array('js' => 'termekoldal'));
                $this->load->view('termekoldal', $data);
            }

            else
            if ($page == 'kapcsolat') {
                $this->load->view('kapcsolat', $data);
            }

            else
            if ($page == 'kereses') {
                
                if (empty($data['products'])) $data['uzenet'] = "Jelenleg nincs találat a megadott kulcsszóhoz.<br> Kérjük, próbálja meg újra a keresést egy másik, hasonló kifejezéssel.";
                $data['szuresek'] = '';
                $data['oldalcim'] = "Keresés";
                
                $this->load->view("termeklista", $data);

            }

        $this->view_model->footer();  
                    
        }
        
    
    public function customize($method, $data) {
        
        if ($method == 'termekek') {
            $sku = $data['sku'];
            $termek = $this->fx4_model->keszlet('', $sku);
            $data['product']->price = $termek['price'];
            $data['product']->stock = $termek['stock'];
                        
        }
        
        
        if ($method == 'piacter') {
            $keszletlista = $this->fx4_model->keszletlista();
            
            $products = $data['products'];
            
            foreach ($products as $key => $product) {
                
                
                $sku = $products[$key]->sku;
                
                $ajto_csalad = array();

                    $i = 1;
                    foreach($keszletlista as $key2 => $value){
                        if ($sku == substr($key2,0,4)){
                            $ajto_csalad[] = $value;
                            $i++;
                        }
                        
                    }
                if ($i > 1) {
                
                    $min_price = min($ajto_csalad);
                    $min_price = floor($min_price['price']);
                    $max_price = max($ajto_csalad);
                    $max_price = floor($max_price['price']);

                    if ($max_price - $min_price > 10) $min_price *= -1;

                    $products[$key]->price = $min_price;

                } else if (key_exists($product->sku, $keszletlista)) {
                    $products[$key]->price = $keszletlista[$product->sku]['price'];
                    $products[$key]->stock = $keszletlista[$product->sku]['stock'];
                }

                $data['products'] = $products;
                
            
            }
        
        }
        
        
        return $data;
        
    }
    
    
    public function header($data = array()) {
        $data['almenu'] = $this->product_model->print_categories('almenu', TRUE, FALSE);
        $this->load->view('header', $data);
        $data['gombok'] = $this->load->view('gombok', NULL, TRUE);   
        
        return $data;

    }
    
    
    public function design($id) {
        
        $data['szuresek'] = $this->load->view('design/szuresek', NULL, TRUE);
        $data['gombok'] = $this->load->view('gombok', NULL, TRUE);
        
            $this->load->view("design/header");        
            $this->load->view("design/$id", $data);
            $this->load->view("design/footer");
    }
    
    
    public function elallasi_nyilatkozat() {
        $this->download_pdf('elallasi_nyilatkozat.pdf');
    }
    
    
    public function szavatossag() {
        $this->download_pdf('szavatossag.pdf');
    }
    
    
    public function aszf() {
        $this->download_pdf('ajtowebshop_aszf.pdf');
    }
    
    
    public function abc_ajto_pdf() {
        $this->download_pdf('UNISEC_GUIDE_ajtok.pdf');
        
    }
    
            
    public function abc_ablak_pdf() {
        $this->download_pdf('UNISEC_GUIDE_ablakok.pdf');
        
    }    
    
    
}
