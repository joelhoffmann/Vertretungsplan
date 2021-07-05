<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Joel Hoffmann">
    <meta name="author" content="Simon Krieger">


    <link rel="stylesheet" href="einstellungs.css">
    <script language="javascript" type="text/javascript" src="setti.js"></script>

    <title>Document</title>


</head>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.search-box input[type="search"]').on("keyup input", function() {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).parent().siblings(".result");

            if (inputVal.length) {
                $.get("backend-search.php", {
                    term: inputVal
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });
        // Set search input value on click of result item
        $(document).on("click", ".result p", function() {
            $(this).parents(".search-box").find('input[type="search"]').val($(this).text());
            $(this).parent(".result").empty();
        });

    });

    window.onload = function() {
        var input = document.getElementById("GeschwindigkeitUebergang");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                var inputVal = document.getElementById("inhalt").value;
                var wertTyp = "GeschwindigkeitUebergang";
                var resultDropdown = $(this).children(".status")

                $.get("setSettings-backend.php", {
                    term: inputVal,
                    term2: wertTyp
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            }
        });

        var input2 = document.getElementById("AnzahlEintraege");
        input2.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                var inputVal = document.getElementById("inhalt2").value;
                var wertTyp = "AnzahlEintraege";
                var resultDropdown = $(this).children(".status2")

                $.get("setSettings-backend.php", {
                    term: inputVal,
                    term2: wertTyp
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
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
            <a class="menu-link text-underlined" onclick="showDiv('3')">#User</a>
            <a class="menu-link text-underlined" onclick="showDiv('4')">#System</a>

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
            <input id="Uhrzeit" name="Uhrzeit" type="time" value="<?php echo date("H:i"); ?>"style="font-size: larger;">
            </br>

            <label for="prio">Priorität</label>
            </br>
            <input type="range" min="0" max="5" id="prio" name="prio">
            </br>
            <button>Fertig</button>
        </form>


    </div>
    <div class="box" id="3" style="display:none;">
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
    <div id="4" style="display:none;">
        <p class="u-text u-text-8">

        <div class="grid-layout">
            <div class="grid-item grid-item-1 span-2">Geschwindigkeit der Slidefunktion
                <div id="GeschwindigkeitUebergang">
                    <input id="inhalt">
                    <div class="status"></div>
                </div>
            </div>
            <!--
            <div class="grid-item grid-item-2 span-2">Wartezeit bei Ende der Liste
                <div id="AnzahlEintraege">
                    <input id="inhalt2">
                    <div class="status2"></div>
                </div>

            </div>
            -->
            <a class="grid-item grid-item-5" href="../Einstellungen/updateDB.php">Update Database</a>
            <!--
            <div class="grid-item span-2 grid-item-6">Search


                <div class="search-box">
                    <div class="search-bar">
                        <input id="search" type="search" autocomplete="off" placeholder="Search country..." name="search" pattern=".*\S.*" required>
                        <button class="search-btn" type="reset">
                            <span>Search</span>
                        </button>
                    </div>
                    <div class="result"></div>
                </div>

            </div>
            -->
            <a class="grid-item grid-item-7" href="../Vertretungsplan/vertretungsplan.php">Vertretungsplan</a>
        </div>

    </div>
    <script>
        showDiv('4');
    </script>
</body>

</html>