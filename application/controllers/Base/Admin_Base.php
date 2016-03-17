<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Base extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();        
        $this->load->library('grocery_CRUD');
        $this->load->model('admin_model');
        $this->load->library('image_lib');        
        
        $this->login_check();
        
    }
    
    
    public function login_check() {
        
        $uri = $this->uri->uri_string();
        
            if ($uri !== 'admin/login' && ! $this->authentication->is_loggedin()) {  
                redirect('/admin/login');
            } 
}
    

	public function index() {
        redirect('admin/products');

	}
    
    
    public function products() {
        $output = $this->admin_model->products();     
        
            $this->load
                ->view('admin/head', $output)
                ->view('admin/output')
                ->view('admin/product-js')
                ;
        
    }
        
    
    public function login() {
        if ($this->input->post('username')) {
            $user = $this->input->post('username');
            $pass = $this->input->post('password');
            
                if ($this->authentication->login($user, $pass)) {
                    redirect('admin/products');
                } else {
                    echo "Hibás belépési adatok";
                }
        }
        $this->load->view('admin/login');
    }
    
    
    public function logout() {
        $this->authentication->logout();   
        redirect('admin/login');
    }
    
    
    public function categories() {
        $output = $this->admin_model->categories();     
        
        $this->load->view('admin/head', $output);        
        $this->load->view('admin/output');

    }
    
    
    public function subcategories() {
        $output = $this->admin_model->subcategories();            
        $this->load->view('admin/head', $output);        
        $this->load->view('admin/output');
    }
    

    public function crop($img) {
        
        if ($this->input->post()) {

                foreach($this->input->post() as $key => $value) {
                    $$key = $value;
                    echo $key . ' = ' . $value . "<br>";
                }


        }            

        $data['css'] = "/assets/css/crop.css";
        $data['cropjs'] = "/assets/js/crop.js";
        $data['img'] = "/" . PICTURE_UPLOAD_DIR . $img . ".jpg";
        $this->load->view('admin/crop', $data);
    }
    
    
    public function batch_resize() {
        $this->admin_model->batch_resize('assets/uploads/files/tobbi');
        
    }

    
    public function orders($view = '') {
        $output = $this->admin_model->orders($view);        
        $this->load->view('admin/head', $output)
            ->view('admin/output')
            ->view('admin/foot')
            ;
    }
    
    
    public function slider() {
        $output = $this->admin_model->sliders();        
        $this->load->view('admin/head', $output)
            ->view('admin/output')
            ->view('admin/foot')
            ;
    }
    
    
    public function opciok($id = NULL){
        $output = $this->admin_model->product_options($id);     
        $this->load
            ->view('admin/head', $output)    
            ->view('admin/output')
            ->view('admin/opciok-js')
            ;

    }
    
    
    public function duplicate($id) {
        
        $table = 'products'; 
        $id_field = 'id';
        // load the original record into an array
        $result = $this->db->query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
        $original_record = $result->row_array();

        // insert the new record and get the new auto_increment id
        $this->db->query("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
        $newid = $this->db->insert_id();

        // generate the query to update the new record with the previous values
        $query = "UPDATE {$table} SET ";
        
            foreach ($original_record as $key => $value) {
                if ($key != $id_field) {
                    $query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
                }
            } 
        
        $query = substr($query,0,strlen($query)-2); // lop off the extra trailing comma
        $query .= " WHERE {$id_field}={$newid}";
        $this->db->query($query);
        
        $query = "UPDATE $table SET url_string = CONCAT(url_string, '_$newid') WHERE id = $newid;";
        $this->db->query($query);
        
        $this->db
            ->where('id', $newid)
            ->update('products', array(
                'file_1_url' => '',
                'file_2_url' => '',
                'file_3_url' => '',
                'file_4_url' => '',
                'file_5_url' => '',
                ))
            ;
            
    redirect('/admin/products');
        
            
    }
    
    
    public function product_groups() {
        $output = $this->admin_model->product_groups();        
        $this->load
            ->view('admin/head', $output)
            ->view('admin/output')
            ->view('admin/opciok-js')
            
            ;
        
        
    }
    
    
    public function textpages() {
        $output = $this->admin_model->textpages();        
        $this->load->view('admin/head', $output)
            ->view('admin/output')
            ->view('admin/foot')
            ;
    }
    
    
    public function attribute_by_sku($id) {
        $output = $this->admin_model->attribute_by_sku($id);     
        
            $this->load
                ->view('admin/head', $output)
                ->view('admin/output')
                ->view('admin/opciok-js')
                ;
        
    }
    
    
    
}
