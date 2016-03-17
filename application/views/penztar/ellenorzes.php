<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<section class="main-wrap wrapper">

    <div id="ellenorzes" class="fokeret kek">
        <div id="termekoldal-termeknev" class="keret-cim kek">
            <h1>Megrendelés</h1>
        </div>
        <div class="clear"></div>





        <div id="kosar_lista_wrap">

            <h4>Szállítási adatok</h4>

            <table id="megrendelo_ell" class="osszesites-table">

                <tr>

            <?php 

                    echo "<td>Név: ";   
                    echo $order_details->name;
                    echo "</td>";

                    echo "<td>Cím: ";   
                    echo $order_details->zip . ' ';
                    echo $order_details->city . ' ';
                    echo $order_details->address . ' ';
                    echo "</td>";
                    
                    echo "<td>&nbsp;</td>";

            ?>

                </tr>
                
        <?php 
            if ($order_details->same_address != 1) {
                echo "<tr><td colspan='2'><h4>Számlázási adatok</h4></td></tr>";
                
                echo "<tr>";
                    echo "<td>Cég / név: ";
                    echo $order_details->bill_company . ' ';
                    echo "</td>";
                    echo "<td>Cím: ";   
                    echo $order_details->bill_zip . ' ';
                    echo $order_details->bill_city . ' ';
                    echo $order_details->bill_address . ' ';
                    echo "</td>";
                echo "</tr>";
            } 
        ?>

            </table>

            <div class="table_gomb_wrap" rowspan="5">
                <a class="icon-backspace szurke-gomb kis-gomb" href="/penztar">Szerkeszt</a>
            </div>
            
            
            <div class="kek-vonal-alul"></div>

            
            
            <h4>Szállítási és fizetési információk</h4>

            
            <table id="szallitas_ell" class="osszesites-table">


                <tr>
                    <td>Szállítási mód:</td> 
                    <td>
                    <?php echo $this->order_model->resolve_list_text('delivery_mode', $order_details->delivery_mode); ?>
                    </td>
                    <td>&nbsp;</td>
                    
                </tr>
                <tr>
                    <td>Fizetési mód:</td>
                    <td>
                    <?php echo $this->order_model->resolve_list_text('paying_method', $order_details->paying_method); ?>
                    </td>
                    <td><?php 
                        if ($utanvet > 0) {
                            echo "$utanvet  Ft";
                        } else {
                            echo "&nbsp;";   
                        }
                        
                        ?></td>
                    
                </tr>
                

                <?php
                if ($order_details->user_notes != '') {
                    echo "<tr>";
                    echo "<td>";
                    echo "Megjegyzés: ";
                    echo $order_details->user_notes;
                    
                    echo "</td>";
                    echo "</tr>";
                    
                    
                }    
                ?>
                
                
                
            </table>

            

            
            <div class="table_gomb_wrap" rowspan="5">
                <a class="icon-backspace szurke-gomb kis-gomb" href="/penztar/szallitas_fizetes">Szerkeszt</a>
            </div>
            
            <div class="kek-vonal-alul"></div>

            

            <h4>Összesítés</h4>


            <table id="ellenorzes_table" class="osszesites-table">

  

    <?php
        foreach ($this->cart->contents() as $items) : 


            $file_url = $this->product_model->get_product_field($items['id'], 'file_1_url');
            $thumb = thumb_name(TERMEKLISTA_THUMB_WIDTH, $file_url);
            $url_string = $this->product_model->get_product_field($items['id'], 'url_string');
            $short_desc = $this->product_model->get_product_field($items['id'], 'short_description');

        
            if (!empty($items['options'])) {
                
                $info = '<span class="ellenorzes_item_info">';
                
                    $i=0;
                    foreach($items['options'] as $key => $value) {
                        if ($i>0) $info .= ', ';
                        $info .= "$key:&nbsp;$value";
                        $i++;
                    }
                $info .= "</span>";
            } else {
                $info = '';    
            }
        

            if (empty($url_string)) {
                $url_string = $items['id'];
            }

?>
    
    
        <tr>
            <td><?php echo $items['name'] . $info; ?> </td>
            <td id="ell-price"> <?php echo $items['qty'] . ' x ' . number_format($items['price'], 0, ',', '.'); ?></td>
            <td><?php echo number_format($items['subtotal'], 0, ',', '.') . " Ft"; ?></td>
        </tr>
    
    
    
    
    <?php endforeach; ?>

        <?php if ($delivery_fee > 0) : ?>        
                <tr>
                    <td>Szállítási díj:</td>
                    <td>&nbsp;</td>
                    <td><?php echo number_format($delivery_fee, 0, ',', '.'); ?> Ft</td>
                </tr>

        <?php endif; ?>
                
            </table>
            

            <div class="table_gomb_wrap" rowspan="4">
                <a class="icon-backspace szurke-gomb kis-gomb" href="/kosar">Szerkeszt</a>
            </div>
            
            <div class="kek-vonal-alul"></div>

            
            
            <div id="vegosszeg">
                <div>Összesen:</div>
                <div><?php 
                    $total = $this->cart->total() + $delivery_fee + $utanvet;
                    echo number_format($total, 0, ',', '.') . " Ft"; 
                    ?></div>
            
            </div>
            
            
            
            
