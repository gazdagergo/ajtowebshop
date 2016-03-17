<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>



<?php

    $style = '';


/*antik.jpg
bazar_nyito.jpg
indusztrialis.jpg
provence.jpg
retro.jpg
rusztikus.jpg
shabby_chic.jpg
steampunk.jpg
videki.jpg
vintage.jpg*/
    
    

    if ($id == "lampak") {
        $h4 = "Lámpák";   
        $fontSize = '29px';
        $p = "Gyerekként bűvölten figyel- jük a világító szerkezeteket - vajon honnan jön az a sok fény? Idővel a titok leleple- ződik, és egyre kevesebb- szer pillantunk már fel. Egy igazán különleges, vagány lámpa nem csak fényt visz az otthonba, visszaadja azt az izgalmat és kíváncsisá- got, amitől le sem tudod venni róla a szemed!";
        $src = "lampak.jpg";
    }

    else if ($id == "asztalok") {
        $h4 = "Asztalok";   
        $fontSize = '29px';        
        $p = "Egy karakteres asztal aka- ratlanul is a szoba központi részévé válik: ez az a darab, ami mellett össze- gyűlnek a barátok és ebédel a család, amin a világhírű remek- művek íródnak, amire a legkedvesebb emlékeinket pakoljuk. Válogass kedved- re egyedi asztalaink között, és találd meg a stílusodhoz illő darabot!";
        $src = "asztalok.jpg";
    }

    else if ($id == "uldogelok") {
        $h4 = "Üldögélők";   
        $fontSize = '29px';        
        $p = "Nehezen lehetne megza- bolázni székeink sokszínű kínálatát, hiszen az apró hokedliktől a fajsúlyos fote- lekig bárhová szívesen le- huppanunk, ha úgy tartja kedvünk. Ezért is javasol- juk, hogy hallgass a szíved- re, ha ülőalkalmatosságot keresel: ígérjük, olyan da- rabra bukkansz, amiben minden alkalommal kedve- det leled!";
        $src = "uldogelok.jpg";
    }

    else if ($id == "tarolok") {
        $h4 = "Tárolók";   
        $fontSize = '29px';        
        $p = "A kezeink alatt reinkar- nálódott ládák, kredencek és stelázsik különleges tör- téneteket hoztak át előző életeikből, mi pedig a mesét továbbszőve kerekítettük, alakítottuk fazonjukat. Ha azt szeretnéd, a legbecses- ebb emlékeidet is bizton- ságban elrejtik, de ugyanígy lehetnek kalandozásra nyi- tott vitrinek is. Ahogy tetszik!";
        $src = "tarolok.jpg";
    }

    else if ($id == "dekoraciok") {
        $h4 = "Dekorációk";   
        $fontSize = '29px';        
        $p = "Hogy miért imádjuk körbe- venni magunkat apró cset- reszekkel, képkeretekkel, párnákkal és drapériákkal? Mert ezek a finom részletek egytől egyig a személyi- ségünk darabjai, ezek teszik igazán otthonossá a lakást. Válogass bátran dekorációs ötleteink között, és díszítsd fel a mindennapokat a fan- táziád szerint!";
        $src = "dekoraciok.jpg";
    }

    else if ($id == "stilusok") {
        $h4 = "Stílusok";   
        $fontSize = '29px';        
        $p = "Ha stílusok szerint keresgélnél a kincsek között, itt jó helyen jársz! Bár a bazárosítás alatt némelyik kedvencünk egészen új stílust kap, vannak darabok, amik jellegzetes részleteikkel továbbra is egy adott kort és szellemiséget képviselnek. Mi arra bíztatunk, hallgass a meg- érzéseidre: ne hagyd, hogy el- tántorítson egy tőled szokatlan stílusirányzat, ha beleszeretsz valamibe!";
        $src = "stilusok.jpg";
        $style = "font-size: 12.5px;line-height: 1.3em;letter-spacing: .8px;margin-top: 7px;";
    }

    else if ($id == "mindenunk") {
        $h4 = "Mindenünk";   
        $fontSize = '29px';        
        $p = "Ahogy az egy rendes bazárban illik, természetesen nekünk is kilóméteres kincs-kavalkádunk van. Éppen ezért az itt sorakozó portékákat nem is próbáljuk kategóriákba terelni, ömleszt- ve mutatunk be mindent, ami Bazi Bazár. Kezdődhet a fel- fedezés?";
        $src = "mindenunk.jpg";
        $style = "font-size: 12.5px;line-height: 1.3em;letter-spacing: .8px;margin-top: 7px;";
    }

    else {
        $h4 = "Lámpák";   
        $fontSize = '29px';        
        $p = "Gyerekként bűvölten figyeljük a világító szerkezeteket - vajon honnan jön az a sok fény? Idővel a titok lelepleződik, és egyre kevesebbszer pillantunk fel. Egy igazán különleges, vagány lámpa nem csak fényt visz az otthonba, visszaadja azt az izgalmat és kíváncsiságot, amitől le sem tudod venni róla a szemed!";
        $src = "lampak-slider.jpg";
        
    }

?>

<?php 
    $no_slider = array('kereses');
    if (!in_array($id, $no_slider)) :
?>


<section class="wrapper" id="slide_wrap">
    <div id="motto">
        <h4 style="font-size: <?php echo $fontSize; ?>;">
                    <?php echo $h4; ?>
                </h4>
        <p contenteditable="true" style="<?php echo $style; ?>"><?php echo $p; ?></p>
        
    </div>
    <div id="slider_img_wrap">
        <img id="sliderImg" src="/assets/images/slider/<?php echo $src; ?>" alt="stockphoto" />

    </div>
</section>

<?php else: ?>

<section class="wrapper" id="no-slider">
    <h3>Keresés eredménye</h3>
</section>


<?php endif; ?>