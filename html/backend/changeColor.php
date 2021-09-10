
<?php
include '../backend/vertretungsplan-anzeigen.php';
$db = dbConnect();

$MainBackgroundColor = $_POST["MainBackgroundColor"];
$InnerMainBox = $_POST["InnerMainBox"];
$InnerBoxBackgroundColor = $_POST["InnerBoxBackgroundColor"];
$BoxBackgroundColor = $_POST["BoxBackgroundColor"];
$BoxTextColor = $_POST["BoxTextColor"];

$anzahl = 0;

$anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM colorlayout"))[0] + 1;
$eintrag = "INSERT INTO `colorlayout`(`ID`, `F1`, `F2`, `F3`, `F4`, `F5`) VALUES ('1', '$MainBackgroundColor','$InnerMainBox','$InnerBoxBackgroundColor','$BoxBackgroundColor', '$BoxTextColor')";

$eintragen = mysqli_query($db, $eintrag);

header('location: ../frontend/settings.php');

mysqli_close($db);


?>
