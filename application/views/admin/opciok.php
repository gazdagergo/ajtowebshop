<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

<?php
    $id = $this->uri->segment(3);
?>

<a href="/admin/products/edit/<?php echo $id; ?>">
    <input value="Vissza" class="btn btn-large" id="opciok-button" type="button">
</a>
<div style="height:18px;"></div>