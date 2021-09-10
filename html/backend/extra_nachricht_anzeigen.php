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
        while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
            echo "<h2>".$zeile['title']."</h2></br></br>";
            echo "<p>".$zeile['text']."</p>";
            if($zeile['picture_location']){
                
                echo"hier ist ein bild";

            }
        }
    }
}
