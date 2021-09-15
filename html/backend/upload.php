<?php

include '../backend/vertretungsplan-anzeigen.php';
$db = dbConnect();


//Delete all files in folder "Files"
$files = glob('../Files/*'); // get all file names
foreach ($files as $file) { // iterate files
    if (is_file($file))
        unlink($file); // delete file
}

$target_dir = "../Files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($FileType != "txt") {
    echo "Sorry, only txt files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
//Upload file to DB

$fileName = "../Files/" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));


if (!file_exists($fileName)) {
    echo "The file from above cannot be found!";
    exit;
}
$fp = fopen("../data/" . $fileName, "r");
if (!$fp) {
    echo "Somehow the file cannot be opened! :)";
    exit;
}

mysqli_query($db, "DROP TABLE `vertretung_daten`");

mysqli_query($db, "CREATE TABLE `vertretung_daten` (
    `Vertretungsnummer` int(11) NOT NULL,
    `Datum` date NOT NULL,
    `Stunde` varchar(50) NOT NULL,
    `Absenter_Lehrer` varchar(50) NOT NULL,
    `Vertretender_Lehrer` varchar(50) NOT NULL,
    `Fach` varchar(50) NOT NULL,
    `Vertretungsfach` varchar(50) NOT NULL,
    `Raum` varchar(50) NOT NULL,
    `Vertretungsraum` varchar(50) NOT NULL,
    `Klasse(n)` varchar(50) NOT NULL,
    `Text_zur_Vertretung` varchar(50) NOT NULL,
    `Vertretungsklasse(n)` varchar(50) NOT NULL,
    `Vertretungsart` varchar(11) NOT NULL,
    PRIMARY KEY (`Vertretungsnummer`)
  )");

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
    $Vertretungsart = str_replace('"', '', $Art);
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

        /*if ((strpos($Vertretungsart, "L") !== false) == false) {
            if ((strpos($Vertretungsart, "A") !== false) === false) {
                if ((strpos($Vertretungsart, "S") !== false) === false) {
                    if ((strpos($Vertretungsart, "B") !== false) === false) {
                        mysqli_query($db, $sql);
                    }
                }
            }
        }*/
        echo $Art;
    }
}

mysqli_close($db);
fclose($fp);

//header('location: ../frontend/settings.php');
