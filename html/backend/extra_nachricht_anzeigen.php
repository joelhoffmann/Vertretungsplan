<?php
function showNews($db)
{
    $counter = 10;
    $sql = "SELECT * FROM `news_extra` WHERE `date_start` <= CURDATE() AND `date_end` >= CURDATE() ";

    $db_erg = mysqli_query($db, $sql); //Ausführung
    if (!$db_erg) {
        die('Ungültige Abfrage: ');
    }

    if ($db_erg->num_rows > 0) {
        //für mehr news if zu while ändern
        if ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
            echo "<section class='outerExtra'>";
            echo "<h2 class='ExtraTitel'style=''>" . $zeile['title'] . "</h2></br>";
            echo "<div class='ExtraText'stlye='overflow-wrap: break-word'>" . $zeile['text'] . "</div>";
            if ($zeile['picture_location']) {
                list($width, $height) = getimagesize($zeile['picture_location']);
                if ($width > $height) { //Querformat
                    echo "<img class='ExtraPicture' src=" . $zeile['picture_location'] . " alt='' width='84%' height='84%'>";
                    echo "<style>.outerExtra{display: grid;width: 100%;grid-auto-flow: row;}</style>"; //custom css for innerExtra
                } else { //Hochformat
                    echo "<img class='ExtraPicture' src=" . $zeile['picture_location'] . " alt='' width='70%' height='100%'>";
                    echo "<style>.outerExtra{display: grid;column-gap: 5%;width: 100%;}.ExtraTitel{grid-column-start: 1;grid-column-end: 4;}.ExtraText{overflow-wrap: break-word;}</style>"; //custom css for innerExtra
                }
            } else {
                echo "<style>.outerExtra{display: grid;width:100%;}</style>"; //custom css for when no picture is uploaded
                debug("Kein Bild gefunden");
            }

            echo "</section>";
            $counter++;
        }
    }

    $sql = "SELECT * FROM `news_extra` WHERE `date_end` < CURDATE() ";
    $db_erg = mysqli_query($db, $sql); //Ausführung

    while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
        $loesch = $zeile['ID'];
        unlink($zeile['picture_location']);
        //echo "DELETE FROM news_extra WHERE id = $loesch";
        mysqli_query($db, "DELETE FROM news_extra WHERE id = $loesch");
    }
    return $counter;
}