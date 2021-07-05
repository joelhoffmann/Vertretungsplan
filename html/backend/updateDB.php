<html>

<body>
    <?php
    if (!file_exists("GPU002.TXT")) {
        echo "The file from above cannot be found!";
        exit;
    }
    $fp = fopen("GPU002.TXT", "r");
    if (!$fp) {
        echo "Somehow the file cannot be opened! :)";
        exit;
    }
    $db = new mysqli('localhost', 'root', '', 'dys');
    if ($db->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }
    mysqli_set_charset($db, "utf8");
    mysqli_query($db, "DELETE FROM `vertretung_daten`");
    $index = 0;
    while (!feof($fp)) {
        //$zeile = fgets($fp);
        //echo "<tr><td>$zeile</td>";

        // Einträge ohne Klasse nicht in DB

        $getTextLine = fgets($fp);
        $explodeLine = explode(",", $getTextLine);

        list($Vertretungsnummer, $Datum, $Stunde, $Absenznummer, $Unterrichtsnummer, $Absenter_Lehrer, $Vertretender_Lehrer, $Fach, $Statistikkennzeichen_des_Fachs, $Vertretungsfach, $Statistikkennzeichen_des_Vertretungsfachs, $Raum, $Vertretungsraum, $Statistik_Kennzeichen, $Klasse, $Absenzgrund, $Text_zur_Vertretung, $Art, $Vertretungsklasse, $Vertretungsart, $Zeit_Aenderung, $Zusatz) = $explodeLine;
        //echo $Vertretungsnummer.": ".$Zeit_Aenderung."<br>";
        $Datum = str_replace('"', '', $Datum);
        $Absenter_Lehrer = str_replace('"', '', $Absenter_Lehrer);
        $Vertretender_Lehrer = str_replace('"', '', $Vertretender_Lehrer);
        $Fach = str_replace('"', '', $Fach);
        $Vertretungsfach = str_replace('"', '', $Vertretungsfach);
        $Raum = str_replace('"', '', $Raum);
        $Vertretungsraum = str_replace('"', '', $Vertretungsraum);
        $Klasse = str_replace('"', '', $Klasse);
        $Vertretungsklasse = str_replace('"', '', $Vertretungsklasse);
        $Vertretungsart = str_replace('"', '', $Vertretungsart);
        $Text_zur_Vertretung = str_replace('"', '', $Text_zur_Vertretung);

        //Sondereinsatz, Pausenaufsicht
        if ($Klasse) {
            $sql = "INSERT INTO `vertretung_daten`(
                `Vertretungsnummer`, 
                `Datum`, 
                `Stunde`, 
                `Absenter_Lehrer`, 
                `Vertretender_Lehrer`, 
                `Fach`, 
                `Vertretungsfach`, 
                `Raum`, 
                `Vertretungsraum`, 
                `Klasse(n)`, 
                `Text_zur_Vertretung`, 
                `Vertretungsklasse(n)`, 
                `Vertretungsart`
                )VALUES (
                '$Vertretungsnummer',
                '$Datum',
                '$Stunde',
                '$Absenter_Lehrer',
                '$Vertretender_Lehrer',
                '$Fach',
                '$Vertretungsfach',
                '$Raum',
                '$Vertretungsraum',
                '$Klasse',
                '$Text_zur_Vertretung',
                '$Vertretungsklasse',
                '$Vertretungsart')";

            mysqli_query($db, $sql);
            $index++;
        }
    }

    mysqli_close($db);
    fclose($fp);

    header('location: ../Einstellungen/settings.php');
    ?>
</body>

</html>

<!-- Datensatz 7 fehlerhaft aufgrund "," in einer Eingabe ... -->