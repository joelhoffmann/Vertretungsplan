<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="600000">
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
        var input = document.getElementById("Geschwindigkeit"); //Beide Funktionen werden nicht mehr verwendet
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
            }).done(function() {
                console.log("Pulled from Git");
            });
        });
    }

    function changeEventHandler($id) {
        var fullPath = document.getElementById($id).value;
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

        console.log('test');
        $.ajax({
            type: "POST",
            data: {
                parameter1: ''
            },
            url: "../backend/upload_image.php"
        }).done(function() {
            console.log('Done');

        });

    }

    function fileListener($in, $out) {
        $(document).ready(function() {
            $("#" + $in).keyup(function() {
                // Getting the current value of textarea
                var currentText = $(this).val();

                // Setting the Div content
                $("#" + $out).text(currentText);
            });
        });

    }

    fileListener("Titel", "vorschau_Title");
    fileListener("Nachricht_EN", "vorschau_Text");
</script>

<body style="margin: 0;">
    <nav>
        <header>Admin-Panel</header>
        <section class="menu">
            <!-- Menu könnte noch überarbeitet werden -->
            <a class="menu-link text-underlined" onclick="showDiv('1')">#UPLOAD</a>
            <a class="menu-link text-underlined" onclick="showDiv('2')">#Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('3')">#Extra Nachrichten</a>
            <a class="menu-link text-underlined" onclick="showDiv('4')" hidden>#User</a>
            <!--Kann noch entfernt werden-->
            <a class="menu-link text-underlined" onclick="showDiv('5')">#System</a>

        </section>
    </nav>
    <!--Hochladen-->
    <div class="box" id="1" style="display:none;">
        <h3>Hochladen</h3>
        <form action="../backend/upload.php" method="post" enctype="multipart/form-data" id="form-upl">

            <label for="fileToUpload" id="upload-lbl">Klicken, um eine Datei auszuwählen</label>
            <input type="file" id="fileToUpload" name="fileToUpload" onchange="changeEventHandler('fileToUpload');" hidden />
            <button id="submit-lbl" type="submit" name="submit" class="custom-btn btn-15" style="visibility: hidden; margin-top: 10px;">Hochladen</button>
        </form>

    </div>
    <!--Neue Nachricht-->
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
    <!--Extra Nachrichten-->
    <div class="box" id="3" style="display:none;">
        <h3>Extra Nachrichten</h3>
        <form action="../backend/new_extra_nachricht.php" method="post" enctype="multipart/form-data">
            <label for="Titel">Titel</label>
            </br>
            <input id="Titel" name="Titel" placeholder="Titel eintragen">
            </br>

            <label for="Nachricht_EN">Text</label>
            </br>
            <input id="Nachricht_EN" name="Nachricht_EN" placeholder="Text eintragen">
            </br>
            <label for="Bild">Bild</label>
            </br>
            <label for="pictureToUpload" id="Bild">Klicken, um ein Bild auszuwählen</label>
            <input type="file" id="pictureToUpload" name="pictureToUpload" onchange="changeEventHandler('pictureToUpload');" hidden />
            </br>
            <label for="date-A">Datum - Anfang</label>
            </br>
            <input id="date-A" name="date-A" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">
            </br>

            <label for="date-B">Datum - Ende</label>
            </br>
            <input id="date-B" name="date-B" type="date" data-date="" data-date-format="DD MMMM YYYY" value="<?php echo date("Y-m-d"); ?>" style="font-size: larger;">
            </br>

            <button>Fertig</button>
        </form>
        <script>
            pictureToUpload.onchange = evt => {
                const [file] = pictureToUpload.files
                if (file) {
                    vorschau_bild.src = URL.createObjectURL(file)
                }
            }
        </script>
        <section class="vorschau">
            <div id="vorschau_Title">
                dddd
            </div>
            <div id="vorschau_Text">
                ddd
            </div>

            <img id="vorschau_bild" src="#" style="max-width: 50%; max-height: 50%;" />

        </section>
        <span class="vorschauUnterschrift">Vorschau, ca. 85% der Originalgröße</span>
    </div>
    <!--User Interface kann noch entfernt werden-->
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
    <!--System-->
    <div id="5" style="display:none;">
        <p class="u-text u-text-8">
        <div class="grid-layout">
            <!--Farben einstellen-->
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
            <!--Geschwindigkeit, Delay und Update Database können entfernt werden-->
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
            <!-- Kann noch ausgebaut werden -->
            <a class="grid-item grid-item-5" onclick="showDiv('1')">Update Database</a>
            <!-- Verweist auf den Vertretungsplan -->
            <a class="grid-item grid-item-7" href="../frontend/vertretungsplan.php">Vertretungsplan</a>
            <!-- Ermöglicht einen Git Pull vom Repository zu machen -->
            <a class="grid-item grid-item-7" href="../backend/gitpull.php">Git Pull</a>
        </div>

    </div>
    <script>
        showDiv('3');
    </script>
</body>

</html>