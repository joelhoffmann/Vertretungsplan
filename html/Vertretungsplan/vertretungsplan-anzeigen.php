<?php
    function anzeigen($datum){
        $db = new mysqli('localhost', 'root', '', 'dys');
                if ($db->connect_errno) {
                    die("Verbindung fehlgeschlagen: " . $db->connect_error);
                }
                mysqli_set_charset($db, "utf8");
                //datum var kann behalten werden
                
                $sql = "SELECT `Stunde`, `Absenter_Lehrer`, `Vertretender_Lehrer`, `Fach`, `Raum`, `Klasse(n)`, `Text_zur_Vertretung` FROM vertretung_daten WHERE datum LIKE '$datum'";

                $db_erg = mysqli_query($db, $sql);
                if (!$db_erg) {
                    die('Ungültige Abfrage: ');
                }

                displayVar(9, $db_erg);
                mysqli_free_result($db_erg);
                mysqli_close($db);
    }
    function displayVar($length, $datensatz)
    {
        $gesLength = $datensatz->num_rows;
        $id = 0;
        while ($gesLength > 0) {
            $gesLength -= 9;
            echo '<div class="table-wrapper" id= "' . $id . '" style="display:block; table-layout: fixed"> <table class="fl-table">';
            echo '<thead> 
            <tr>
            <th>Stunde</th>
            <th>Absenter Lehrer</th>
            <th>Vertretender Lehrer</th>
            <th>Fach</th>
            <th>Raum</th>
            <th>Klasse(n)</th>
            <th>Info</th>
            </tr> 
            </thead>
            <tbody>';
            for ($i = 0; $i < $length; $i++) {
                if ($zeile = mysqli_fetch_array($datensatz, MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $zeile['Stunde'] . "</td>";
                    echo "<td>" . $zeile['Absenter_Lehrer'] . "</td>";
                    echo "<td>" . $zeile['Vertretender_Lehrer'] . "</td>";
                    echo "<td>" . $zeile['Fach'] . "</td>";
                    echo "<td>" . $zeile['Raum'] . "</td>";
                    echo "<td>" . $zeile['Klasse(n)'] . "</td>";
                    echo "<td>" . $zeile['Text_zur_Vertretung'] . "</td>";
                    echo "</tr>";
                }
            }

            echo "</tbody></table></div>";
            $id++;
        }
    }
?>