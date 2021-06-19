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
</head>
<?php
include 'vertretungsplan-anzeigen.php';
?>
<style>

</style>

<body style="margin: 0;">
    <!--News-->
    <section class="news">
        <header>News</header>
        <?php
        $db = dbConnect();
        $eintrag = "SELECT * FROM `news`";
        $result = mysqli_query($db, $eintrag);
        echo "<div id='marquee' class='marquee'><span>";
        while ($inhalt = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo "!!! " . $inhalt["Inhalt"] . " !!!" . "&emsp;&emsp;&emsp;";
        }
        echo "</span></div>";
        mysqli_close($db);
        ?>

    </section>

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
</body>

</html>