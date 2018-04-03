<?php
$subdir = "./uploaded_files/"; 		// Stelle, wo die Datei hinkopiert werden soll 
							// (hier das Unterverzeichnis "files" zum aktuellen Verzeichnis, wo diese php-Datei liegt
							// WICHTIG: das Unterverzeichnis muss beim Ausf�hren des Scripts bereits existieren
							// WICHTIG: das Verzeichnis muss die vollen Lese- und Schreibrechte haben
							// -> in Winscp Verzeichnis selektieren, rechte Maustaste -> Eigenschaften, bei octal 0777 eintragen !!!!!!!
if (isset($_FILES)) {							// wurde Datei per POST-Methode upgeloaded
	$fileupload=$_FILES['file'];						// diverse Statusmeldungen ausschreiben

	$finfo = new finfo(FILEINFO_MIME_TYPE);

    if ($_FILES['file']['size'] > 1024000) {
        echo '<script type="text/javascript">alert("File zu groß");</script>';
        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    else if (false === $ext = array_search($finfo->file($_FILES['file']['tmp_name']),array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
		),true)) 
	{
            echo '<script type="text/javascript">alert("Falscher Dateityp, pls no virus :(");</script>';
            echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
	else if ( !$fileupload['error'] 								// kein Fehler passiert
	    && $fileupload['size']>0							// Gr��e > 0	
    	&& $fileupload['tmp_name']							// hochgeladene Datei hat einen tempor�ren Namen
		&& is_uploaded_file($fileupload['tmp_name']))
		{
		  move_uploaded_file($fileupload['tmp_name'],$subdir.$fileupload['name']);
		  echo '<script type="text/javascript">window.location.href = "index.php"</script>';
		}
	else 
	{
		echo 'Fehler beim Upload';
	}
}

?>



