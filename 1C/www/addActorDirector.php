<html>
<head>
<title>Add a new actor / director</title>
</head>
<body>
    <?php
    $identity = $first = $last = $sex = $dob = $dod = "";
    ?>
    <h2>Add a New Actor / Director</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Identity:
   <input type="radio" name="identity" value="actor">Actor
   <input type="radio" name="identity" value="director">Director
   <br><br>
   First Name: <input type="text" name="first" maxlength="20">
   <br><br>
   Last Name: <input type="text" name="last" maxlength="20">
   <br><br>
   Sex:
   <input type="radio" name="sex" value="Male">Male
   <input type="radio" name="sex" value="Female">Female
   <br><br>
   Date of Birth:  <input type="text" name="dob"> (YYYY-MM-DD)
   <br><br>
   Date of Death:  <input type="text" name="dod"> (YYYY-MM-DD) (Leave blank if still alive)
   <br><br>
   <input type="submit" name="submit" value="Add">
</form>
<?php
if (isset($_GET['submit'])) {
    $identity = ($_GET["identity"]);
    $first = ($_GET["first"]);
    $last = ($_GET["last"]);
    $sex = ($_GET["sex"]);
    $dob = ($_GET["dob"]);
    $dod = ($_GET["dod"]);

    // Bad input checks
    if ($identity == "") {
        echo "You must select either Actor or Director!";
    } else if (str_replace(" ", "", $first) == "") {
        echo "You must enter a first name!";
    } else if (str_replace(" ", "", $last) == "") {
        echo "You must enter a last name!";
    } else if ($sex == "") {
        echo "You must select either Male or Female!";
    } else if ($dob == "") {
        echo "You must specify date of birth!";
    } else {
        $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);
        if (!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br />";
            exit(1);
        }

        // Check if Date of Death is set
        $isDodSet = false;
        if ($dod != "") {
            $isDodSet = true;
        }

        // Get the maximum person ID
        $maximumPersonIDQuery = "SELECT id FROM MaxPersonID";
        $maximumPersonIDGet = mysql_query($maximumPersonIDQuery, $db_connection);
        $maximumPersonIDFetch = mysql_fetch_row($maximumPersonIDGet);
        $maximumPersonID = $maximumPersonIDFetch[0];

        // Escapes special characters in a string for use in an SQL statement
        $first = mysql_real_escape_string($first);
        $last = mysql_real_escape_string($last);

        // Adding an actor to Actor table
        if ($identity == "actor") {
            if ($isDodSet) {
                $actorAddQuery = "INSERT INTO Actor VALUES($maximumPersonID, '$last', '$first', '$sex', '$dob', '$dod')";
            } else {
                $actorAddQuery = "INSERT INTO Actor VALUES($maximumPersonID, '$last', '$first', '$sex', '$dob', null)";
            }
            if (mysql_query($actorAddQuery, $db_connection)) {
                echo "Added $first $last to the database!";
                mysql_query("UPDATE MaxPersonID SET id=id+1", $db_connection);
            } else {
                echo "Failed to add $first $last to the database.";
            }
        } 
        // Adding a director to Director table
        else {
            if ($isDodSet) {
                $directorAddQuery = "INSERT INTO Director VALUES($maximumPersonID, '$last', '$first', '$sex', '$dob', '$dod')";
            } else {
                $directorAddQuery = "INSERT INTO Director VALUES($maximumPersonID, '$last', '$first', '$sex', '$dob', null)";
            }
            if (mysql_query($directorAddQuery, $db_connection)) {
                echo "Added $first $last to the database!";
                mysql_query("UPDATE MaxPersonID SET id=id+1", $db_connection);
            } else {
                echo "Failed to add $first $last to the database.";
            }
        }

        mysql_close($db);
    }
}
?>
</body>
</html>