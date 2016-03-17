<?php
defined('BASEPATH') or exit('Access denied');

class Fx4_model extends CI_Model {
    
    
    private $mod = 'eles';
    //private $mod = 'test';
    
	private $paramt = array();

    
    function __construct() {
        
    
        
   if ($this->mod == 'eles')
     	$this->paramt = array(0 => array(  
        'Csoport' => 'OPTIMUS',
        'User' => 'ADMIN',
        'Password' => 'Ajtostestverek11',
        ));    

    else 
     	$this->paramt = array(0 => array(  
        'Csoport' => 'fx4demo',
        'User' => 'USER127',
        'Password' => 'p7eftc',
        ));    
        
        
    }
    
 

    

function keszlet($cikkszam, $vonalkod){ 
    
    
    $paramt = $this->paramt;
    
	$paramt[0]['cikkszam'] = $cikkszam;
	$paramt[0]['vonalkod'] = $vonalkod;			//cikkszámot vagy vonalkódot kell megadni a termék azonosításához
	$paramt[0]['ar'] = '1'; 				//értéke 1-8, a termék eladási ára
											//vagy 0 - a termék beszerzési ára
	//$paramt[0]['raktar_id'] = '2'; 			//Nem kötelező

/*    if ($this->mod != 'eles') {
        $paramt[0]['cikkszam'] = $vonalkod;
        $paramt[0]['vonalkod'] = '';
    }*/
    
	if(termek_keszlet($paramt)) {
		//$termek[0] - készlet
		//$termek[1] - bruttó ár3
		//$termek[2] - termék ID
		global $termek;
		//echo "Készlet: " . $termek[0] . "<br>" . "Ár: " . $termek[1] . "<br>" . "Termék ID: " . $termek[2];
        $values = array(
                'stock' => $termek[0],
                'price' => $termek[1],
                'id' => $termek[2],
            );
        
        return $values;
		
	} else {
        return 0;
		//hiba
	}
    

}  
    
    
    
    
function keszletlista(){ 
    global $keszlet_lista;
    
    $paramt = $this->paramt;
    
    
	//$paramt[0]['termekcsoport_id'] = '47';    //Nem kötelező
	$paramt[0]['ar'] = '1'; 				//értéke 1-8, a termék eladási ára
											//vagy 0 - a termék beszerzési ára
	$paramt[0]['raktar_id'] = ''; 			//Nem kötelező
    $paramt[0]['mennyiseg'] = ''; 			//Nem kötelező
											//értéke:
                                            //1 - készlet < 0
                                            //2 - készlet > 0
                                            //3 - készlet = 0
                                            //0 vagy nincs megadva - mind

    $AFA = 1.27;
    
	if(keszlet_lista($paramt)) {
		//rendben
		//visszakapott értékek:
		//$termek[0] - megnevezes
		//$termek[1] - cikkszam		
        //$termek[2] - vonalkod
        //$termek[2] - keszlet
        //$termek[2] - mennyisegiegyseg
        //$termek[2] - netto 
        
        $keszlet_vonalkod = array();
        
        foreach ($keszlet_lista as $item) {
               $keszlet_vonalkod[$item['vonalkod']] = array(
                   'stock' => $item['keszlet'],
                   'price' => $item['netto'] * $AFA,
                   'name' => $item['megnevezes'],
                   'netto' => $item['netto'],
               ); 
        }
        
        
		return $keszlet_vonalkod;
	} else {
		//hiba
	}                                                   
    
}     
    
    
    
 
    
function uj($order_id){ 
	global $paramt, $szamla, $szamlaid, $szamla_hely, $link, $tmppdf;
	$this->tomb_letrehozasa($order_id);

	if(uj_szamla($paramt)) {
        return "https://www.cmfx.hu/FxPrint/?restartApplication&$link";

	} else {
        
	}
	
} 
    
    
    
    
function tomb_letrehozasa($order_id){ 

	global $paramt;
	$paramt = array();
	$paramt[0]['Csoport'] = 'fx4demo';
	$paramt[0]['User'] = 'fx4';
	$paramt[0]['Password'] = 'fx4';	
	$paramt[0]['partner_kod'] = "";							//Ha a partnerkód van megadva, az Fx törzsadatokból veszi a partnert
	$paramt[0]['partner_eszamla'] = "";						//5.0 verziótól - Partner e-számla azonosító, ha nincs megadva partnerkód és e-számla készül,
															//akkor kell kitölteni
    $order_details = $this->order_model->get_all_order_detail($order_id);
    $bill_details = $this->order_model->get_bill_details($order_id);
    
    
    $keszletlista = $this->keszletlista();
                    
    
        $items = $this->db
            ->where('order_id', $order_id)
            ->get('order_items')
            ->result();
        
            $i = 0;
            foreach ($items as $item) {
                $product = $this->product_model->get_product_details($item->item_id);
                $options = unserialize($item->options);
                $sku = $options[CIKKSZAM];
                $megjegyzes = '';
                $keszlet = $this->keszlet('', $sku);
                    
                    foreach ($options as $option_name => $option_value) {
                        $megjegyzes .= $option_name . ": " . $option_value . " \n";
                    }
                
                $paramt[$i]['termek_id'] = $keszlet['id'];						//Nem kötelező, termék azonosító
                //$paramt[$i]['cikkszam'] = $sku;					//Nem kötelező, csak akkor veszi figyelembe, ha nincs megadva termek_id
                                                                        //ez alapján kérdezi le a termek_id-t
                $paramt[$i]['megnevezes'] = $product->name;
                $paramt[$i]['mennyiseg'] = $item->qty;
                $paramt[$i]['netto_egysegar'] = $keszletlista[$sku]['netto'];
                //$paramt[$i]['kedvezmeny'] = ""; 							//Nem kötelező
                $paramt[$i]['afa_id'] = "32";							
                $paramt[$i]['mennyisegiegyseg_id'] = "19";
                $paramt[$i]['tetel_megjegyzes'] = $megjegyzes;
                //$paramt[$i]['raktar_id'] = "1";							//Nem kötelező
                //$paramt[$i]['koltseghely_id'] = "1";						//Nem kötelező
                                                                        //a koltseghely_id-k a CashMan-Fx-ben lekérdezhetőek (Információ / API információ menü)                
                $i++;
            }           

    
            if ($order_details->total_delivery > 0) {
                $i++;
                
                $paramt[$i]['megnevezes'] = "Szállítás";
                $paramt[$i]['mennyiseg'] = 1;
                $paramt[$i]['netto_egysegar'] = $order_details->total_delivery / 1.27;
                //$paramt[$i]['kedvezmeny'] = ""; 							//Nem kötelező
                $paramt[$i]['afa_id'] = "32";							
                $paramt[$i]['mennyisegiegyseg_id'] = "19";
                //$paramt[$i]['tetel_megjegyzes'] = $megjegyzes;
                
            }
    
    
    
    
	$paramt[0]['nev'] = $bill_details['name'];
	$paramt[0]['iranyitoszam'] = $bill_details['zip'];
	$paramt[0]['varos'] = $bill_details['city'] ;
	$paramt[0]['utca'] = $bill_details['address'];
	$paramt[0]['orszag'] = "Magyarország";
    
    
	$paramt[0]['adoszam'] = $bill_details['vat'];	
	//$paramt[0]['kozossegi_adoszam'] = "HU12345678";			//Nem kötelező	
    
	$paramt[0]['szallitasicim_nev'] = "";					//Nem kötelező
	$paramt[0]['szallitasicim_iranyitoszam'] = "";			//Kötelező, ha a szallitasicim_nev meg van adva
	$paramt[0]['szallitasicim_varos'] = "" ;				//Kötelező, ha a szallitasicim_nev meg van adva
	$paramt[0]['szallitasicim_utca'] = "";					//Kötelező, ha a szallitasicim_nev meg van adva
	$paramt[0]['szallitasicim_orszag'] = "";				//Kötelező, ha a szallitasicim_nev meg van adva	
    
	$paramt[0]['egyeb'] = "Megrendelésszám: $order_id";					//Nem kötelező - egyéb megjegyzés rész a számlán
	$paramt[0]['kelt'] = date('Y-m-d');
	$paramt[0]['teljesites'] = date('Y-m-d');
	$paramt[0]['fizetesi_hatarido'] = date('Y-m-d');
	//$paramt[0]['fizetesi_hatarido_nap'] = "0";				//Nem kötelező
	//$paramt[0]['fizetve'] = date('Y-m-d');  				//Nem kötelező
	$paramt[0]['fizetesmod'] = "Bankkártya"; 					//Fizetesmod lehet: Átutalás, Készpénz, Utánvét, Bankkártya, Üdülési csekk, PayPal, Szép kártya, Utalvány,
															//Halasztott KP, Barter, Kompenzáció, Barion
	$paramt[0]['deviza'] = "HUF"; 							//Deviza lehet: HUF, EUR, CHF, USD, GBP
	$paramt[0]['t_bank'] = "";								//Ha nincs megadva a $t_bank és $t_bankszamlaszam, akkor a Cashman-Fx-ben beállított bankot használja
	$paramt[0]['t_bankszamla'] = "";						//Ha nincs megadva a $t_bank és $t_bankszamlaszam, akkor a Cashman-Fx-ben beállított bankot használja
	$paramt[0]['t_blz'] = "";
	$paramt[0]['t_bic_swift'] = "";
	//$paramt[0]['megjegyzes'] = "teszt";						//Számla megjegyzés, ha nincs megadva, akkor az Fx-ből veszi az alapértelmezett számla megjegyzést

    $paramt[0]['tipus'] = "1";	 							//Nem kötelező, típus lehet 1 (normál számla) vagy 2 (díjbekérő) 
															//vagy 3 (előleg számla) vagy 4 (beérkezett számla)
	$paramt[0]['szamlatomb'] = "";     						//Számlatömb megnevezése, ha nincs megadva az alap számlatömböt használja
                                                            //Ha a tipus=2 (díjbekérő) és a proforma paraméter ki van töltve, akkor üresen kell hagyni                                                                	
    //$paramt[0]['proforma'] = "";	 						//Nem kötelező. Saját díjbekérő sorszám.                                                             
                                                            //Csak tipus=2 (díjbekérő) esetén van szerepe		
                                                            //Ha kivan töltve, a szamlatomb paramétert üresen kell hagyni.                                                            													                                                            
	//$paramt[0]['nyelv'] = "hu";	 							//Nem kötelező, lehet hu vagy de vagy en
	//$paramt[0]['peldany'] = "1";							//Nem kötelező, ha nincs megadva, egy pédányt nyomtat
															//pédányszám, maximum = 5
	$paramt[0]['noflash'] = "1";							//Nem kötelező
															//0 - Flash számla forma
															//1 - PDF számla forma
    //$paramt[0]['nodisplay'] = "0";							//Nem kötelező, csak PDF számlánál van szerepe
															//0 - Letölthető vagy megjelenik a pdf számla
															//1 - Nem jelenik meg a pdf																
	$paramt[0]['email_cim'] = $bill_details['email'];				//Nem kötelező
															//Ha ki van töltve és noflash=1, 
															//akkor erre az e-mail címre lesz küldve a számla
	//$paramt[0]['email_sablon_id'] = "";					//Nem kötelező
															//Levélsablon - E-mail PDF küldéshez 
															//level azonosítót kell megadni
    //4.7
    /*
	$paramt[0]['szamla_netto'] = '300';                     //Ha a szamla_netto létezik, akkor az alábbi mezők kötelezőek      
    $paramt[0]['szamla_afa'] = '54';                        //tetel_afa, tetel_netto, tetel_brutto, szamla_afa, szamla_netto, szamla_brutto                         $paramt[0]['szamla_brutto'] = '354';
    */                                                       
	
/*	//Első termék																
	$paramt[0]['termek_id'] = "219";						//Nem kötelező, termék azonosító
	//$paramt[0]['cikkszam'] = "456123";					//Nem kötelező, csak akkor veszi figyelembe, ha nincs megadva termek_id
															//ez alapján kérdezi le a termek_id-t
	$paramt[0]['megnevezes'] = "Első termék";
	$paramt[0]['mennyiseg'] = "1";
	$paramt[0]['netto_egysegar'] = "100";
	//$paramt[0]['kedvezmeny'] = ""; 							//Nem kötelező
	$paramt[0]['afa_id'] = "32";							
	$paramt[0]['mennyisegiegyseg_id'] = "19";
	$paramt[0]['tetel_megjegyzes'] = "Tétel megjegyzés első sor" . "\n" . "Második sor". "\n" . "Harmadik sor sor";
	//$paramt[0]['raktar_id'] = "1";							//Nem kötelező
	//$paramt[0]['koltseghely_id'] = "1";						//Nem kötelező
															//a koltseghely_id-k a CashMan-Fx-ben lekérdezhetőek (Információ / API információ menü)*/
    //4.7
	/*
    $paramt[0]['tetel_netto'] = "200";
    $paramt[0]['tetel_afa'] = "54";
    $paramt[0]['tetel_brutto'] = "254";
	*/
	 
    //Következő termék																	
	//$paramt[1]['termek_id'] = "10000";					//Nem kötelező, termék azonosító
	//$paramt[1]['cikkszam'] = "DEFXSZK";					//Nem kötelező, csak akkor veszi figyelembe, ha nincs megadva termek_id
															//ez alapján kérdezi le a termek_id-t																	
/*	$paramt[1]['megnevezes'] = "Második termék";
	$paramt[1]['mennyiseg'] = "1";
	$paramt[1]['netto_egysegar'] = "990";
	$paramt[1]['kedvezmeny'] = "10";
	$paramt[1]['afa_id'] = "32";
	$paramt[1]['mennyisegiegyseg_id'] = "19";
	$paramt[1]['tetel_megjegyzes'] = "";	
    $paramt[1]['raktar_id'] = "1";							//Nem kötelező*/
    
    //4.7
	/*
    $paramt[1]['tetel_netto'] = "100";
    $paramt[1]['tetel_afa'] = "0";
    $paramt[1]['tetel_brutto'] = "100";	
	*/
}    
       
    
    
    
    
    
    
    
    /*********/
    
    
function termek_szinkron($cikkszam, $vonalkod){ 
        //http://ajtowebshop.local/fx4/termek_szinkron/001FUJI2
        $paramt = array();
        $paramt[0]['Csoport'] = $this->csoport;
        $paramt[0]['User'] = $this->user;
        $paramt[0]['Password'] = $this->password;	
        $paramt[0]['cikkszam'] = $cikkszam;
        $paramt[0]['vonalkod'] = $vonalkod;			//cikkszámot vagy vonalkódot kell megadni a termék azonosításához
        $paramt[0]['ar'] = '1'; 				//értéke 1-8, a termék eladási ára //vagy 0 - a termék beszerzési ára
        //$paramt[0]['raktar_id'] = '2'; 			//Nem kötelező

            if(termek_keszlet($paramt)) {
                global $termek;
                $values = array(
                        'stock' => $termek[0],
                    );

                $this->db
                    ->where('sku', $cikkszam)
                    ->update('products', $values)
                    ;

            } else {
                //hiba
            }
    

}  
        
    
    
     
    
    
}