<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php 

    echo "<pre>";
print_r($products);
echo "</pre>";

    foreach ($products as $product) : 


            $thumb = "/" . PICTURE_UPLOAD_DIR . thumb_name('300', $product->file_url);

?>

<a href="/termekek/<?php echo $product->url_string; ?>">
    <img src="<?php echo $thumb; ?>" alt="" />
        <?php echo $product->name; ?> / 
        <?php 
            if ($product->price >0) {
                echo $product->price . " Ft";
            }
        ?>


</a>

    <form method="post">
        <input type="hidden" name="call_main_function" value="addCart" />
        <input type="hidden" name="name" value="<?php echo $product->name; ?>" />
        <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
        <input type="hidden" name="price" value="<?php echo $product->price; ?>" />
        
        <?php if ($product->price >0) : ?>
        <input type="submit" value="Kosárba" />
        <?php endif; ?>
    

    
    </form>
    


<?php endforeach; ?>

 
