<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">

    <link rel="stylesheet" href="mainhome.css">

    <script language="javascript" type="text/javascript" src="../js/vertretung.js"></script>
    <script language="javascript" type="text/javascript" src="../js/setti.js"></script>
    <title>dys - display your school</title>

    <?php
    include '../backend/vertretungsplan-anzeigen.php';
    $delay = 1000; //default delay
    $speed = 2 //default speed
    $db = dbConnect();
    //$ip = getenv('REMOTE_ADDR');
    //if (mysqli_query($db, "SELECT * FROM `settings` WHERE `IP` LIKE '$ip' ")->num_rows) {
    	$eintrag = "SELECT * FROM `settings`";
    	//$eintrag = "SELECT * FROM `settings` WHERE `IP` LIKE '$ip'"; //Ist da noch ein Sinn vorhanden?!?!?!
        $db_erg = mysqli_query($db, $eintrag);
        $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);
        $delay = $zeile['E1'];
        $speed = $zeile['E2'];
    }

    ?>
    <script>
        var delay = "<?php echo $delay ?>";
        var speed = "<?php echo $speed ?>";
        $links = 0;
        $rechts = 0;

        var links = setInterval(function() {
            //wenns ove isch
            if (document.getElementById("scrollarea").scrollTop <= 0) {
                $links = 0;
            }
            //wenns unne isch
            else if (document.getElementById("scrollarea").scrollTop + document.getElementById("scrollarea").clientHeight >= document.getElementById("scrollarea").scrollHeight) {
                $links = 1;
            }
            scrolling("scrollarea", $links, delay, speed);

        }, 5);
        
        var rechts = setInterval(function() {
            //wenns ove isch
            if (document.getElementById("scrollarea2").scrollTop <= 0) {
                $rechts = 0;
            }
            //wenns unne isch
            else if (document.getElementById("scrollarea2").scrollTop + document.getElementById("scrollarea2").clientHeight >= document.getElementById("scrollarea2").scrollHeight) {
                $rechts = 1;
            }
            scrolling("scrollarea2", $rechts, delay, speed);

        }, 5);

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            m = checkTime(m);
            document.getElementById('Uhrzeit').innerHTML =
                h + ":" + m;
            var t = setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }
    </script>
</head>

<body style="margin: 0;" onload="startTime()">




    <main>

        <!--Einträge heute-->
        <article class="innerMain">
            <header><a onclick="test('1');">Heute</a></header>
            <section class="outerBox" id="scrollarea">
                <?php
                $datum = date("Y-m-d");
                $db = dbConnect();
                setEntry($db, $datum);
                mysqli_close($db);
                ?>
            </section>
        </article>

        <!--Einträge morgen-->
        <article class="innerMain" id="1" style="display:none;">
            <header>Morgen</header>
            <section class="outerBox" id="scrollarea2">
                <?php
                $morgen = date('Y-m-d', strtotime('now + 1 day'));
                $db = dbConnect();
                setEntry($db, $morgen);
                mysqli_close($db);
                ?>
            </section>
        </article>
        <article class="innerMain" id="2" style="display:none;">
            <header>Wichtig</header>
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

                }, 3000);//Zeit muss noch auf 30 Sekunden gestellt werden
        */
        test(1);
    </script>
</body>

</html>
