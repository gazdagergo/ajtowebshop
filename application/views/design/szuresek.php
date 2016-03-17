<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php


echo form_open('');

$options = array(
    15 => '15db / oldal',
    25 => '25db / oldal',
    );

echo "<div class='select-style'>";
//echo form_dropdown('rendezes', $options, NULL);
echo "</div>";

$options = array(
    40000 => '40.000 alatt',
    80000 => '40 és 80 ezer között',
    );

echo "<div class='select-style'>";
echo form_dropdown('rendezes', $options, NULL);
echo "</div>";

echo form_close();