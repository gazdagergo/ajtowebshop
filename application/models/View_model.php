<?php
defined('BASEPATH') or exit('Access denied');

class View_model extends CI_Model {
    
    function get_minta_file($minta_opcio_url, $product_id) {
        
        $query = $this->db
            ->where('url_string', $minta_opcio_url)
            ->where('product_id', $product_id)
            ->get('product_options')
            ;

        if ($query->num_rows() > 0) {
            return 
                $query
                    ->row()
                    ->file_url;
            
        }
        
    }
    
    function get_minta_file_by_text($minta_opcio_txt, $product_id) {
        
        $query = $this->db
            ->like('option_text', $minta_opcio_txt, 'none')
            ->where('product_id', $product_id)
            ->get('product_options')
            ;

        if ($query->num_rows() > 0) {
            return 
                $query
                    ->row()
                    ->file_url;
            
        }
        
    }
    
    public function get_galeria($gallery_name) {
        $output = '';
        
        $query = $this->db
            ->where('gallery', $gallery_name)
            ->get('sliders')
            ;
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                  $output .=  '<a href="/' . $row->href . '"><img src="' . PICTURE_UPLOAD_DIR . '/' . $row->file_url . '" alt="Offer" /></a>';
 
            }
        }
        
        return $output;
    }

    
    public function szovegoldal_body($oldal, $data = array(), $body_views = array(), $add_html = '') {

        $query = $this->db
            ->where('url', $oldal)
            ->get('textpages')
            ;
        
        if (file_exists(APPPATH."views/szovegoldalak/{$oldal}.php")) {
            $this->load->view("szovegoldalak/$oldal", $data);
        }
        else 
        if ($query->num_rows() > 0) {
            $data['html'] = $this->etc_model->html_codes($query->row()->html, $data);
            $data['keretcim'] = $query->row()->header;
            
            if ($add_html != '') 
                $data['html'] .= $add_html;
            
            $this->load->view("szovegoldalak/szovegoldal", $data);            
        } else {
            $this->load->view("szovegoldalak/404");            
        }
        
        if (!empty($body_views)) {
            foreach ($body_views as $body_view) {
                $this->load->view($body_view);   
            }
        }
        
    }    
    
    
    public function footer() {
        $data['foot_menu'] = $this->product_model->print_categories('foot-menu', TRUE);
        $this->load
            ->view('footer/footer', $data)
            ->view('footer/scrolling')
            ->view('footer/analytics')
            ->view('footer/perhtml')
            ;
    }
    
    
}