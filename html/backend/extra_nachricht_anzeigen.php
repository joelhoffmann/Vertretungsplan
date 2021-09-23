<?php
function showNews($db, $datum)
{
    //$sql = "SELECT * FROM `news_extra` WHERE `date_start` =< '$datum' AND `date_end` => '$datum'";
    $sql = "SELECT * FROM `news_extra` WHERE `date_start` >= '$datum'";

    $db_erg = mysqli_query($db, $sql); //Ausführung
    if (!$db_erg) {
        die('Ungültige Abfrage: ');
    }
    if ($db_erg->num_rows > 0) {
        if ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
            echo "<h1>" . $zeile['title'] . "</h1>";
            echo "<div id='news-text'>" . $zeile['text'] . "</div>";
            if ($zeile['picture_location']) {
                echo "<img  src=" . $zeile['picture_location'] . " alt='' id='news-bild' align='right'>";
            }
        }
    }
}
