<?php 
//szinkron
defined('BASEPATH') or exit('Access denied');

class Mpl_Base_model extends CI_Model {
 
    
    private $cs = 1; //csomagolas vastagsag
    private $paying_method, $delivery_mode;
    private $all_order_details;
    private $AFA = 1.27; 

    
    function __construct() {
        parent::__construct();   
        
        //$this->load->model('order_model');
        
        $this->order_id = $this->input->cookie('order_id');
        $this->all_order_details = $this->order_model->get_all_order_detail($this->order_id);
        $this->paying_method = $this->all_order_details->paying_method;
        $this->delivery_mode = $this->all_order_details->delivery_mode;
        $this->order_items = $this->order_model->get_order_items($this->order_id);
        $this->itemnum = $this->order_get_items_num();
        $this->init_fees();
        $this->tobb_csomag_per_cimzett = $this->order_get_items_num() > 1; 
        $this->total_goods = $this->all_order_details->total_goods;
        
        //a_print($this->all_order_details);
        
    }
    
    
    function calculate_fee() {
        
        $utanvet = $this->utanvet_dij() * $this->AFA;
        $delivery_fee = $this->get_delivery_fee();
        $delivery_fee = $this->add_extra_fees($delivery_fee);
        $delivery_fee *= $this->AFA;
        
        
        $delivery_fees = array(
            'delivery_fee'  =>  $delivery_fee,
            'utanvet' => $utanvet,
            'total_delivery' => $utanvet + $delivery_fee,
            'delivery_note' =>  $this->get_delivery_note(),
            'delivery_error' => $this->get_delivery_error(),
            );
        
        return $delivery_fees;
        
    }
    
    
    private function add_extra_fees($fee) {
        
        $erteknyilvanitasi_dij = $this->erteknyilvanitasi_dij();
        
        if ($this->order_is_terjedelmes())
            if ($this->tobb_csomag_per_cimzett) 
                $fee += $this->terjedelmes_felar_tobb_csomagra;
            else
                $fee *= $this->terjedelmes_szorzo_egy_csomagra;
        
        
        if ($erteknyilvanitasi_dij > 0)
            $fee += $erteknyilvanitasi_dij;
        
        return $fee;
        
    }
    
    
    private function get_delivery_fee() {
        if ($this->order_set_custom_postal_fee()) {
            return $this->order_set_custom_postal_fee();
        } 
        
        if (
            $this->delivery_mode == 'POS_PONT' OR 
            $this->delivery_mode == 'BOX_AUTO' OR
            $this->delivery_mode == 'POS_REST' 
        ) {
            return $this->get_fee_from_table('posta_pont_marado_es_automata_dijak');   
        }

        if ($this->delivery_mode == 'HOME_DLV') {
            
            if ($this->order_need_to_ask_custom_delivery()) {
                return 0;
            }

            if ($this->order_is_raklapos()) {
                return $this->get_fee_from_table('raklapos_kuldemenyek_alapdijai');   
            }
            
            return $this->get_fee_from_table('hazhoz_kezbesitesi_dijak');   
            
        }
        
        
    }
    
    
    private function get_fee_from_table($tabla) {
        
        $order_total_weight = $this->order_get_total_weight();
        $order_items_num = $this->order_get_items_num();
        $munkanap = KET_MUNKANAPOS;

        
            if ($tabla == 'raklapos_kuldemenyek_alapdijai') {

                foreach ($this->{$tabla} as $num_limit => $fee_row) {
                    if ($num_limit >= $order_items_num) {
                        $current_fee_row = $fee_row;
                        break;
                    }
                }


                return $current_fee_row[$munkanap];
            }
        
            foreach ($this->{$tabla} as $weight_limit => $fee_row) {
                if ($weight_limit >= $order_total_weight) {
                    $current_fee_row = $fee_row;
                    break;
                }
            }
        
        
        if ($order_items_num > 1)
            $csomagszam = TOBB_CSOMAG_PER_CIM;
        else 
            $csomagszam = EGY_CSOMAG_PER_CIM;
        
        
        if ($tabla == 'hazhoz_kezbesitesi_dijak') 
            return $current_fee_row[$munkanap][$csomagszam];
            
        
        if (
            $this->delivery_mode == 'POS_PONT' OR 
            $this->delivery_mode == 'BOX_AUTO'
        )   $postahely = POSTAPONT_BOX;
            
        if (
            $this->delivery_mode == 'POS_REST' 
        )   $postahely = POSTAN_MARADO;
            
            
        if ($tabla == 'posta_pont_marado_es_automata_dijak') 
            return $current_fee_row[$munkanap][$postahely][$csomagszam];

   
        
    }
    
    
    private function get_delivery_note() {

        $n = $this->order_get_total_weight() . '&thinsp;kg ';
        
        if ($this->order_get_items_num() > 1) $n .= '&middot; több&nbsp;csomag&thinsp;/&thinsp;címzett ';
        else
        $n .= '&middot; egy&nbsp;csomag&thinsp;/&thinsp;címzett ';
        
        if ($this->order_set_custom_postal_fee()) $n = 'termékspecifikus szállítási ár';
        else
        if ($this->order_need_to_ask_custom_delivery()) $n = 'egyedi árajánlat alapján szállítható';
        else
        if ($this->order_is_raklapos()) $n = 'raklapos';
        
        if ($this->delivery_mode == 'POS_PONT') $n .= ' &middot; PostaPont';                
        
        if ($this->delivery_mode == 'BOX_AUTO') $n .= ' &middot; csomagautomata';                
        
        if ($this->delivery_mode == 'HOME_DLV') $n .= ' &middot; házhoz&nbsp;kézbesítés';      
        
        if ($this->order_is_terjedelmes()) $n .= ' &middot; terjedelmes';
        
        $n .= ' &middot; 2&nbsp;munkanapos';
        
        if ($this->erteknyilvanitasi_dij() > 0) $n .= ' &middot; extra&nbsp;értéknyilvánítás';
        
        return $n;
        
        
    }

    
    private function item_is_raklapos($item) {
        if ($item->att_weight > 40) 
            return true;   
        return false;
    }
    
    
    private function order_is_raklapos() {
        foreach ($this->order_items as $item) 
            if ($this->item_is_raklapos($item)) 
                return true;
        
        
        return false;
    }
    
        
    private function item_has_custom_postal_fee($item) {
        if ($item->custom_postal_fee != NULL) 
            return $item->custom_postal_fee;
        return false;
    }
    
    
    private function item_is_terjedelmes($item) {
        $w = $item->dim_width;
        $h = $item->dim_height;
        $l = $item->dim_length;
        $d = $item->dim_depth;
        $a = $item->dim_diagonal;
        
        if (max($w,$h,$l,$d,$a) + 2 * $this->cs > 75) return true;
        if ($w+$h+$l+$d + 6 * $this->cs > 200 ) return true;
        
        return false;

    }
    
    
    private function order_is_terjedelmes() {
        foreach ($this->order_items as $item) {
            if ($this->item_is_terjedelmes($item)) return true;
        }
        
        return false;
        
    }
    
    
    private function item_need_to_ask_custom_delivery($item) {
        $w = $item->dim_width;
        $h = $item->dim_height;
        $l = $item->dim_length;
        $d = $item->dim_depth;
        $a = $item->dim_diagonal;
        
        if (max($w,$h,$l,$d,$a) + 2 * $this->cs > 200) return true;
        if ($w+$h+$l+$d+2*$a + 6 * $this->cs > 300) return true;
        
    }
    
    
    private function order_need_to_ask_custom_delivery() {
        foreach ($this->order_items as $item) {
            if ($this->item_need_to_ask_custom_delivery($item)) return true;
        }
        
        return false;
    }
    
    
    private function order_set_custom_postal_fee() {
        
        if ($this->itemnum != 1) return false;
        
        $item = $this->order_items[0];

        $item_has_custom_postal_fee = $this->item_has_custom_postal_fee($item);
        
        if ($item_has_custom_postal_fee) 
            return $item_has_custom_postal_fee;
        
        return false;
    }
    
    
    private function item_postapont_ok($item) {
        if($item->att_weight > 20) return false;
            return true;
        }
    
    
    private function order_postapont_ok() {
        foreach ($this->order_items as $item) {
            if (!$this->item_postapont_ok($item)) return false;
        }
        
        return true;
    }
        
    
    private function item_csomagautomata_ok($item) {
        $w = $item->dim_width;
        $h = $item->dim_height;
        $l = $item->dim_length;
        $d = $item->dim_depth;
        $a = $item->dim_diagonal;
        
        if($item->att_weight > 20) return false;
        
        $cuboid = array($w, $h, $l, $d, $a);
        
        rsort($cuboid);    

        if ($cuboid[0] + $this->cs * 2 > 50) return false;

        if ($cuboid[1] + $this->cs * 2 > 35) return false;

        if ($cuboid[2] + $this->cs * 2 > 31 ) return false;
        
    }
    
    
    private function order_csomagautomata_ok() {
        foreach ($this->order_items as $item) {
            if (!$this->item_csomagautomata_ok($item)) return false;
        }
        
        return true;
    }
    
    
    private function order_get_total_weight() {
        $total_weight = 0;
        
            foreach ($this->order_items as $item) {
                $total_weight += $item->att_weight * $item->qty;
            }
        
        return $total_weight;
    }
    
    
    private function order_get_items_num() {
        $items_qty = 0;
            foreach ($this->order_items as $item) {
                $items_qty += $item->qty;
            }
        
        return $items_qty;
    }
        
    
    private function get_delivery_error() {
        
        
        if ($this->all_order_details->delivery_mode == 'HOME_DLV' AND $this->order_need_to_ask_custom_delivery()) 
            return  'A küldemény csak a futárszolgálat előzetes árajánlata alapján szállítható. Kérjük, vegye fel velünk a kapcsolatot a rendelés véglegesítéséhez.';
            
        if ($this->all_order_details->delivery_mode == 'POS_PONT' AND ! $this->order_postapont_ok()) 
            return 'A küldemény súlya meghaladja a PostaPonton engedélyezett csomagonkénti 20kg-os határt.';

        if ($this->all_order_details->delivery_mode == 'BOX_AUTO' AND ! $this->order_csomagautomata_ok()) 
            return 'A küldemény súlya vagy mérete meghaladja a csomagautomatánál engedélyezettet.';
        
      
        return false;
        
    }
    
    
    private function utanvet_dij() {
        if ($this->paying_method == 'PAY_RECV') 
            return $this->utanvet;
        return 0;
    }
    
    
    private function erteknyilvanitasi_dij() {
        $ertekhatar_felett = $this->total_goods - $this->erteknyilvanitas_alapdijas_hatar;
    
        if ($ertekhatar_felett > 0) 
           return ceil($ertekhatar_felett / 10000)*$this->erteknyilvanitas_potdij_10ekent;            
        
        return 0;
        
    }
    
    
    
}