<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="">
    <!--Refresh Intervall muss noch eingestellt werden-->
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
    $delay = 1000; //default delay
    $speed = 2; //default speed
    $db = dbConnect();
    $eintrag = "SELECT * FROM `settings`";
    $db_erg = mysqli_query($db, $eintrag);
    $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);
    $delay = $zeile['E1'];
    $speed = $zeile['E2'];

    ?>
    <script>
        var delay = "<?php echo $delay ?>";
        var speed = "<?php echo $speed ?>";
        $links = 0;
        $rechts = 0;
        //get bigger scrollarea

        function scroll() {
            if (document.getElementById("scrollarea1").scrollHeight > document.getElementById("scrollarea2").scrollHeight) {
                //scrollarea1 master
                $switch = 0;
                var links = setInterval(function() {
                    if (document.getElementById("scrollarea1").scrollTop + document.getElementById("scrollarea1").clientHeight >= document.getElementById("scrollarea1").scrollHeight) {
                        console.log("isch unne");
                        $switch = 1;
                    }else if(document.getElementById("scrollarea1").scrollTop <= 0){
                        $switch = 0;
                    }
                    if ($switch == 0) {
                        document.getElementById("scrollarea1").scrollTop += 1;
                        document.getElementById("scrollarea2").scrollTop += 1;
                        console.log("+");
                    }
                    if ($switch == 1) {
                        document.getElementById("scrollarea1").scrollTop -= 1;
                        document.getElementById("scrollarea2").scrollTop -= 1;
                        console.log("-");
                    }


                }, 0);

            } else {
                //scrollarea2 master
            }
        }


        /*
                var links = setInterval(function() {
                    //wenns ove isch

                    console.log(document.getElementById("scrollarea1").scrollHeight);

                    if (document.getElementById("scrollarea1").scrollTop <= 0) {
                        $links = 0;
                    }
                    //wenns unne isch
                    else if (document.getElementById("scrollarea1").scrollTop + document.getElementById("scrollarea1").clientHeight >= document.getElementById("scrollarea1").scrollHeight) {
                        $links = 1;
                    }
                    scrolling("scrollarea1", $links, delay, speed);

                }, 5);
                */


        function startTime() {
            var today = new Date();
            var hours = today.getHours();
            var minutes = today.getMinutes();
            minutes = checkTime(minutes);
            document.getElementById('Uhrzeit').innerHTML =
                hours + ":" + minutes;
            var t = setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }

        //Needs to be redone properly in php
        var style = getComputedStyle(document.documentElement);
        var MainBackgroundColor = style.getPropertyValue('--main-bg-color');
        var InnerMainBox = style.getPropertyValue('--innerMain-box');
        var InnerBoxBackgroundColor = style.getPropertyValue('--innerbox-bg-color');
        var BoxBackgroundColor = style.getPropertyValue('--box-bg-color');
        var BoxTextColor = style.getPropertyValue('--box-text-color');

        function master() {
            startTime();
            scroll();

        }
    </script>
</head>

<body style="margin: 0;" onload="master()">

    <main>

        <!--Einträge heute-->
        <article class="innerMain">
            <header><a onclick="test('1');">Heute</a></header>
            <section class="outerBox" id="scrollarea1">
                <?php
                $db = dbConnect();
                setEntry($db, date('Y-m-d'), 0);
                mysqli_close($db);
                ?>
            </section>
        </article>

        <!--Einträge Nächster Tag-->
        <article class="innerMain" id="1" style="display:none;">
            <header>Nächster Tag</header>
            <section class="outerBox" id="scrollarea2">
                <?php
                $db = dbConnect();
                $morgen = date('Y-m-d', strtotime('now + 1 day'));
                setEntry($db, $morgen, 0);
                //TODO: must implement to check if morgen exists in file, if not go one day further til on day is found.
                mysqli_close($db);
                ?>
            </section>
        </article>
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
        $eintrag = "SELECT * FROM `news` WHERE `Datum` LIKE '$datum'";
        $result = mysqli_query($db, $eintrag);
        echo "<div id='marquee' class='marquee'><span>";
        while ($inhalt = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo "!!! " . $inhalt["Datum"] . ":&emsp; " . $inhalt["Inhalt"] . " !!!" . "&emsp;&emsp;&emsp;"; //TODO: Datum muss noch schöner formatiert werden!!!
        }
        echo "</span></div>";
        mysqli_close($db);
        ?>

    </section>
    <script>
        <?php
        //Abfrage welche News Art
        //Bei keiner Nachricht vorhanden darf die Funktion nicht ausgeführt werden
        ?>
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
        test(1);
    </script>
</body>

</html>