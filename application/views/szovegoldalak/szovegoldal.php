<section id="product_wrap" class="main-wrap wrapper">

    <div class="fokeret kek">
        
        
        <?php if (isset($keretcim)) : ?>
        <div id="productlist-header">
             <h3><?php echo $keretcim; ?></h3>
        </div>        
        <div class="clear"></div>
        <?php endif; ?>        
        
        <div class="fokeret-body">
        
        <?php echo $html; ?>
            
        </div>
        
    </div>
</section>