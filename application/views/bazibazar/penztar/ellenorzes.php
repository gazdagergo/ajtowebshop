<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section id="kosar_wrap" class="wrapper content_wrapper">
    
    <h3>Megrendelés</h3>

            <div id="kosar_lista_wrap">

                <h4>Szállítási adatok</h4>
                
    <table id="megrendelo_ell">
                
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

            ?>
            <td class="table_gomb_wrap" rowspan="5">
                <a class="altalanos_gomb szurke_gomb kis_gomb" href="/penztar">Szerkeszt</a>
            </td>
        
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
        
        <?php 
                echo "<tr><td colspan='2'><h4>Szállítási és fizetési információk</h4></td></tr>";
                echo "<tr>";
                    echo "<td>Szállítási mód: ";
                    echo $this->order_model->resolve_list_text('delivery_mode', $order_details->delivery_mode);
                    echo "</td>";
                    echo "<td>Fizetési mód: ";   
                    echo $this->order_model->resolve_list_text('paying_method', $order_details->paying_method);

                    echo "</td>";

                echo "</tr>";

        ?>
        
        
                
    </table>
                
                
    <table id="ellenorzes_table">
        
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="table_gomb_wrap" rowspan="4">
                <a class="altalanos_gomb szurke_gomb kis_gomb" href="/kosar">Szerkeszt</a>            
            </td>
        </tr>
        
        
    <?php
        foreach ($this->cart->contents() as $items) : 


            $file_url = $this->product_model->get_product_field($items['id'], 'file_1_url');
            $thumb = thumb_name(TERMEKLISTA_THUMB_WIDTH, $file_url);
            $url_string = $this->product_model->get_product_field($items['id'], 'url_string');
            $short_desc = $this->product_model->get_product_field($items['id'], 'short_description');

        
            if (!empty($items['options'])) {
                
                $info = '<span class="ellenorzes_item_info"> - ';
                
                    $i=0;
                    foreach($items['options'] as $key => $value) {
                        if ($i>0) $info .= ', ';
                        $info .= "$key: $value";
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
            <td> <?php echo $items['qty'] . ' x ' . number_format($items['price'], 0, ',', '.'); ?></td>
            <td><?php echo number_format($items['subtotal'], 0, ',', '.') . " Ft"; ?></td>
        </tr>
    
    
    
    
    <?php endforeach; ?>
    
        
    </table>


