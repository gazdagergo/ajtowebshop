<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>


<?php

$stilusok = array(
    array('shabby_chick','Shabby Chick', 3),
    array('antik',  'Antik', 3),
    array('indusztrialis',  'Indusztriális', 3),
    array('provance',  'Provance', 3),
    array('retro',  'Retró', 3),
    array('rusztikus',  'Rusztikus', 3),
    array('steampunk',  'Steampunk', 3),
    array('videki',  'Vidéki', 3),
    array('vintage',  'Vintage', 3),
    );


?>

<section class="wrapper" id="stilus_wrap">

<?php $i=0; $r=0; foreach ($stilusok as $stilus) : $i++; ?>
    
    <div class="style_img_row">
        <div class="style_img_col col_<?php echo $stilus[2]; ?>">
            <a href="/stilusok/<?php echo $stilus[0]; ?>">
                <img src="/assets/images/stilusok/<?php echo $stilus[0]; ?>.jpg" alt="<?php echo $stilus[1]; ?>" />
                <span><?php echo $stilus[1]; ?></span>
            </a>
        </div>

    <?php
        
        $r += 1/$stilus[2];
        
        if ($r > 0.9) {
            $r = 0;
            echo '</div>';
        }
            
    ?>
        
<?php endforeach; ?>
        

</section>



   
