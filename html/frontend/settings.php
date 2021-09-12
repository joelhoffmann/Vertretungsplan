<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">

    <link rel="stylesheet" href="settings.css">
    <script language="javascript" type="text/javascript" src="../js/setti.js"></script>

    <title>Vertretungsplan Admin</title>
    <?php
    include '../backend/vertretungsplan-anzeigen.php';
    $db = dbConnect();
    $ip = getenv('REMOTE_ADDR');
    if (mysqli_query($db, "SELECT * FROM `settings`")->num_rows) {
        $eintrag = "SELECT * FROM `settings`"; //Ist da noch ein Sinn vorhanden?!?!?!
        $db_erg = mysqli_query($db, $eintrag);
        $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);
        $delay = $zeile['E1'];
        $speed = $zeile['E2'];
    }

    $db_erg = mysqli_query($db, "SELECT * FROM `colorlayout` WHERE 1");
    $zeile = mysqli_fetch_array($db_erg, MYSQLI_BOTH);

    $MainBackgroundColor = $zeile['F1'];
    $InnerMainBox = $zeile['F2'];
    $InnerBoxBackgroundColor = $zeile['F3'];
    $BoxBackgroundColor = $zeile['F4'];
    $BoxTextColor = $zeile['F5'];


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

        $('.gitpull').click(function() {
            $.ajax({
                type: "POST",
                url: "../backend/gitpull.php"
            }).done(function(data) {
                console.log("Pulled from Git");
                console.log(data);
            });
        });
    }

    function changeEventHandler(event) {
        var fullPath = document.getElementById('fileToUpload').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
        }
        document.getElementById('submit-lbl').style.visibility = 'visible';
        document.getElementById('upload-lbl').innerHTML = filename;
        document.getElementById('Bild').innerHTML = filename;
    }
</script>

<body style="margin: 0;">
    <nav>
        <header>Admin-Panel</header>
        <section class="menu">
            <a class="menu-link text-underlined" onclick="showDiv('1')">#UPLOAD</a>
            <a class="menu-link text-underlined" onclick="showDiv('2')">#Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('3')">#Extra Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('4')" hidden>#User</a>
            <a class="menu-link text-underlined" onclick="showDiv('5')">#System</a>

        </section>
    </nav>

    <div class="box" id="1" style="display:none;">
        <h3>Hochladen</h3>

        <form action="../backend/upload.php" method="post" enctype="multipart/form-data" id="form-upl">

            <label for="fileToUpload" id="upload-lbl">Klicken, um eine Datei auszuwählen</label>
            <input type="file" id="fileToUpload" name="fileToUpload" onchange="changeEventHandler(event);" hidden />
            <button id="submit-lbl" type="submit" name="submit" class="custom-btn btn-15" style="visibility: hidden; margin-top: 10px;">Hochladen</button>
        </form>

    </div>
    <div class="box" id="2" style="display:none;">
        <form action="../backend/new_nachricht.php" method="post">

            <h3>Nachricht</h3>
            <input id="Nachricht" name="Nachricht" placeholder="Nachricht eintippen">
            </br>
            <h3>Gültig bis</h3>
            <label for="date">Datum</label>
            </br>
            <input id="date" name="Datum" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">

            </br>
            <label for="Uhrzeit">Uhrzeit</label>
            <!--Uhrzeit muss noch gemacht werden-->
            </br>
            <input id="Uhrzeit" name="Uhrzeit" type="time" value="<?php echo date("H:i"); ?>" style="font-size: larger;">
            </br>
            <button>Fertig</button>
        </form>
    </div>
    <div class="box" id="3" style="display:none;">
        <h3>Extra Nachrichten</h3>
        <form action="../backend/new_extra_nachricht.php" method="post">
            <label for="Titel">Titel</label>
            </br>
            <input id="Titel" name="Titel">
            </br>

            <label for="Nachricht">Text</label>
            </br>
            <input id="Nachricht" name="Nachricht">
            </br>

            Bild
            </br>
            <label for="fileToUpload" id="Bild">Klicken, um eine Datei auszuwählen</label>
            <input type="file" id="fileToUpload" name="fileToUpload" onchange="changeEventHandler(event);" hidden />
            </br>

            <label for="date-A">Datum - Anfang</label>
            </br>
            <input id="date-A" name="date-A" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">
            </br>

            <label for="date-B">Datum - Ende</label>
            </br>
            <input id="date-B" name="date-B" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">
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
            <div class="grid-item grid-item-1 span-3">Color
                <div id="Color">
                    </br>
                    <form action="../backend/changeColor.php" method="post">
                        <label for="MainBackgroundColor">Haupt hintergrund</label>
                        </br>
                        <input type="color" name="MainBackgroundColor" value="<?php echo $MainBackgroundColor; ?>">
                        </br>

                        <label for="InnerMainBox">Main boxen</label>
                        </br>
                        <input type="color" name="InnerMainBox" value="<?php echo $InnerMainBox; ?>">
                        </br>

                        <label for="InnerBoxBackgroundColor">Mainboxen hintergrund</label>
                        </br>
                        <input type="color" name="InnerBoxBackgroundColor" value="<?php echo $InnerBoxBackgroundColor; ?>">
                        </br>

                        <label for="BoxBackgroundColor">Boxen hintergrund</label>
                        </br>
                        <input type="color" name="BoxBackgroundColor" value="<?php echo $BoxBackgroundColor; ?>">
                        </br>

                        <label for="BoxTextColor">Boxen schriftfarbe</label>
                        </br>
                        <input type="color" name="BoxTextColor" value="<?php echo $BoxTextColor; ?>">
                        </br>

                        <button type="submit">submit</button>

                    </form>

                </div>
            </div>
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
            <a class="grid-item grid-item-5" onclick="showDiv('1')">Update Database</a>
            <a class="grid-item grid-item-7" href="../frontend/vertretungsplan.php">Vertretungsplan</a>
            <a class="grid-item grid-item-7" href="../backend/gitpull.php">Git Pull</a>
        </div>

    </div>
    <script>
        showDiv('2');
    </script>
</body>

</html>