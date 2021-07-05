<?php

function dbConnect()
{
    $db = new mysqli('localhost', 'root', '', 'dys');
    if ($db->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }
    mysqli_set_charset($db, "utf8");
    return $db;
}

function checkDS($zeile, $db, $db_erg, $datum) //Prüfen auf Doppelstunden
{
    $now = (int)$zeile['Stunde'];
    if ($now == 1 || $now == 3 || $now == 5 || $now == 8 || $now == 10) {
        $Stunde = (int)$zeile['Stunde'] + 1;
        $Klasse = $zeile['Klasse(n)'];
        $Fach = $zeile['Fach'];
        $sql = "SELECT * FROM `vertretung_daten` WHERE `Klasse(n)` LIKE '$Klasse' AND `Stunde` LIKE '$Stunde' AND `Fach` LIKE '$Fach' AND `Datum` LIKE '$datum' ORDER BY `Stunde`";
        $db_erg2 = mysqli_query($db, $sql);
        if ($db_erg2->num_rows) {
            $zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
            echo "<b>" . (int)$zeile['Stunde'] - 1 . "/" . (int)$zeile['Stunde'] . ". Stunde<br></b>";
        } else {
            echo "<b>" . $zeile['Stunde'] . ". Stunde<br></b>";
        }
    } else {
        echo "<b>" . $zeile['Stunde'] . ". Stunde<br></b>";
    }
}

function setEntry($db, $datum)
{
    $klassen = array(
        "05a", "05b", "05c", "05d", "05e", "05f", "06g", "06a", "06b", "06c", "06d", "06e", "06f", "06g", "07a", "07b", "07c", "07d", "07e", "07f", "07g",
        "08a", "08b", "08c", "08d", "08e", "08f", "08g", "09a", "09b", "09c", "09d", "09e", "09f", "09g", "10a", "10b", "10c", "10d", "10e", "10f", "10g",
        "11", "12"
    );

    for ($i = 0; $i < count($klassen); $i++) { //Klassenweise Auslesen

        $sql = "SELECT * FROM `vertretung_daten` WHERE `Klasse(n)` LIKE '$klassen[$i]' AND `Datum` LIKE '$datum' ORDER BY `Stunde`"; //SQl befehl für klasse und datum
        $db_erg = mysqli_query($db, $sql); //Ausführung
        if (!$db_erg) {
            die('Ungültige Abfrage: ');
        }

        if ($db_erg->num_rows > 0) {
            echo "<section class='innerBox'> <h2>$klassen[$i]</h2> <section class='ausfallendeStunden'>";
            while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
                echo "<section class='eintrag'>";
                if ($zeile['Vertretungsart'] == null) { //Other ------------------------------------
                    checkDS($zeile, $db, $db_erg, $datum);
                    if ($zeile['Text_zur_Vertretung'] != null) {
                        echo $zeile['Text_zur_Vertretung'];
                    }
                    echo "<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'] . "<br>";
                } else if ($zeile['Vertretungsart'] == "T") { //verlegt
                    echo "<h6>Verlegt</h6>";
                } else if ($zeile['Vertretungsart'] == "F") { //verlegt von
                    echo "<h6>Verlegt von</h6>";
                } else if ($zeile['Vertretungsart'] == "W") { //Tausch ------------------------------------
                    checkDS($zeile, $db, $db_erg, $datum);
                    echo "-<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                } else if ($zeile['Vertretungsart'] == "S") { //Betreunug
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "A") { //Sondereinsatz
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "C") { //Entfall ------------------------------------
                    checkDS($zeile, $db, $db_erg, $datum);
                    echo "Entfall" . "<br>";
                    echo "<s>" . $zeile['Fach'] . "</s>";
                } else if ($zeile['Vertretungsart'] == "L") { //Freisetzung
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "P") { //Teil-Vertretung
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "R") { //Raumverlegung ------------------------------------
                    checkDS($zeile, $db, $db_erg, $datum);
                    if ($zeile['Text_zur_Vertretung'] != null) {
                        echo $zeile['Text_zur_Vertretung'] . "<br>";
                    }
                    echo "<s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'] . "<br>";
                } else if ($zeile['Vertretungsart'] == "B") { //Pausenaufsichtsvertretung
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "~") { //Lehrertsuch
                    echo "<h6>Mathe</h6>";
                } else if ($zeile['Vertretungsart'] == "E") { //Klausur
                    echo "<h6>Mathe</h6>";
                }
                echo "</section>";
            }
            echo "</section></section>";
        }
    }
}
