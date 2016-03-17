<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<section class="wrapper">

    <div id="productlist" class="fokeret kek">

        <div id="productlist-header">
            <h3 class="icon-cart">Kosár</h3>

            <div class="szuresek">

            </div>

        </div>


        <div class="clear"></div>

        <div class="productlist-body">


            <form action="" method="post" class="product self_submit">
                <div class="kosar-sor">

                    <a href="">
                        <img class="product_thumb" alt="Ablak1" src="/uploads/files/ablak1-90.jpg" />
                    </a>
                    <div class="price_wrap">
                        <span itemprop="name">Huhho műanyag ablak</span>
                        <span itemprop="price">18.990.- Ft/db</span>
                        <span itemprop="description" class="product-desc">Quisque tempor commodo purus ullamcorper feugiat.</span>

                        <table class="subtotal_table product-desc">
                            <tr>
                                <td>
                                    <label>Mennyiség:</label>
                                </td>
                                <td>
                                    <input class="qty_inp" name="qty" value="1" type="number">
                                </td>
                                <td class="subtotal">
                                    Összesen: 18.990.- Ft
                                </td>
                            </tr>
                        </table>

                    </div>


                    <input class="szurke-gomb torles-gomb" name="call_just_this_main_function" type="submit" value="Törlés" />

                    <input name="call_main_function" value="updateCart" type="hidden">
                    <input name="rowid" value="45c48cce2e2d7fbdea1afc51c7c6ad26" type="hidden">
                    <input name="product_id" value="9" type="hidden">


                </div>
            </form>

            <form action="" method="post" class="product self_submit">

                <div class="kosar-sor">

                    <a href="">
                        <img class="product_thumb" alt="Ablak1" src="/uploads/files/ablak1-90.jpg" />
                    </a>
                    <div class="price_wrap">
                        <span itemprop="name">Huhho műanyag ablak</span>
                        <span itemprop="price">18.990.- Ft/db</span>
                        <span itemprop="description" class="product-desc">Quisque tempor commodo purus ullamcorper feugiat.</span>

                        <table class="subtotal_table product-desc">
                            <tr>
                                <td>
                                    <label>Mennyiség:</label>
                                </td>
                                <td>
                                    <input class="qty_inp" name="qty" value="1" type="number">
                                </td>
                                <td class="subtotal">
                                    Összesen: 18.990.- Ft
                                </td>
                            </tr>
                        </table>

                    </div>


                    <input class="szurke-gomb torles-gomb" name="call_just_this_main_function" type="submit" value="Törlés" />

                    <input name="call_main_function" value="updateCart" type="hidden">
                    <input name="rowid" value="45c48cce2e2d7fbdea1afc51c7c6ad26" type="hidden">
                    <input name="product_id" value="9" type="hidden">


                </div>
            </form>

            <form action="" method="post" class="product self_submit">

                <div class="kosar-sor">

                    <a href="">
                        <img class="product_thumb" alt="Ablak1" src="/uploads/files/ablak1-90.jpg" />
                    </a>
                    <div class="price_wrap">
                        <span itemprop="name">Huhho műanyag ablak</span>
                        <span itemprop="price">18.990.- Ft/db</span>
                        <span itemprop="description" class="product-desc">Quisque tempor commodo purus ullamcorper feugiat.</span>

                        <table class="subtotal_table product-desc">
                            <tr>
                                <td>
                                    <label>Mennyiség:</label>
                                </td>
                                <td>
                                    <input class="qty_inp" name="qty" value="1" type="number">
                                </td>
                                <td class="subtotal">
                                    Összesen: 18.990.- Ft
                                </td>
                            </tr>
                        </table>

                    </div>


                    <input class="szurke-gomb torles-gomb" name="call_just_this_main_function" type="submit" value="Törlés" />

                    <input name="call_main_function" value="updateCart" type="hidden">
                    <input name="rowid" value="45c48cce2e2d7fbdea1afc51c7c6ad26" type="hidden">
                    <input name="product_id" value="9" type="hidden">


                </div>
            </form>

        </div>
        
        <div class="clear"></div>

        <div id="productlist-footer">
            <p>Összesen: 86.960.- Ft</p> 
            <a id="penztarhoz" class="kek-gomb nagy-gomb icon-pipa keret-aljara">Tovább a pénztárhoz</a>
                
        </div>

        
        
    </div>
    
        <?php echo $gombok; ?>
    
</section>