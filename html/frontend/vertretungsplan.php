<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="300000">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">

    <link rel="stylesheet" href="mainhome.css">

    <script language="javascript" type="text/javascript" src="../js/vertretung.js"></script>
    <script language="javascript" type="text/javascript" src="../js/setti.js"></script>


    <title>dys - display your school</title>

    <?php
    include '../backend/vertretungsplan-anzeigen.php';
    include '../backend/extra_nachricht_anzeigen.php';

    $db = dbConnect();
    $db_erg = mysqli_query($db, "SELECT * FROM `colorlayout` WHERE 1");
    $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);

    $MainBackgroundColor = $zeile['F1'];
    $InnerMainBox = $zeile['F2'];
    $InnerBoxBackgroundColor = $zeile['F3'];
    $BoxBackgroundColor = $zeile['F4'];
    $BoxTextColor = $zeile['F5'];
    ?>
    <script>
        function master() {
            startTime();
            scroll(2, 2000);
            test(1);
            //switchbetween(3000);
            //showNewsSwitch(13, 10000);
        }
    </script>
    <style>
        :root {
            /*Main Background color*/
            --main-bg-color: <?php echo $MainBackgroundColor; ?>;
            /*color for big boxes*/
            --innerMain-box: <?php echo $InnerMainBox; ?>;
            /*color for the smaller boxes of the separate classes*/
            --innerbox-bg-color: <?php echo $InnerBoxBackgroundColor; ?>;
            /*color for separate boxes*/
            --box-bg-color: <?php echo $BoxBackgroundColor; ?>;
            /*text color in boxes*/
            --box-text-color: <?php echo $BoxTextColor; ?>;
        }
    </style>
</head>

<body style="margin: 0;" onload="master()">

    <main>

        <!--Einträge heute-->
        <article class="innerMain">
            <header>Heute</header>
            <section class="outerBox" id="scrollarea1">
                <?php
                $db = dbConnect();
                setEntry($db, date('Y-m-d'), 0); //Heute muss immer Heute sein
                mysqli_close($db);
                ?>
            </section>
        </article>

        <!--Einträge Nächster Tag-->
        <article class="innerMain" id="1" style="display:none;">
            <header id="naechsterTag">Nächster Tag</header>
            <section class="outerBox" id="scrollarea2">
                <?php
                $db = dbConnect();
                $morgen = date('Y-m-d', strtotime('now + 1 day'));
                $newDate = setEntry($db, $morgen, 0);
                mysqli_close($db);
                ?>
                <script>
                    var change = "<?php echo $newDate; ?>";
                    nextDay(change);
                </script>
            </section>
        </article>

        <!--Einträge Extra News-->
        <article class="innerMain" id="2" style="display:none;">
            <header>News</header>
            </br>
            <?php
            $datum = date("Y-m-d");
            $db = dbConnect();
            $counter = showNews($db);
            echo"<script>showNewsSwitch($counter, 2000);</script>";
            mysqli_close($db);
            ?>

        </article>
    </main>
    <!--Uhrzeit-->
    <section class="time" id="uhr">
        <div id="Uhrzeit"></div>
    </section>
    <!--News-->
    <section class="news">
        <header>News</header>
        <?php
        $db = dbConnect();
        $datum = date("Y-m-d");
        $timestamp = time();
        $uhrzeit = date("H:i", $timestamp);
        $eintrag = "SELECT * FROM `news` WHERE `Datum` LIKE '$datum'";
        $result = mysqli_query($db, $eintrag);
        $stack = array();

        while ($zeile = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $start = strtotime($uhrzeit);
            $end = strtotime($zeile['Uhrzeit']);
            $diff = ($end - $start) / 60;

            if ($diff <= 0) {
                array_push($stack, $zeile['NID']);
            }
        }

        if (count($stack) > 0) {
            for ($i = 0; $i < count($stack); $i++) {
                mysqli_query($db, "DELETE FROM `news` WHERE `NID` = '$stack[$i]' ");
            }
        }

        $eintrag = "SELECT * FROM `news` WHERE `Datum` LIKE '$datum'";
        $result = mysqli_query($db, $eintrag);
        if ($result->num_rows > 0) {
            echo '<div id="marquee" class="marquee"><span>';
            while ($zeile = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '|&emsp;'.$zeile['Inhalt'] . '&emsp;|&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
            }
            mysqli_close($db);
            echo '</span></div>';
        }
        ?>

    </section>
</body>

</html>