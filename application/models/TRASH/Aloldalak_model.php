<?php
defined('BASEPATH') or exit('Access denied');

class Aloldalak_model extends CI_Model {
    
 
    private $user; 
    
    function __construct() {
        parent::__construct();
        $this->user = $this->authentication->read('identifier');   
    }
    
        
    function get_adatok() {
        
        $this->db->where('id', $this->user);
        $query = $this->db->get('users');
        
        $result = $query->result();
           
        return $result;
    }
    
    
    function update_adatok() {
        
        $data = array('lastname' =>     $this->input->post('lastname'),
                      'firstname' =>    $this->input->post('firstname'),
                      'company' =>      $this->input->post('company'),
                      'city' =>         $this->input->post('city'),
                      'address1' =>     $this->input->post('address1'),
                      'county' =>       $this->input->post('county'),
                      'zip' =>          $this->input->post('zip'),
                      'email' =>        $this->input->post('email'),
                      'phone' =>       $this->input->post('phone1'),
                      'phone2' =>       $this->input->post('phone2')
                );
        
        $this->db->where('id', $this->user);
        $this->db->update('users', $data);
        
    }

    
    function insert_user() {
        
         $datum = $this->getDateString();
        
        $data = array('lastname' =>     $this->input->post('lastname'),
                      'firstname' =>    $this->input->post('firstname'),
                      'company' =>      $this->input->post('company'),
                      'city' =>         $this->input->post('city'),
                      'address1' =>     $this->input->post('address1'),
                      'county' =>       $this->input->post('county'),
                      'zip' =>          $this->input->post('zip'),
                      'email' =>        $this->input->post('email'),
                      'phone' =>       $this->input->post('phone1'),
                      'phone2' =>       $this->input->post('phone2'),
                      'pass' =>       $this->input->post('pass1'),
                      
                      'del_lastname' =>     $this->input->post('lastname'),
                      'del_firstname' =>    $this->input->post('firstname'),
                      'del_company' =>      $this->input->post('company'),
                      'del_city' =>         $this->input->post('city'),
                      'del_address1' =>     $this->input->post('address1'),
                      'del_county' =>       $this->input->post('county'),
                      'del_zip' =>          $this->input->post('zip'),
                      'del_phone' =>        $this->input->post('phone1'),
                      'del_phone2' =>       $this->input->post('phone2'),
                      
                      'date' => $datum
                );
        
        $olvasas = $this->input->post('olvasas');
        
            if ($olvasas == 'Th96rx') {

                $this->db->insert('users', $data);
                return 'ok';
               
            } else {
                return 'A beírt biztonsági kód nem megfelelő';   
            }
        
    }
    
    
    function cimmodositas() {
        
        $data = array('del_lastname' =>     $this->input->post('lastname'),
                      'del_firstname' =>    $this->input->post('firstname'),
                      'del_company' =>      $this->input->post('company'),
                      'del_city' =>         $this->input->post('city'),
                      'del_address1' =>     $this->input->post('address1'),
                      'del_county' =>       $this->input->post('county'),
                      'del_zip' =>          $this->input->post('zip'),
                      'del_phone' =>        $this->input->post('phone1'),
                      'del_phone2' =>       $this->input->post('phone2')
                );
        
        
        $this->db->where('id', $this->user);
        $this->db->update('users', $data);
        
    }    
    
    
    function get_szallitasi_cim() {
     


        $TXT ="<div id='cim-wrap text-wrap'>
                <h3>Szállítási cím</h3>";

            $TXT .= $this->get_delivery_field_value('lastname') . ' ';
            $TXT .= $this->get_delivery_field_value('firstname') . '<br>';
            $TXT .= $this->get_delivery_field_value('company') . '<br>';
            $TXT .= $this->get_delivery_field_value('zip') . ' ';
            $TXT .= $this->get_delivery_field_value('city') . ', ';
            $TXT .= $this->get_delivery_field_value('address1');
                
            $TXT .= "</div>";
        
        return $TXT;
    }
    
    
    function print_korabbi_rendelesek(){
        
       $TXT ="                                   
       <div class='row'>
            <div>Terméknév</div>
            <div>Azonosító</div>
            <div>Dátum</div>
            <div>Állapot</div>
            <div></div>
        </div>";
        
        $userid = $this->authentication->read('identifier');
						
            $query = $this->db->query("SELECT * FROM orders WHERE user_id = '$userid'");

            foreach ($query->result() as $user_row) {
                            $prod_id = $user_row->item_num;


                    $TXT .= "<div class='row'>";


                        $query2 = $this->db->query("SELECT * FROM products WHERE id = '$prod_id'");
                            foreach ($query2->result() as $prod_row) {
                                    $TXT .= "<div>$prod_row->name</div>";
                        }

                    $TXT .= "<div>$user_row->order_num</div><div>$user_row->date</div><div>$user_row->stat</div><div></div></div>";

                }

        
        return $TXT;
    
        
    }
    
    
    function print_talalatok() {
        
        ob_start();
                $search = $this->input->post('search');
				 
				$count = 0;
				$query = $this->db->query("SELECT * FROM products WHERE (name LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%')");
				foreach ($query->result() as $row) {
					$count++;
					}

			
			echo "<div id='search_title' style='text-transform: none;'>
                Keresés:  $search
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Találatok:  $count <span style='text-transform: lowercase;'>db</span><br /><br />
			</div>";
			
        
                    foreach ($query->result() as $row) {    
							
                        if ($row->type == 1) {
                        
						echo "<div class='result'>
								<a href='termekek?id=$row->id'>$row->name</a>
							</div>";
                            
                        } else {

                            echo "<div class='result'>
								<a href='ajandekok?id=$row->id'>$row->name</a>
							</div>";
                            
                        }
 

                    }
        
						if ($count == 0) {
							echo '<div id="list_main"><span style="margin: 20px; display: block;">Sajnos nincs találat!</span></div>';
						}
        
        	$TXT = ob_get_contents();
        ob_end_clean();
        
        return $TXT;
        
    }
    
      
    function print_jelszokeres() {

        ob_start();
        echo '
        
        
            <form action="/jelszokeres" id="jelszo-form" method="post">
                <p>Kérjük, adja meg az e-mail címét. Az új jelszót e-mailben küldjük ki.</p>

                <input type="email" id="jelszokeres" name="jelszokeres" placeholder="Email cím" />
                <div class="clear"></div>
                <div class="button" id="kodfeltoltes_gomb" onclick="$(this).closest(\'form\').submit();">Új jelszót kérek</div>

                <div class="uzenet" id="kod_valasz">
                    <?php 
                        if (isset($valasz)) echo $valasz; 
                    ?>
                </div>
            
            </form>

';
       
        $TXT = ob_get_contents();
        ob_end_clean();
        
        return $TXT;
        
    }
    
    
    function afterRegisterText() {
        
        $TXT = '<h3>Üdvözüljük a 3M hűségprogramban</h3>';
        $TXT .= '<p>Rendszerünk egy emailt küldött Önnek, amellyel aktiválhatja hozzáférését.</p>';
        
        return $TXT;
    }
    
    
    function check_if_registered($field){
        $value = $this->input->post($field);
        $query = $this->db->get_where('users', array($field => $value));
        
        if ($query->num_rows()) {
            return true;
        }
    }
    
    
    public function aktivalas($email) {
        
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        
        
            if ($email == '') {
                return "Hibás aktivációs link.";
            }
        
            foreach ($query->result() as $row) {
                $password = $row->pass;   
                $active = $row->active;
            }
        
            if ($query->num_rows() == 0) {  
                return "Hiba: A felhasználó még nem regisztrált.";
            }
        
            if ($active == 1) {
                return "A felhasználó már korábban aktiválásra került.";
            } else {
                $this->db->where('email', $email);
                $this->db->update('users', array('active' => 1));
                $this->authentication->login($email, $password);
                $dateString = $this->rendeles_model->getDateString();
                $code = $this->generateRandomString();
                $this->db->insert('vouchers', array('code' => $code, 'value' => 50, 'date_created' => $dateString));
                $this->email_model->emailAfterActivation($code, $email);
                
                return "Felhasználói fiókját aktiváltuk.";   
            }
        
        
    }
    
  
    public function inaktivFelhasznaloTorlese($email) {
        $this->db->where('email', $email);
        $this->db->where('active', 0);
        $result =  $this->db->get('users');
        
        if ($result->num_rows() > 0) {
            $this->db->where('email', $email);
            $this->db->select('id');
            $row = $this->db->get('users')->result();
            if ($this->db->query("DELETE FROM `users` WHERE `id` = " . $row[0]->id))  {
                return $email . " email címmel a regisztrációt töröltük.";
            } else {
                return $this->db->_error_message();   
            }
        } else {
            return "A megadott email cím nem szerepel az adatbázisban, vagy a felhasználót már aktiválták";   
        }
        
        
            
        
    }
    
    
    private function generateRandomString($length = 8) {
        $characters = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';

        $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
        return $randomString;

    }    
    
          
    private function get_delivery_field_value($field){
        $this->db->where('id', $this->user);
        $query = $this->db->get('users'); 
        
            foreach ($query->result() as $row) {        
                $varname = "del_$field";
                $fieldvalue = $row->$varname == '' ? $row->$field : $row->$varname;
            }
        return $fieldvalue;        
    }
    
    
    private function getDateString() {
        $datestring = "%Y.%m.%d-%h.%i";
        $time = time();
        return mdate($datestring, $time);
    }
    
    
    
}