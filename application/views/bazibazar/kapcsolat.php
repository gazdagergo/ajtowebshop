<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<section id="kapcsolat_wrap" class="wrapper content_wrapper">

    <h3>Rólunk</h3>

    <p class="margin_top">Ismered azt a bizsergető, mámoros érzést, amikor valami fantasztikus kincsre bukkansz? Egy ódon komód minden szeglete mesél, sokszor azonban vannak tárgyak, amik nehezebben adják magukat. Elő kell csalogatnunk belőlük a történetüket. </p>
    <p>Az évek során a kincsek felkutatása igazi missziónkká vált. Megtanultuk, hogy a képzelet az, ami egyedit alkot és minden tárgynak saját lelket ad – legyen az apró, vagy robusztus, antik vagy frissen fabrikált. Legfontosabb küldetésünk, hogy egyetlen megkopott bútort, megunt kiegészítőt se kelljen kidobni, inkább találjuk meg azt az ötletes megoldást, amivel még sok-sok éven keresztül örömet okozhatnak. Ebből a filozófiából csakhamar egy folyamatosan bővülő, ezerszínű termékpaletta született, a zegzugos bazári hangulatnak pedig a budapesti Bálna bevásárlóközpont adott otthont. A Bazi Bazárban az anyagot tisztelve szeretnénk mindig valami újat álmodni: vagányságot a hokedlibe, humort egy múlt századi zsúrkocsiba, édes nosztalgiát a képkeretekbe.

    </p>


    <div class="clear margin_bottom"></div>
    
    <img src="/assets/images/boltkep.jpg" id="boltkep" />
    
    <div id="cim_wrap">

            <div id="foot_text">
                <h4>Bazi Bazár</h4>
                <p>1093 Budapest, Fővám tér 11-12., <br>-1 szint, 33. üzlet</p>
                <p>Nyitva tartás: H-P 10-20h</p>
                        <p class="indent">Szo 10-21h</p>
                <p>Telefon: +36 30 9442800</p>
                <p>E-mail: <a href="mailto:info@bazibazar.hu">info@bazibazar.hu</a></p>
            </div>
    
    </div>
    
    <div id="kapcsolat_form">
        <p>Kíváncsivá tettünk? Kérdezz, véleményezz, érdeklődj bátran, örömmel fogadunk minden észrevételt!</p>
        <form action="" method="post">
            <input type="text" name="kapcsolat_nev" placeholder="Név" 
                   value="<?php if (isset($kapcsolat_nev)) echo $kapcsolat_nev; ?>" />
            <input type="email" name="kapcsolat_email" placeholder="E-mail cím"
                   value="<?php if (isset($kapcsolat_email)) echo $kapcsolat_email; ?>"/>
            <textarea name="kapcsolat_uzenet" placeholder="Üzenet"><?php if (isset($kapcsolat_uzenet)) echo $kapcsolat_uzenet; ?></textarea>
            <div id="kapcsolat_response" class="<?php echo $resp_class; ?>"><?php echo $response; ?></div>
            <input type="submit" name="kapcsolat_submit" class="altalanos_gomb piros_gomb" value="Üzenet küldése" />
        </form>
    
    </div>
    
    
    <div class="clear margin_bottom"></div>
    
    <iframe id="terkep" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2696.2138120203954!2d19.055910215626255!3d47.4857479791769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc50369c7701%3A0x5af37d72c9184f5b!2zRsWRdsOhbSB0w6lyIDExLCBCdWRhcGVzdCwgMTA5Mw!5e0!3m2!1sen!2shu!4v1445252166055" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    
        <div class="clear margin_bottom"></div>

    
</section>