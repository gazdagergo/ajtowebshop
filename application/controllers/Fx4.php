<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//szinkronizalhato

class Fx4 extends CI_Controller {
 
    
    function __construct() {
        parent::__construct();
        
        fx4();
        $this->load->model('fx4_model');
        
    }
    
    
    public function fx4($funkcio, $id = 0) {
    
        //http://ajtowebshop.local/fx4/termek_szinkron/001FUJI2
        
            if ($funkcio == 'termek_rogzites') {
                $paramt = array();
                $paramt[0]['termekcsoport_id'] = "1";
                $paramt[0]['vtszszj'] = "0";						
                $paramt[0]['vonalkod'] = "16";						
                $paramt[0]['cikkszam'] = "sku34";						
                $paramt[0]['megnevezes'] = "Próba Termék 14";
                $paramt[0]['megjegyzes'] = "Megjegyzés a termékhez";	//Nem kötelező
                $paramt[0]['mennyisegiegyseg_id'] = "19";				//Kötelező
                
                //Ár1 adatok
                $paramt[0]['afa_id'] = "1";
                //$paramt[0]['afa_kulcs'] = "25";						//2.0 verzióban már nem szükséges, id alapján kerül rögzítésre
                $paramt[0]['netto_egysegar'] = "200";
                
                $this->fx4_model->termek_rogzites($id, $paramt);
            }
        
        
            if ($funkcio == 'keszlet') {
                $termek = $this->fx4_model->keszlet($id, '');
                echo "Készletx: " . $termek[0] . "<br>" . "Ár: " . $termek[1] . "<br>" . "Termék ID: " . $termek[2];

                
            }
        
            
        
    }

    
    public function termek_szinkron($cikkszam) {
        $this->fx4_model->termek_szinkron($cikkszam, '');
        
    }
    
    public function uj_szamla($order_id) {
        $link = $this->fx4_model->uj();        
        echo $link;
    }   
    
}