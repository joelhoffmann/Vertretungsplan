<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = new mysqli('localhost', 'root', '', 'dys');

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_REQUEST["term"])) {
    // Prepare a select statement
    $sql = "SELECT * FROM ereignis WHERE Inhalt OR EreignisTyp LIKE ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST["term"] . '%';

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            // Check number of rows in the result set
            if (mysqli_num_rows($result) > 0) {
                // Fetch result rows as an associative array

                echo '<table border = "1px">';
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
                while ($zeile = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $zeile['EID'] . "</td>";
                    echo "<td>" . $zeile['EreignisTyp'] . "</td>";
                    echo "<td>" . $zeile['Datum'] . "</td>";
                    echo "<td>" . $zeile['Klasse'] . "</td>";
                    echo "<td>" . $zeile['Inhalt'] . "</td>";
                    echo "</tr>";
                }
                echo "<?tbody></table>";

                //echo "<p>" . $row["Inhalt"] . "</p>";
            } else {
                echo "<p>No matches found</p>";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($link);
