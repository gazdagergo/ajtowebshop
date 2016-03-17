<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

$delivery_fee = isset($delivery_fee) ? $delivery_fee : 0;
$utanvet = isset($utanvet) ? $utanvet : 0;

$cart_total = $this->cart->total();
$total = $cart_total + $delivery_fee + $utanvet;
?>

<div id="osszesites">
            <h3>Összesítés</h3>
            
            <table>
                
                <tr class="sub">
                    <td>
                        Termékek:
                    </td>
                    <td>
                        <?php echo number_format($cart_total, 0, ',', '.') . " Ft"; ?>
                    </td>
                
                </tr>
                
            <?php if ($delivery_fee > 0) : ?>
                
                <tr class="sub">
                    <td>
                        Szállítás:
                    </td>
                    <td>
                        <?php echo number_format($delivery_fee, 0, ',', '.') . " Ft"; ?>
                    </td>
                
                </tr>
                
            <?php endif; ?>
                
            <?php if ($utanvet > 0) : ?>
                
                <tr class="sub">
                    <td>
                        Utánvéti díj:
                    </td>
                    <td>
                        <?php echo number_format($utanvet, 0, ',', '.') . " Ft"; ?>
                    </td>
                
                </tr>
                
            <?php endif; ?>
                
                <tr class="total">
                    <td>
                        Összesen:
                    </td>
                    <td>
                        <?php echo number_format($total, 0, ',', '.') . " Ft"; ?>
                    </td>
                </tr>
            </table>
            
        </div>
            
            <div class="clear"></div>

            

        
</section>