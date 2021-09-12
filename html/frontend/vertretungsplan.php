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

    //Abfrage welche News Art
    //Bei keiner Nachricht vorhanden darf die Funktion nicht ausgeführt werden
    ?>
    <script>
        /*
                var Switch = setInterval(function() {
                    if (document.getElementById('1').style.display == "block") {
                        document.getElementById('1').style.display = "none";
                        document.getElementById('2').style.display = "block";
                    } else {
                        document.getElementById('1').style.display = "block";
                        document.getElementById('2').style.display = "none";
                    }

                }, 3000); //Zeit muss noch auf 30 Sekunden gestellt werden
        */
        //Needs to be redone properly in php
        var style = getComputedStyle(document.documentElement);
        var MainBackgroundColor = style.getPropertyValue('--main-bg-color');
        var InnerMainBox = style.getPropertyValue('--innerMain-box');
        var InnerBoxBackgroundColor = style.getPropertyValue('--innerbox-bg-color');
        var BoxBackgroundColor = style.getPropertyValue('--box-bg-color');
        var BoxTextColor = style.getPropertyValue('--box-text-color');

        function master() {
            startTime();
            scroll(2, 2000);
            test(2);
        }
    </script>
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

        <!--Einträge News-->
        <article class="innerMain" id="2" style="display:none;">
            <header>Wichtig</header>
            </br>

            <?php
            $datum = date("Y-m-d");
            $db = dbConnect();
            showNews($db, $datum);
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


        //echo "<div id='marquee' class='marquee'><span>";
        while ($zeile = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo '<marquee behavior="scroll" direction="left" speed="10" scrollamount="5">' . $zeile['Inhalt'] . '</marquee>';
            //echo "test";
        }
        //echo "</span></div>";
        mysqli_close($db);
        ?>

    </section>
</body>

</html>