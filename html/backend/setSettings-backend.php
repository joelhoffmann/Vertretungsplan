<?php

if ($_REQUEST["term2"] == "Geschwindigkeit") {

    if ($_REQUEST["term"]) {
        $uebergang = $_REQUEST["term"];
        $ip = getenv('REMOTE_ADDR');

        $db = new mysqli('localhost', 'root', '', 'dys');
        if ($db->connect_errno) {
            die("Verbindung fehlgeschlagen: " . $db->connect_error);
        }
        mysqli_set_charset($db, "utf8");

        if (mysqli_query($db, "SELECT * FROM `settings` WHERE `IP` LIKE '$ip' ")->num_rows) {
            $eintrag = "UPDATE `settings` SET `E2`='$uebergang' WHERE `IP` LIKE '$ip'";
            $eintragen = mysqli_query($db, $eintrag);
        } else {
            $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM settings"))[0] + 1;
            $eintrag = "INSERT INTO `settings`(`ID`, `IP`, `E1`, `E2`, `E3`, `E4`, `E5`, `E6`) VALUES ('$anzahl','$ip','$uebergang','-','-','-','-','-')";
            $eintragen = mysqli_query($db, $eintrag);
        }

        mysqli_close($db);
        echo "Done";
    } else {
        echo "Zahl eingeben";
    }
} else if ($_REQUEST["term2"] == "Delay") {

    if ($_REQUEST["term"]) {
        $uebergang = $_REQUEST["term"];
        $ip = getenv('REMOTE_ADDR');

        $db = new mysqli('localhost', 'root', '', 'dys');
        if ($db->connect_errno) {
            die("Verbindung fehlgeschlagen: " . $db->connect_error);
        }
        mysqli_set_charset($db, "utf8");

        if (mysqli_query($db, "SELECT * FROM `settings` WHERE `IP` LIKE '$ip' ")->num_rows) {
            $eintrag = "UPDATE `settings` SET `E1`='$uebergang' WHERE `IP` LIKE '$ip'";
            $eintragen = mysqli_query($db, $eintrag);
        } else {
            $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM settings"))[0] + 1;
            $eintrag = "INSERT INTO `settings`(`ID`, `IP`, `E1`, `E2`, `E3`, `E4`, `E5`, `E6`) VALUES ('$anzahl','$ip','-','$uebergang','-','-','-','-')";
            $eintragen = mysqli_query($db, $eintrag);
        }

        mysqli_close($db);
        echo "Done";
    } else {
        echo "Zahl eingeben";
    }
}