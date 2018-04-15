<div id="gallery_edit" class="<?php echo $configs->class_gallery_upload;?>">
<h1 class="text-center">Edit</h1>

<form action="index.php" method="post">
Name:   <input type="file" name="name"><br>        
        
        <br>
Effect: <input type="radio" name="auswahl" value="greyscale">Greyscale
        <input type="radio" name="auswahl" value="mirror">Spiegeln
        <input type="radio" name="auswahl" value="other">anderes
        <br>
        <input type="submit" value="Datei auswaehlen">
</form>
<!--
<form action="index.php" method="post">
Effect: <input type="radio" name="auswahl" value="greyscale">Greyscale
        <input type="radio" name="auswahl" value="mirror">Spiegeln
        <input type="radio" name="auswahl" value="other">anderes
        <br>
        <input type="submit" value="Effekt anwenden"> 
        <br>
</form>

<form action="index.php" method="post">
    <input type="submit"> 
</form>
-->
<?php
if(isset($_POST["name"]) || isset($_SESSION['filenameedit']))
{
    /*
    if (isset($_SESSION['filenameedit']) && isset($_POST["name"]))
    {
        unset($_SESSION['filenameedit']);
        $image = $_POST["name"];
    }
    if (isset($_POST["name"]))
    {
        $image = $_POST["name"];
    }
    if (!isset($_SESSION['filenameedit']))
    {
        $_SESSION['filenameedit']= $image;
    }
    if (isset($_SESSION['filenameedit']) && !isset($_POST["name"]))
    {
        $image = $_SESSION['filenameedit'];
    }
    */
    $image = $_POST["name"];

    if(isset($_POST["auswahl"]))
    {
        $auswahl = $_POST["auswahl"];
    }
    else
    {
        $auswahl = "empty";
    }

    if ($auswahl == "greyscale")
    {
        $imagefile = 'uploaded_files/'.$image;
        $imagesize = getimagesize($imagefile);
        $imagewidth = $imagesize[0];
        $imageheight = $imagesize[1];
        $imagetype = $imagesize[2];
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
        imagepng($image_edit, 'uploaded_files/'.$image);
        imagefilter($image_edit, IMG_FILTER_GRAYSCALE);
        imagepng($image_edit, 'uploaded_files/new_'.$image);
        imagedestroy($image_edit);
        ?>
            <img src="<?php echo "uploaded_files/new_".$image;?>" width="300" alt="Vorschau" />
        <?php
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