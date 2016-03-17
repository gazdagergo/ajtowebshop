<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div><?php echo $product->name; ?></div>
<div><?php echo $product->short_description; ?></div>
<div><?php 
        echo ($product->price == 0) ? '' : number_format($product->price, 0, ',', '.') . ' Ft';
?></div>

<?php $imageSrc = $product->file_url ? $product->file_url : 'noimage.png'; ?>

<img src="<?php echo PICTURE_UPLOAD_DIR . $imageSrc; ?>" alt="<?php echo $product->name; ?>" />

    <form method="post">
        <input type="hidden" name="call_main_function" value="addCart" />
        <input type="hidden" name="name" value="<?php echo $product->name; ?>" />
        <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
        <input type="hidden" name="price" value="<?php echo $product->price; ?>" />
        
        <?php if ($product->price >0) : ?>
        <input type="submit" value="Kosárba" />
        <?php endif; ?>
    

    
    </form>
