<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    include '../backend/vertretungsplan-anzeigen.php';
    $db = dbConnect();

    //$anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(EID) FROM ereignis"))[0] + 1;

    $eintrag = "DELETE FROM ereignis WHERE EID=";
    $delete = mysqli_query($db, $eintrag);

    header('location: ../Einstellungen/settings.php');

    mysqli_close($db);

    ?>
</body>

</html>
