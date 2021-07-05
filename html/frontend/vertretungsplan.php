<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">

    <link rel="stylesheet" href="mainhome.css">
    <link rel="stylesheet" href="tabellen.css">

    <script language="javascript" type="text/javascript" src="vertretung.js"></script>
    <title>dys - display your school</title>

    <?php
    include 'vertretungsplan-anzeigen.php';

    $db = dbConnect();
    $ip = getenv('REMOTE_ADDR');
    if (mysqli_query($db, "SELECT * FROM `settings` WHERE `IP` LIKE '$ip' ")->num_rows) {
        $eintrag = "SELECT * FROM `settings` WHERE `IP` LIKE '$ip'";
        $db_erg = mysqli_query($db, $eintrag);
        $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);
        $time = $zeile['E1'];
        $speed = (int)$zeile['E2'];
    }

    ?>
    <script>
        var time = "<?php echo $time; ?>";
        var speed = "<?php echo (int)$speed; ?>";

        
        var myVar = setInterval(function() {

            scrolling("scrollarea");
            //scrolling("scrollarea2");


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
            <header>Heute</header>
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
        <article class="innerMain">
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
            echo "!!! ".$inhalt["Datum"]. ":&emsp; " .$inhalt["Inhalt"] . " !!!" . "&emsp;&emsp;&emsp;";//TODO: Datum muss noch schöner formatiert werden!!!
        }
        echo "</span></div>";
        mysqli_close($db);
        ?>

    </section>
</body>

</html>