<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">

    <link rel="stylesheet" href="einstellungs.css">
    <script language="javascript" type="text/javascript" src="../js/setti.js"></script>

    <title>Document</title>
    <?php
    include '../backend/vertretungsplan-anzeigen.php';

    $db = dbConnect();
    $ip = getenv('REMOTE_ADDR');
    if (mysqli_query($db, "SELECT * FROM `settings` WHERE `IP` LIKE '$ip' ")->num_rows) {
        $eintrag = "SELECT * FROM `settings` WHERE `IP` LIKE '$ip'"; //Ist da noch ein Sinn vorhanden?!?!?!
        $db_erg = mysqli_query($db, $eintrag);
        $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);
        $delay = $zeile['E1'];
        $speed = $zeile['E2'];
    }

    ?>

</head>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    window.onload = function() {
        var input = document.getElementById("Geschwindigkeit");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                var inputVal = document.getElementById("inhalt").value;
                var wertTyp = "Geschwindigkeit";
                var resultDropdown = $(this).children(".status")
                $.get("../backend/setSettings-backend.php", {
                    term: inputVal,
                    term2: wertTyp
                }).done(function(data) {
                    resultDropdown.html(data);
                $(function() {
                    setTimeout(function() {
                        $(".status").replaceWith("</br>");
                    }, 2000);
                    });
                });
            }
        });

        var input2 = document.getElementById("Delay");
        input2.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                var inputVal = document.getElementById("inhalt2").value;
                var wertTyp = "Delay";
                var resultDropdown = $(this).children(".status2")

                $.get("../backend/setSettings-backend.php", {
                    term: inputVal,
                    term2: wertTyp
                }).done(function(data) {
                    resultDropdown.html(data);
                    $(function() {
                    setTimeout(function() {
                        $(".status2").replaceWith("</br>");
                    }, 2000);
                    });
                });
            }
        });



    }
</script>

<body style="margin: 0;">
    <nav>
        <header>Admin-Navigation</header>
        <section class="menu">
            <a class="menu-link text-underlined" onclick="showDiv('1')">#Eintrag</a>
            <a class="menu-link text-underlined" onclick="showDiv('2')">#Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('3')">#Extra Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('4')">#User</a>
            <a class="menu-link text-underlined" onclick="showDiv('5')">#System</a>

        </section>
    </nav>

    <div class="box" id="1" style="display:none;">
        <h3>Eintrag</h3>
        <!--Tabelle muss noch besser dargestellt werden !!IMPORTANT!!-->
        <form action="new_ereignis.php" method="post">

            <label for="EreignisTyp">Ereignis-Typ:</label>
            </br>
            <input id="EreignisTyp" name="Ereignis_Typ">
            </br>
            <label for="date">Datum:</label>
            </br>
            <input id="date" name="Datum" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">
            </br>
            <label for="class">Klasse:</label>
            </br>
            <input id="class" name="Klasse">
            </br>
            <label for="content">Inhalt:</label>
            </br>
            <input id="content" name="Inhalt">
            </br>
            <button>Fertig</button>
        </form>
    </div>
    <div class="box" id="2" style="display:none;">
        <h3>Nachrichten</h3>
        <form action="new_nachricht.php" method="post">

            <label for="Nachricht">Nachricht</label>
            </br>
            <input id="Nachricht" name="Nachricht">
            </br>
            <label for="date">Datum</label>
            </br>
            <input id="date" name="Datum" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">

            </br>
            <label for="Uhrzeit">Uhrzeit</label>
            <!--Uhrzeit muss noch gemacht werden-->
            </br>
            <input id="Uhrzeit" name="Uhrzeit" type="time" value="<?php echo date("H:i"); ?>" style="font-size: larger;">
            </br>

            <label for="prio">Priorität</label>
            </br>
            <input type="range" min="0" max="5" id="prio" name="prio">
            </br>
            <button>Fertig</button>
        </form>
    </div>
    <div class="box" id="3" style="display:none;">
        <h3>Extra Nachrichten</h3>
        <form action="new_nachricht.php" method="post">

            <label for="Nachricht">Titel</label>
            </br>
            <input id="Nachricht" name="Nachricht">
            </br>
            <label for="Nachricht">Text</label>
            </br>
            <input id="Nachricht" name="Nachricht">
            </br>
            <label for="Bild">Bild</label>
            </br>
            <input id="Bild" name="Bild" type="file">
            </br>
            <label for="date">Datum</label>
            </br>
            <input id="date" name="Datum" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">

            </br>
            <label for="Uhrzeit">Uhrzeit</label>
            <!--Uhrzeit muss noch gemacht werden-->
            </br>
            <input id="Uhrzeit" name="Uhrzeit" type="time" value="<?php echo date("H:i"); ?>" style="font-size: larger;">
            </br>

            <label for="prio">Priorität</label>
            </br>
            <input type="range" min="0" max="5" id="prio" name="prio">
            </br>
            <button>Fertig</button>
        </form>
    </div>
    <div class="box" id="4" style="display:none;">
        <h3>User</h3>
        <form action="new_user.php" method="post">
            <label for="Username">Username</label>
            </br>
            <input id="Username" name="Username">
            </br>
            <label for="Passwort">Passwort</label>
            </br>
            <input id="Passwort" name="Passwort" type="password">
            </br>
            <label for="Passwort-wdh">Passwort wdh</label>
            </br>
            <input id="Passwort-wdh" name="Passwort-wdh" type="password">
            </br>
            <label for="Email">Email</label>
            </br>
            <input id="Email" name="Email">
            </br>
            <button>Fertig</button>
        </form>
    </div>
    <div id="5" style="display:none;">
        <p class="u-text u-text-8">
        <div class="grid-layout">
            <div class="grid-item grid-item-1 span-2">Geschwindigkeit
                <div id="Geschwindigkeit">
                    </br>
                    <input id="inhalt" value="<?php echo $speed ?>">
                    </br></br>
                    <div class="status"></br></div>
                </div>
            </div>
            <div class="grid-item grid-item-2 span-2">Delay
                <div id="Delay">
                    </br>
                    <input id="inhalt2" value="<?php echo $delay ?>">
                    </br>
                    </br>
                    <div class="status2"></br></div>
                </div>
            </div>
            <a class="grid-item grid-item-5" href="../backend/updateDB.php">Update Database</a>
            <a class="grid-item grid-item-7" href="../frontend/vertretungsplan.php">Vertretungsplan</a>

        </div>


    </div>
    <script>
        showDiv('4');
    </script>
</body>

</html>