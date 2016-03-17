<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link type="text/css" rel="stylesheet" href="<?php echo $css; ?>" />
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    

</head>
<body>

    
    <div id="select-wrap">

        <form id="cropform" action="" method="post">

            <select name="thumbSize">
                <option value="<?php echo TERMEK_IMAGE_WIDTH; ?>">Nagy kép</option>
                <option value="<?php echo TERMEKLISTA_THUMB_WIDTH; ?>">Lista kép</option>
            </select>

            <input type="hidden" name="cropLeft" />
            <input type="hidden" name="cropTop" />
            <input type="hidden" name="scaleFactor" />
            <input type="hidden" name="imageSrc" value="<?php echo $img; ?>" />


            <input type="submit" value="Mentés" />
        </form>    

    </div>
        
    
    
    <div class="cropwrap">
        <img id="image_to_crop" src="<?php echo $img; ?>" />
        <div id="croparea" class="draggable">
            <div id="plus" class="zoom">+</div>
            <div id="minus" class="zoom">-</div>
        </div>
    </div>

    

    
    
    
    <script src="<?php echo $cropjs; ?>"></script>

    
    
</body>
</html>

