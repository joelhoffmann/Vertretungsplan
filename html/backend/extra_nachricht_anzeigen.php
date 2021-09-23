<?php
function showNews($db, $datum)
{
    //$sql = "SELECT * FROM `news_extra` WHERE `date_start` =< '$datum' AND `date_end` => '$datum'";
    $sql = "SELECT * FROM `news_extra` WHERE `date_start` >= '$datum'";

    $db_erg = mysqli_query($db, $sql); //Ausführung
    if (!$db_erg) {
        die('Ungültige Abfrage: ');
    }
    echo "<section class='outerExtra'>";
    if ($db_erg->num_rows > 0) {
        while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
            echo "<h2>" . $zeile['title'] . "</h2></br>";
            echo "<div>" . $zeile['text'] . "</div>";
            if ($zeile['picture_location']) {
                list($width, $height) = getimagesize($zeile['picture_location']);
                if ($width > $height) {//Querformat
                    echo "<img class='ExtraPicture' src=" . $zeile['picture_location'] . " alt='' width='84%' height='84%' >";
                    echo "<style>.outerExtra{display: grid;width: 100%;grid-auto-flow: row;}</style>";//custom css for outerExtra
                } else {//Hochformat
                    echo "<img class='ExtraPicture' src=" . $zeile['picture_location'] . " alt='' width='70%' height='100%'>";
                    echo "<style>.outerExtra{display: grid;column-gap: 5%;width: 100%;grid-template-columns: 50% 50%;}</style>";//custom css for outerExtra 
                }
            }
        }
    }
    echo "</section>";
}
