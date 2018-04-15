<div id="gallery_edit" class="<?php echo $configs->class_gallery_upload;?>">
<h1 class="text-center">Edit</h1>

<button type="button" onclick="">Graustufen</button>

<?php


    $info = $bildinfo;
    ?>
    <img src="<?php echo $info['dirname']."/".$info['basename'];?>" width="200" alt="Vorschau" /></a>
    <?php
    function greyscale()
    {
        $image_edit = imagecreatefrompng('uploaded_files/moewe.png');
        imagefilter($image_edit, IMG_FILTER_GRAYSCALE);
        imagepng($image_edit, 'uploaded_files/new_'.$image['name'].$image['type']);

        $ordner = "uploaded_files";
        $bildinfo = pathinfo($ordner."/".$image_edit);
        imagedestroy($image_edit);
    }
    
?>
</div>