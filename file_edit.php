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
                    ?><input type="radio" name="name" value="<?php echo $bildinfo['basename']; ?>"><?php echo "Bild ".$counter2." |  ".$bildinfo['filename']; ?> <br> <?php
                    $counter2++;
                }
            }

        ?>
        Effekte: <br>
        <input type="checkbox" name="greyscale" value="greyscale">Greyscale<br>
        <input type="checkbox" name="mirror" value="mirror">Spiegeln<br>
        <input type="checkbox" name="90rechts" value="90rechts">90 Grad rechts<br>
        <input type="checkbox" name="90links" value="90links">90 Grad links<br>
        <input type="checkbox" name="undo" value="undo">UNDO<br>
        <input type="submit" value="Datei auswaehlen"> <br> <br>
</form>

        <input type="button" value="Abbruch" onClick="window.location.href=window.location.href">
<?php

if (isset($_POST["name"]))
{
    $image = $_POST['name'];
    $_SESSION['pick'] = $image;
}

if(isset($_SESSION['pick']))
{
    if(!isset($_SESSION['change']))
    {
        $_SESSION['change'] = "empty";
    }
    $image = $_SESSION['pick'];
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
    if (isset($_POST['undo']))
    {
        $back = $_SESSION['change'];
        if ($back == "greyscale")
        {}
        if ($back == "mirror")
        {
            $_POST['mirror'] = "mirror";
        }
        if ($back == "90rechts")
        {
            $_POST['90links'] = "90links";
        }
        if ($back == "90links")
        {
            $_POST['90rechts'] = "90rechts";
        }
        unset($_SESSION['change']);
        unset($_POST['undo']);
    }
    if (isset($_POST['greyscale']))
    {
        if ($effect == 0 && $image[0] != "1")
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        imagefilter($image_edit, IMG_FILTER_GRAYSCALE); 
        unset($_POST['greyscale']);
        $_SESSION['change']="greyscale";
        $effect = 1;       
    }
    if (isset($_POST['mirror']))
    {   
        if ($effect == 0 && $image[0] != "1")
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        imageflip($image_edit, IMG_FLIP_HORIZONTAL);
        unset($_POST['mirror']); 
        $_SESSION['change']="mirror"; 
        $effect = 1;     
    }
    if (isset($_POST['90rechts']))
    {   
        if ($effect == 0 && $image[0] != "1")
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        $grad = 270;
        $image_edit = imagerotate($image_edit, $grad, 0);
        unset($_POST['90rechts']);   
        $_SESSION['change']="rechts";
        $effect = 1;     
    }
    if (isset($_POST['90links']))
    {   
        if ($effect == 0 && $image[0] != "1")
        {
            imagepng($image_edit, 'uploaded_files/'.$image); //alte datei abspeichern
        }
        $grad= 90;
        $image_edit = imagerotate($image_edit, $grad, 0);
        unset($_POST['90links']);  
        $_SESSION['change']="links"; 
        $effect = 1;     
    }

    if ($effect != 0)
    {
        if ($image[0] == "1")
        {
            $image = substr($image, 2);
        }
        imagepng($image_edit, 'uploaded_files/1_'.$image);
        ?>
        <img src="<?php echo "uploaded_files/1_".$image;?>" width="300" alt="Vorschau" />
        <?php
        imagedestroy($image_edit);
        $effect = 0;
    }
    else
    {
        ?>
            <img src="<?php echo "uploaded_files/".$image;?>" width="300" alt="Vorschau" /> 
        <?php
    }
}  
?>

</div>