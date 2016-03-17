<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

    <section class="wrapper main-wrap">

        <div id="kapcsolat" class="fokeret kek">
            <div class="keret-cim kek">
                <h1>KAPCSOLAT</h1>
            </div>

            <div class="clear"></div>
            
            <div class="keret-hasab hasab-50">
                <div id="cim-adatok">
                    
                    <h3>AJTÓ WEBSHOP | átvevő telephely</h3>
                    <p>1103 Budapest, Gyömrői út 76-80. </p>
                    <p>Tel: <a href="tel:+3612812807">+36 1 281 2807 </a></p>
                    <p>Mobil: <a href="tel:+36203388807">+36 20 33 888 07</a></p>
                    <p>E-mail: <a href="mailto:info@ajtowebshop.hu">info@ajtowebshop.hu</a></p>
                
                </div>     
                
                
<!--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2696.936339545293!2d19.07429031562581!3d47.471669979175836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dd032bcf5e35%3A0x6c946d53dd5eecaa!2zVsOhZ8OzaMOtZCB1LiAzLCBCdWRhcGVzdCwgMTA5Nw!5e0!3m2!1sen!2shu!4v1449742329508" width="100%" height="305" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2697.1117940084923!2d19.1472236156257!3d47.46825087917572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741c318986978d9%3A0xffed2791b22f296c!2zR3nDtm1yxZFpIMO6dCA3NiwgQnVkYXBlc3QsIDExMDM!5e0!3m2!1sen!2shu!4v1456895404048" width="100%" height="305" frameborder="0" style="border:0" allowfullscreen></iframe>            
                
       
            </div>
            <div class="keret-hasab hasab-50">
                
                <?php 
                
                echo form_open('', array('id' => 'uzenet-form'));
                
                echo form_label(
                    'Név / cégnév *', 
                    'kapcsolat_nev', 
                        array(
                            'class' => 'block'
                        )
                );
                
                echo form_error('kapcsolat_nev');

                echo form_input(array(
                        'class' => 'szeles',
                        'type'  =>  'text',
                        'id'    =>  'kapcsolat_nev',
                        'name'  =>  'kapcsolat_nev',
                        'value' =>  set_value('kapcsolat_nev'),
                    )
                );
                
                echo form_label(
                    'E-mail cím *', 
                    'kapcsolat_email', 
                        array(
                            'class' => 'block'
                        )
                );
                
                echo form_error('kapcsolat_email');
                
                echo form_input(array(
                        'class' => 'szeles',
                        'type'  =>  'email',
                        'id'    =>  'kapcsolat_email',
                        'name'  =>  'kapcsolat_email',
                        'value' =>  set_value('kapcsolat_email'),
                    )
                );
                
                echo form_label(
                    'Telefonszám *', 
                    'kapcsolat_phone', 
                        array(
                            'class' => 'block'
                        )
                );
                
                echo form_error('kapcsolat_phone');

                echo form_input(array(
                        'class' => 'szeles',
                        'type'  =>  'text',
                        'id'    =>  'kapcsolat_phone',
                        'name'  =>  'kapcsolat_phone',
                        'value' =>  set_value('kapcsolat_phone'),
                    )
                );
                
                
                echo form_label(
                    'Üzenet', 
                    'kapcsolat_message', 
                        array(
                            'class' => 'block'
                        )
                );

                
                echo form_textarea(
                    array(
                        'class' => 'szeles',
                        'id'    =>  'kapcsolat_uzenet',
                        'name'  =>  'kapcsolat_uzenet',
                        'value' =>  set_value('kapcsolat_uzenet'),
                        )
                );
                
                
                echo form_input(
                    array(
                        'id'    =>  'uzenet-kuld',
                        'name'  =>  'kapcsolat_submit',
                        'class' =>  'kek-gomb nagy-gomb icon-pipa keret-aljara',
                        'type'  =>  'submit',
                        'value' =>  'Elküldöm',
                        )
                    );
                
                echo '<div id="kapcsolat_response" class="'.$resp_class.'">'.$response.'</div>';                  
                
                echo form_close();
                
                ?>
                
                
                
            </div>
            
            
        </div>
    <?php echo $gombok; ?>
    </section>

