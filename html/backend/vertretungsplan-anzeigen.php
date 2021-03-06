<?php

function dbConnect()
{
    $db = new mysqli('localhost', 'root', 'root', 'dys');
    if ($db->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }
    mysqli_set_charset($db, "utf8");
    return $db;
}

function debug($input){
    echo '<script>' . 'console.log('.json_encode($input).')' . '</script>';
}
function checkDS($zeile, $db, $datum) //Prüfen auf Doppelstunden...funktioniert nicht ganz richtig
{
    $now = (int)$zeile['Stunde'];
    if ($now == 1 || $now == 3 || $now == 5 || $now == 8 || $now == 10) {
        $test = $now + 1;//Needs to be renamed
        $Klasse = $zeile['Klasse(n)'];
        $Fach = $zeile['Fach'];
        $Absenter_Lehrer = $zeile['Absenter_Lehrer'];
        $Vertretungsnummer = $zeile['Vertretungsnummer'];

        $sql = "SELECT * FROM `vertretung_daten` WHERE `Klasse(n)` LIKE '$Klasse' AND `Stunde` LIKE '$test' AND `Fach` LIKE '$Fach' AND `Datum` LIKE '$datum' AND `Absenter_Lehrer` LIKE '$Absenter_Lehrer' AND `Vertretungsnummer` NOT LIKE '$Vertretungsnummer' ORDER BY `Stunde`";
        $db_erg2 = mysqli_query($db, $sql);

        if ($db_erg2->num_rows) {
            $zeile2 = mysqli_fetch_array($db_erg2, MYSQLI_ASSOC);
            echo "<section class='eintrag'>";
            echo "<b>" . ((int)$zeile2['Stunde'] - 1) . "/" . (int)$zeile2['Stunde'] . ". Stunde<br></b>";
            return "true";
        } else {
            echo "<section class='eintrag'>";
            echo "<b>" . $zeile['Stunde'] . ". Stunde<br></b>";
            return "true";
        }
    } else if ($now == 2 || $now == 4 || $now == 6 || $now == 9 || $now == 11) {
        $test = $now - 1;
        $Klasse = $zeile['Klasse(n)'];
        $Fach = $zeile['Fach'];
        $Absenter_Lehrer = $zeile['Absenter_Lehrer'];
        $Vertretungsnummer = $zeile['Vertretungsnummer'];

        $sql = "SELECT * FROM `vertretung_daten` WHERE `Klasse(n)` LIKE '$Klasse' AND `Stunde` LIKE '$test' AND `Fach` LIKE '$Fach' AND `Datum` LIKE '$datum' AND `Absenter_Lehrer` LIKE '$Absenter_Lehrer' AND `Vertretungsnummer` NOT LIKE '$Vertretungsnummer' ORDER BY `Stunde`";
        $db_erg2 = mysqli_query($db, $sql);

        if ($db_erg2->num_rows == null) {
            echo "<section class='eintrag'>";
            echo "<b>" . $zeile['Stunde'] . ". Stunde<br></b>";
            return "true";
        } else {
            return "false";
        }
    } else {
        //gibt es die ds schon
        echo "<section class='eintrag'>";
        echo "<b>" . $zeile['Stunde'] . ". Stunde<br></b>";
        return "true";
    }
}

function setEntry($db, $datum, $callback)
{

    if ($callback >= 365) {
        echo "<h1>Sieht ganz so aus als ob nichts ausfällt ;)</1h>";
        return 0;
    } else {
        $sql = "SELECT * FROM `vertretung_daten` WHERE `Datum` LIKE '$datum'"; //SQl befehl für klasse und datum
        $db_erg = mysqli_query($db, $sql); //Ausführung

        if ($db_erg->num_rows == 0) {
            $date = date("Y-m-d");
            if (strpos($datum, $date) !== false) {
                //echo "test";
            } else {

                $datum = date('Y-m-d', strtotime($datum . '+ 1 day'));
                return setEntry($db, $datum, $callback + 1);
            }
        } else {

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
                    echo "<section class='innerBox'><h2>$klassen[$i]</h2><section class='ausfallendeStunden'>";
                    while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
                        $ende = "true";
                        //Neue Methode, die mit dem Bitfeld arbeitet
                        $binaryVertretungsart = decbin($zeile['Vertretungsart']);
                        if($binaryVertretungsart[strlen($binaryVertretungsart)-1] === '1'){//Entfall
                            debug('Entfall');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                echo "Entfall" . "<br>";
                                echo "<s>" . $zeile['Fach'] . "</s> ";
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-2] === '1'){//Betreuung
                            debug('Betreuung');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Absenter_Lehrer'] != $zeile['Vertretender_Lehrer']) {
                                    echo "<s>" . $zeile['Absenter_Lehrer'] . "</s> &#10132; " . $zeile['Vertretender_Lehrer'];
                                }
                                if ($zeile['Fach'] != $zeile['Vertretungsfach']) {
                                    echo "<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                                }
                                if ($zeile['Raum'] != $zeile['Vertretungsraum']) {
                                    echo "<br><s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'];
                                }
                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'];
                                }
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-3] === '1'){//Sondereinsatz
                            debug('Sondereinsatz');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Absenter_Lehrer'] != $zeile['Vertretender_Lehrer']) {
                                    echo "<s>" . $zeile['Absenter_Lehrer'] . "</s> &#10132; " . $zeile['Vertretender_Lehrer'];
                                }
                                if ($zeile['Fach'] != $zeile['Vertretungsfach']) {
                                    echo "<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                                }
                                if ($zeile['Raum'] != $zeile['Vertretungsraum']) {
                                    echo "<br><s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'];
                                }

                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'];
                                }
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-4] === '1'){//Wegverlegung
                            debug('Wegverlegung');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Absenter_Lehrer'] != $zeile['Vertretender_Lehrer']) {
                                    echo "<s>" . $zeile['Absenter_Lehrer'] . "</s> &#10132; " . $zeile['Vertretender_Lehrer'];
                                }
                                if ($zeile['Fach'] != $zeile['Vertretungsfach']) {
                                    echo "<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                                }
                                if ($zeile['Raum'] != $zeile['Vertretungsraum']) {
                                    echo "<br><s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'];
                                }

                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'];
                                }
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-7] === '1'){//Teilvertretung
                            debug('Teilvertretung');
                            echo "<h6>Teil-Vertretung</h6>";
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-8] === '1'){//Hinverlegung
                            debug('Hinverlegung');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Absenter_Lehrer'] != $zeile['Vertretender_Lehrer']) {
                                    echo "<s>" . $zeile['Absenter_Lehrer'] . "</s> &#10132; " . $zeile['Vertretender_Lehrer'];
                                }
                                if ($zeile['Fach'] != $zeile['Vertretungsfach']) {
                                    echo "<br><s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                                }
                                if ($zeile['Raum'] != $zeile['Vertretungsraum']) {
                                    echo "<br><s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'];
                                }

                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'];
                                }
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-17] === '1'){//Raumvertretung
                            debug('Raumvertretung');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'] . "<br>";
                                }
                                if ($zeile['Raum'] != null) {
                                    echo "<s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'] . "<br>";
                                } else {
                                    echo "Raumvertretung<br>" . $zeile['Vertretungsraum'] . "<br>";
                                }
                            }
                        }
                        elseif($binaryVertretungsart[strlen($binaryVertretungsart)-18] === '1'){//Stunde ist unterrichtsfrei
                            debug('Stunde ist unterrichtsfrei');
                            $ende = checkDS($zeile, $db, $datum);
                            if ($ende == "true") {
                                if ($zeile['Text_zur_Vertretung'] != null) {
                                    echo $zeile['Text_zur_Vertretung'] . "<br>";
                                }
                                if ($zeile['Raum'] != null) {
                                    echo "<s>" . $zeile['Raum'] . "</s> &#10132; " . $zeile['Vertretungsraum'] . "<br>";
                                } else {
                                    echo "Stunde ist unterrichtsfrei<br>" . $zeile['Vertretungsraum'] . "<br>";
                                }
                            }
                        }else {
                            $ende = "false";
                        }                 
                        
                        if ($ende == "true") {
                            echo "</section>";
                        } else {
                            $ende = "true";
                        }
                    }
                    echo "</section></section>";
                }
            }
            return $callback;
        }
    }
}
