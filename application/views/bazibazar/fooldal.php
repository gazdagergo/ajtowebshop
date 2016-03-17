<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>



<section class="wrapper" id="slide_wrap">
    <div id="fooldal_slider_img_wrap">
        <img id="sliderImg" src="/assets/images/fooldal-slider.jpg" alt="stockphoto" />
    </div>
</section>


<section id="montazs_wrap" class="wrapper">

    <div>
<!--        <img src="/assets/images/montazs/montazs1_01.jpg" width="484" height="138" alt="" />
    </div>
    <div>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_03.jpg" width="293" height="369" alt="" />
        </a>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_04.jpg" width="594" height="369" alt="" />
        </a>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_05.jpg" width="183" height="369" alt="" />
        </a>
    </div>
    <div>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_06.jpg" width="274" height="214" alt="" />
        </a>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_07.jpg" width="334" height="214" alt="" />
        </a>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_08.jpg" width="279" height="214" alt="" />
        </a>
        <a href="#">
            <img src="/assets/images/montazs/montazs1_09.jpg" width="183" height="214" alt="" />
        </a>-->
        <a href="/mindenunk"><img src="/assets/images/montazs/feherkaracsony.jpg" style="width:100%;border:none;" /></a>
        
    </div>




</section>



<section class="wrapper" id="stilus_wrap">

    <?php 
        $column = 0;
        foreach ($kategoriak as $kategoria) : 
    
            $column += (1 / $kategoria->columns);
    ?>
    
        <div class="style_img_col col_<?php echo $kategoria->columns; ?><?php echo $column == 1 ? ' lastChild' : ''; ?>">
            <a href="<?php echo $kategoria->url_string; ?>">
                <img src="/<?php echo PICTURE_UPLOAD_DIR . $kategoria->file_url; ?>" alt="stilus" />
                <span><?php echo $kategoria->category; ?></span>
            </a>
        </div>    
    
    
    <?php endforeach; ?>
    
    
    
<!--

        <div class="style_img_col col_4">
            <a href="">
                <img src="/assets/images/kat1.jpg" alt="stilus" />
                <span>Asztalok</span>
            </a>
        </div>

        <div class="style_img_col col_4">
            <a href="">

                <img src="/assets/images/kat2.jpg" alt="stilus" />
                <span>Üldögélők</span>
            </a>
        </div>

        <div class="style_img_col col_4">
            <a href="">
                <img src="/assets/images/kat3.jpg" alt="stilus" />
                <span>Tárolók</span>
            </a>
        </div>

        <div class="style_img_col col_4">
            <a href="termeklista">
                <img src="/assets/images/kat4.jpg" alt="stilus" />
                <span>Lámpák</span>
            </a>
        </div>


        <div class="style_img_col col_4">
            <a href="">
                <img src="/assets/images/kat5.jpg" alt="stilus" />
                <span>Dekorációk</span>
            </a>
        </div>

        <div class="style_img_col col_4">
            <a href="stilusok">
                <img src="/assets/images/kat6.jpg" alt="stilus" />
                <span>Stílusok</span>
            </a>
        </div>


        <div class="style_img_col col_2">
            <a href="">
                <img src="/assets/images/kat7.jpg" alt="stilus" />
                <span>Mindenünk</span>
            </a>
        </div>
-->



</section>



<section class="wrapper" id="bemutatkozas_wrap">
    <img src="/assets/images/bemutatkozas_hatter.jpg" alt="bemutatkozas" />
    <div id="bemutatkozas">
        <h4>Felújított régiségek, múltidéző újdonságok</h4>
<p>Ismered azt a bizsergető, mámoros érzést, amikor valami fantasztikus kincsre bukkansz? Egy ódon komód minden szeglete mesél, sokszor azonban vannak tárgyak, amik nehezebben adják magukat. Elő kell csalogatnunk belőlük a történetüket.</p>
<p>Az évek során a kincsek felkutatása igazi missziónkká vált. Megtanultuk, hogy a képzelet az, ami egyedit alkot és minden tárgynak saját lelket ad – legyen az apró, vagy robusztus, antik vagy frissen fabrikált. Legfontosabb küldetésünk, hogy egyetlen megkopott bútort, megunt kiegészítőt se kelljen kidobni, inkább találjuk meg azt az ötletes megoldást, amivel még sok-sok éven keresztül örömet okozhatnak. Ebből a filozófiából csakhamar egy folyamatosan bővülő, ezerszínű termékpaletta született, a zegzugos bazári hangulatnak pedig a budapesti Bálna bevásárlóközpont adott otthont. A Bazi Bazárban az anyagot tisztelve szeretnénk mindig valami újat álmodni: vagányságot a hokedlibe, humort egy múlt századi zsúrkocsiba, édes nosztalgiát a képkeretekbe.</p>
        </p>
    </div>
</section>


<div id="fooldal_foot">

</div>