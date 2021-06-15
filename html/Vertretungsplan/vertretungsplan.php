<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="stylesheet" href="mainhome.css">
    <link rel="stylesheet" href="tabellen.css">
    <script language="javascript" type="text/javascript" src="vertretung.js"></script>
    <title>DYS - display your school</title>
</head>

<body style="margin: 0;">
    <script type="text/javascript">
        $time = 400;
        $speed = 1;

        var myVar = setInterval(function() {
            myScroller()

        }, 1);

        $counter = 0;
        $switch = 0;

        function myScroller() {
            if (document.getElementById("scrollarea").scrollTop + document.getElementById("scrollarea").clientHeight >= document.getElementById("scrollarea").scrollHeight) {
                if ($counter < $time) {
                    $counter++;
                } else {
                    $counter = 0;
                    $switch = 1;
                    document.getElementById("scrollarea").scrollTop -= $speed;
                }
            } else {
                if ($switch == 1) {
                    document.getElementById("scrollarea").scrollTop -= $speed;
                    if (document.getElementById("scrollarea").scrollTop == 0) {
                        if ($counter < $time) {
                            $counter++;
                        } else {
                            $counter = 0;
                            $switch = 0;
                            document.getElementById("scrollarea").scrollTop += $speed;
                        }
                    }
                } else {
                    document.getElementById("scrollarea").scrollTop += $speed;
                }
            }
        }
    </script>

    <section class="news">
        <h3>NEWS</h3>
        <div class="newstext">
            <?php
            $db = new mysqli('localhost', 'root', '', 'dys');
            if ($db->connect_errno) {
                die("Verbindung fehlgeschlagen: " . $db->connect_error);
            }
            mysqli_set_charset($db, "utf8");
            $eintrag = "SELECT * FROM `news` WHERE `NID` = 1";
            $result = mysqli_query($db, $eintrag);
            $inhalt = mysqli_fetch_array($result, MYSQLI_BOTH);
            print_r($inhalt["Uhrzeit"] . " - " . $inhalt["Inhalt"]);
            mysqli_close($db);
            ?>
        </div>
    </section>
    <section class="main">

        <header>Heute</header>
        <section class="outerBox" id="scrollarea">
            <?php
            include 'vertretungsplan-anzeigen.php';
            $datum = date("Y-m-d");
            //anzeigen($datum);
            ?>

            <?php
            $db = new mysqli('localhost', 'root', '', 'dys');
            if ($db->connect_errno) {
                die("Verbindung fehlgeschlagen: " . $db->connect_error);
            }
            mysqli_set_charset($db, "utf8");
            //datum var kann behalten werden
            $klassen = array(
                "05a", "05b", "05c", "05d", "05e", "05f", "06g", "06a", "06b", "06c", "06d", "06e", "06f", "06g", "07a", "07b", "07c", "07d", "07e", "07f", "07g",
                "08a", "08b", "08c", "08d", "08e", "08f", "08g", "09a", "09b", "09c", "09d", "09e", "09f", "09g", "10a", "10b", "10c", "10d", "10e", "10f", "10g",
                "11", "12"
            );
            for ($i = 0; $i < count($klassen); $i++) {
                $sql = "SELECT * FROM `vertretung_daten` WHERE `Klasse(n)` LIKE '$klassen[$i]' ORDER BY `Stunde`";

                $db_erg = mysqli_query($db, $sql);
                if (!$db_erg) {
                    die('Ungültige Abfrage: ');
                }
                if ($db_erg->num_rows > 0) {

                    echo "
                <section class='innerBox'>
                    <h2>$klassen[$i]</h2>
                    <section class='ausfallendeStunden'>";
                    while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
                        //echo $zeile['Stunde'] . ". Stunde Entfall von " . $zeile['Fach'] . "/" . $zeile['Vertretungsfach'] . "<br>";
                        echo "<section class='eintrag'>";
                        if ($zeile['Vertretungsart'] == null) { //Other
                            echo "<p class ='kisteUeberschrift'>";
                            echo $zeile['Stunde'] . ". Stunde ";
                            echo "</p>";
                            if ($zeile['Text_zur_Vertretung'] != null) {
                                echo $zeile['Text_zur_Vertretung'];
                            }
                            echo "<div class='ausfallenderText'>";
                            echo "<s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'] . "<br>";
                            echo "</div>";
                        } else if ($zeile['Vertretungsart'] == "T") { //verlegt
                            echo "<h6>Verlegt</h6>";
                        } else if ($zeile['Vertretungsart'] == "F") { //verlegt von
                            echo "<h6>Verlegt von</h6>";
                        } else if ($zeile['Vertretungsart'] == "W") { //Tausch
                            echo "<p class ='kisteUeberschrift'>";
                            echo $zeile['Stunde'] . ". Stunde ";
                            echo "</p>";
                            echo "<s>" . $zeile['Fach'] . "</s> &#10132; " . $zeile['Vertretungsfach'];
                        } else if ($zeile['Vertretungsart'] == "S") { //Betreunug
                            echo "<h6>Mathe</h6>";
                        } else if ($zeile['Vertretungsart'] == "A") { //Sondereinsatz
                            echo "<h6>Mathe</h6>";
                        } else if ($zeile['Vertretungsart'] == "C") { //Entfall
                            echo "<p class ='kisteUeberschrift'>";
                            echo $zeile['Stunde'] . ". Stunde ";
                            echo "</p>";
                            echo "Entfall" . "<br>";
                            echo "<s>" . $zeile['Fach'] . "</s>";
                        } else if ($zeile['Vertretungsart'] == "L") { //Freisetzung
                            echo "<h6>Mathe</h6>";
                        } else if ($zeile['Vertretungsart'] == "P") { //Teil-Vertretung
                            echo "<h6>Mathe</h6>";
                        } else if ($zeile['Vertretungsart'] == "R") { //Raumvertretung
                            echo "<p class ='kisteUeberschrift'>";
                            echo $zeile['Stunde'] . ". Stunde ";
                            echo "</p>";
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

            ?>
        </section>



    </section>
</body>

</html>