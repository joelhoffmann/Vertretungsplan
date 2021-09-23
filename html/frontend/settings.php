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
    if (mysqli_query($db, "SELECT * FROM `settings`")->num_rows) { //Wird nicht mehr benötigt
        $eintrag = "SELECT * FROM `settings`";
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
            <a class="menu-link text-underlined" onclick="showDiv('4')">#System</a>
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
            </br>
            <h2 id="vorschau_Title"></h2>
            <section id="innerVorschau">
                <div id="vorschau_Text"></div>
                <img id="vorschau_bild" src="#" alt="">
            </section>
        </section>
        <script>
            vorschau_bild.onload = function(){
                if(this.naturalWidth >this.naturalHeight){
                    document.getElementById('innerVorschau').setAttribute("style", "display: grid;width: 90%;margin: auto;grid-auto-flow: row;row-gap: 10%;");
                    document.getElementById('vorschau_Text').setAttribute("style", "margin: auto;");

                }else{
                    document.getElementById('innerVorschau').setAttribute("style", "display: grid;width: 90%;grid-template-columns: 50% 50%;column-gap: 5%;");
                    document.getElementById('vorschau_Text').setAttribute("style", "margin-left: 20%;");
                }
                
            }
        </script>
        <span class="vorschauUnterschrift">Vorschau, ca. 85% der Originalgröße</span>
    </div>
    <!--System-->
    <div id="4" style="display:none;">
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
                        </br>
                        <button type="submit">submit</button>

                    </form>

                </div>
            </div>
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