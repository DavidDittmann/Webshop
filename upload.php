<div id="gallery_upload" class="<?php echo $configs->class_gallery_upload;?>">
<h1 class="text-center">Upload</h1>

<?php
$subdir = "./uploaded_files/"; 		// Stelle, wo die Datei hinkopiert werden soll 
                            // (hier das Unterverzeichnis "files" zum aktuellen Verzeichnis, wo diese php-Datei liegt
                            // WICHTIG: das Unterverzeichnis muss beim Ausfuehren des Scripts bereits existieren
                            // WICHTIG: das Verzeichnis muss die vollen Lese- und Schreibrechte haben
                            // -> in Winscp Verzeichnis selektieren, rechte Maustaste -> Eigenschaften, bei octal 0777 eintragen !!!!!!!
                            
if (isset($_FILES['userfile'])) {	
    $fileupload=$_FILES['userfile'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    
    if ($_FILES['userfile']['size'] > 512000) {
        echo '<script type="text/javascript">alert("File zu groß");</script>';
        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    else if (false === $ext = array_search($finfo->file($_FILES['userfile']['tmp_name']),array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),true)) {
            echo '<script type="text/javascript">alert("Falscher Dateityp, pls no virus :(");</script>';
            echo '<script type="text/javascript">window.location.href = "index.php"</script>';
        }
                            // diverse Statusmeldungen ausschreiben
    //echo "name: ".$fileupload['name']." <br>";				// Originalname der hochgeladenen Datei
    //echo "type: ".$fileupload['type']." <br>";				// Mimetype der hochgeladenen Datei
    //echo "size: ".$fileupload['size']." <br>";				// Groeße der hochgeladenen Datei
    //echo "error: ".$fileupload['error']." <br>";			// eventuelle Fehlermeldung
    //echo "tmp_name: ".$fileupload['tmp_name']." <br>";		// Name, wie die hochgeladene Datei im temporaeren Verzeichnis hei�t
    //echo "ziel: ".$subdir.$fileupload['name']." <br>";		// Pfad und Dateiname, wo die hochgeladene Datei hinkopiert werden soll
    //echo "<br>";
    
    // Pr�fungen, ob Dateiupload funktioniert hat
    else if ( !$fileupload['error'] 								// kein Fehler passiert
        && $fileupload['size']>0							// Groeße > 0	
        && $fileupload['tmp_name']							// hochgeladene Datei hat einen temporaeren Namen
        && is_uploaded_file($fileupload['tmp_name']))       // nur dann true, wenn Datei gerade erst hochgeladen wurde
        {
        move_uploaded_file($fileupload['tmp_name'],$subdir.$fileupload['name']);  // erst dann ins neue Verzeichnis verschieben
        echo '<script type="text/javascript">window.location.href = "index.php"</script>'; // refreshed nach dem upload damit das bild im galerie bereich auftaucht
        }
    else echo 'Fehler beim Upload';
}
?>

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1024000">
<input name="userfile" type="file">
<input class="upload_button" type="submit" value="Upload">
</form>

<!-- drag&drop funkt noch nicht ... kein plan was wo wie man da machen muss ....upload_ajax.js is eingebunden und sollte onload irgendwas machen... tut es aber nicht -->
<div id="dropbox" onload="init();" >
    <h2 class="text-center"> Drag & Drop your files here </h2>
</div>
</div>

