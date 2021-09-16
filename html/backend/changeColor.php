<?php
include '../backend/vertretungsplan-anzeigen.php';
$db = dbConnect();

$MainBackgroundColor = $_POST["MainBackgroundColor"];
$InnerMainBox = $_POST["InnerMainBox"];
$InnerBoxBackgroundColor = $_POST["InnerBoxBackgroundColor"];
$BoxBackgroundColor = $_POST["BoxBackgroundColor"];
$BoxTextColor = $_POST["BoxTextColor"];

$eintrag = "UPDATE `colorlayout` SET `F1`='$MainBackgroundColor', `F2`='$InnerMainBox', `F3`='$InnerBoxBackgroundColor', `F4`='$BoxBackgroundColor', `F5`='$BoxTextColor'";
$eintragen = mysqli_query($db, $eintrag);

header('location: ../frontend/settings.php');

mysqli_close($db);
