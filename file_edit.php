<div id="gallery_edit" class="<?php echo $configs->class_gallery_upload;?>">
<h1 class="text-center">Edit</h1>

<form action="index.php" method="post">
        Bilder: <br>
        <?php
            $ordner = "uploaded_files";
            $allebilder = scandir($ordner);
            $counter2=1;
            foreach ($allebilder as $bild) 
            {
                $bildinfo = pathinfo($ordner."/".$bild); 
                if ($bild != "." && $bild != ".."  && $bild != "_notes" && $bildinfo['basename'] != "Thumbs.db") 
                {  
                    ?><input type="checkbox" name="name" value="<?php echo $counter2; ?>"><?php echo "Bild ".$counter2; ?> <br> <?php
                    $counter2++;
                }
            }

        ?>
        Effekte: <br>
        <input type="checkbox" name="greyscale" value="greyscale">Greyscale<br>
        <input type="checkbox" name="mirror" value="mirror">Spiegeln<br>
        <input type="checkbox" name="auswahl" value="other">anderes<br>
        <input type="submit" value="Datei auswaehlen">
</form>

<?php

if (isset($_POST["name"]))
{
    $zahl = $_POST['name'];
    $image = $_SESSION[$zahl];
    $_SESSION['filenameedit'] = $image;
}

if(isset($_SESSION['filenameedit']))
{
    $image = $_SESSION['filenameedit'];
    $imagefile = 'uploaded_files/'.$image;
    $imagesize = getimagesize($imagefile);
    $imagewidth = $imagesize[0];
    $imageheight = $imagesize[1];
    $imagetype = $imagesize[2];
    $effect = 0;
    switch ($imagetype)
    {
        // Bedeutung von $imagetype:
        // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
        case 1: // GIF
            $image_edit = imagecreatefromgif($imagefile);
            break;
        case 2: // JPEG
            $image_edit = imagecreatefromjpeg($imagefile);
            break;
        case 3: // PNG
            $image_edit = imagecreatefrompng($imagefile);
            break;
        default:
            die('Unsupported imageformat');
    }


    if (isset($_POST['greyscale']))
    {
        if ($effect == 0)
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        imagefilter($image_edit, IMG_FILTER_GRAYSCALE); 
        unset($_POST['greyscale']);
        $effect = 1;       
    }
    if (isset($_POST['mirror']))
    {   
        if ($effect == 0)
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        imageflip($image_edit, IMG_FLIP_HORIZONTAL);
        unset($_POST['mirror']);   
        $effect = 1;     
    }

    if ($effect != 0)
    {
        imagepng($image_edit, 'uploaded_files/edit_'.$image);
        ?>
        <img src="<?php echo "uploaded_files/edit_".$image;?>" width="300" alt="Vorschau" />
        <?php
        imagedestroy($image_edit);
    }
    else
    {
        ?>
            <img src="<?php echo "uploaded_files/".$image;?>" width="300" alt="Vorschau" /> 
        <?php
    }
}  
?>
<input type="button" value="Save" onClick="window.location.href=window.location.href">
</div>