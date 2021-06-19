<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="einstellungs.css">
    <script language="javascript" type="text/javascript" src="sett.js"></script>

    <title>Document</title>

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
    </script>
    <script>
        function reply_click(clicked_id) {
            alert(clicked_id);

        }

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
            /*
                        document.getElementById("overall").addEventListener("click", function() {
                            alert(this.id);
                        });*/



        }
    </script>

</head>

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
        <?php
        $db = new mysqli('localhost', 'root', '', 'dys');
        if ($db->connect_errno) {
            die("Verbindung fehlgeschlagen: " . $db->connect_error);
        }
        mysqli_set_charset($db, "utf8");

        $sql = "SELECT * FROM ereignis";

        $db_erg = mysqli_query($db, $sql);
        if (!$db_erg) {
            die('Ungültige Abfrage: ');
        }

        echo '</br><table border = "1px" style=" table-layout: fixed, position: absolute">';
        echo '<thead> 
                    <tr>
                    <th>EID</th>
                    <th>Ereignbis Typ</th>
                    <th>Datum</th>
                    <th>Klasse</th>
                    <th>Inhalt</th>
                    </tr> 
                    </thead>
                    <tbody>';
        while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $zeile['EID'] . "</td>";
            echo "<td>" . $zeile['EreignisTyp'] . "</td>";
            echo "<td>" . $zeile['Datum'] . "</td>";
            echo "<td>" . $zeile['Klasse'] . "</td>";
            echo "<td>" . $zeile['Inhalt'] . "</td>";
            echo "</tr>";
        }
        echo "<?tbody></table>";
        mysqli_free_result($db_erg);
        ?>
    </div>
    <div class="box" id="2" style="display:none;">
        <h3>Nachrichten</h3>
        <form action="new_nachricht.php" method="post">

            <label for="Nachricht">Nachricht</label>
            </br>
            <input id="Nachricht" name="Nachricht">
            </br>
            <label for="date">Uhrzeit</label>
            <!--Uhrzeit muss noch gemacht werden-->
            </br>
            <input id="Uhrzeit" name="Uhrzeit" type="time" style="font-size: larger;">
            </br>
            <label for="prio">Priorität</label>
            </br>
            <input id="prio" name="prio">
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
            <div class="grid-item grid-item-1">Geschwindigkeit der Slidefunktion
                <div id="GeschwindigkeitUebergang">
                    <input id="inhalt">
                    <div class="status"></div>
                </div>
            </div>
            <div class="grid-item grid-item-2">Wartezeit bei Ende der Liste
                <div id="AnzahlEintraege">
                    <input id="inhalt2">
                    <div class="status2"></div>
                </div>

            </div>
            <div class="grid-item grid-item-5">
            
                <a href="../Einstellungen/updateDB.php"> Refresh DB </a>
            
            </div>
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
            <a class="grid-item grid-item-7" href="../Vertretungsplan/vertretungsplan.php">Vertretungsplan</a>
            <div class="grid-item grid-item-8">item 8</div>
            <div class="grid-item grid-item-9">item 9</div>
            <div class="grid-item span-2 grid-item-10">item 10</div>
        </div>

    </div>
    <script>
        showDiv('4');
    </script>
</body>

</html>