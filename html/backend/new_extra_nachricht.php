<?php
include '../backend/vertretungsplan-anzeigen.php';

$db = dbConnect();
$target_dir = "../Pictures/";
$target_file = $target_dir . basename($_FILES["pictureToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["pictureToUpload"]["size"] > 5000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
echo $FileType;
if ($FileType == "jpg" || $FileType == "png" || $FileType == "PNG") {
    echo "Filetype ok";
    $uploadOk = 1;
} else {
    echo "Sorry, only jpg & png files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pictureToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["pictureToUpload"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
//Upload file to DB

$fileName = "../Pictures/" . htmlspecialchars(basename($_FILES["pictureToUpload"]["name"]));

$Titel = $_POST["Titel"];
$Text = $_POST["Nachricht_EN"];
$date_A = $_POST["date-A"];
$date_B = $_POST["date-B"];
$anzahl = 0;

$anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM news_extra"))[0] + 1;

$eintrag = "INSERT INTO `news_extra`(`ID`, `title`, `text`, `picture_location`, `date_start`, `date_end`) VALUES ('$anzahl','$Titel','$Text','$fileName','$date_A','$date_B'
    )";

$eintragen = mysqli_query($db, $eintrag);
echo ("Test");
header('location: ../frontend/settings.php');

mysqli_close($db);
