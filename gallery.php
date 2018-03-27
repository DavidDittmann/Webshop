<div id="uploaded_gallery" class="<?php echo $configs->class_gallery;?>">
<h1 class="text-center">Bilder</h1>
<tr>
<?php
    // Ordnername 
    $ordner = "uploaded_files"; //auch komplette Pfade möglich ($ordner = "download/files";)

    // Ordner auslesen und Array in Variable speichern
    $allebilder = scandir($ordner); // Sortierung A-Z
    // Sortierung Z-A mit scandir($ordner, 1)

    // Schleife um Array "$alledateien" aus scandir Funktion auszugeben
    // Einzeldateien werden dabei in der Variabel $datei abgelegt
    $counter=0;
    foreach ($allebilder as $bild) 
    {
        
        // Zusammentragen der Dateiinfo
        $bildinfo = pathinfo($ordner."/".$bild); 
        //Folgende Variablen stehen nach pathinfo zur Verfügung
        // $dateiinfo['filename'] =Dateiname ohne Dateiendung  *erst mit PHP 5.2
        // $dateiinfo['dirname'] = Verzeichnisname
        // $dateiinfo['extension'] = Dateityp -/endung
        // $dateiinfo['basename'] = voller Dateiname mit Dateiendung

        // Größe ermitteln für Ausgabe
        $size = ceil(filesize($ordner."/".$bild)/1024); 
        //1024 = kb | 1048576 = MB | 1073741824 = GB

        // scandir liest alle Dateien im Ordner aus, zusätzlich noch "." , ".." als Ordner
        // Nur echte Dateien anzeigen lassen und keine "Punkt" Ordner
        // _notes ist eine Ergänzung für Dreamweaver Nutzer, denn DW legt zur besseren Synchronisation diese Datei in den Orndern ab
        // Thumbs.db ist eine Ergänzung unsichtbare Dateiergänzung die von ACDSee kommt
        // um weitere ungewollte Dateien von der Anzeige auszuschließen kann man die if Funktion einfach entsprechend erweitern
        if ($bild != "." && $bild != ".."  && $bild != "_notes" && $bildinfo['basename'] != "Thumbs.db") 
        {  
            ?>
            <li class="<?php echo $configs->class_uploaded_gallery;?>"
            <?php 
            if ($counter%2 != 0) {
                echo 'style="background-color: #EBEBEB; padding: 10px;"';
            };
            ?>>
               <a href="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>">
               <img src="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>" width="240" alt="Vorschau" /></a> 
           </li>
           <?php
           $counter++;
        };
    };
?>
</tr>
</div>