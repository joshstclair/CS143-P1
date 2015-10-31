<html>
<head>
<title>Add a new actor to a movie</title>
</head>
<body>
    <?php
    $movie = $actor = $role = "";
    $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);

        if (!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br>";
            exit(1);
        }
    $movieList = mysql_query('SELECT id, CONCAT(title, " (", year, ")") as title FROM Movie ORDER BY title');
    $actorList = mysql_query('SELECT id, CONCAT(first, " ", last, " (", dob, ")") as name FROM Actor ORDER BY first, last');
    ?>
    <h2>Add a New Actor to a Movie</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
        Movie: <select name="movie">
        <?php
            while ($mov = mysql_fetch_assoc($movieList)) {
                echo '<option value="' . $mov['id'] . '">' . $mov['title'] . '</option>';
            }
            mysql_free_result($movieList);
        ?>
        </select>
        <br><br>
        Actor: <select name="actor">
        <?php
            while ($act = mysql_fetch_assoc($actorList)) {
                echo '<option value="' . $act['id'] . '">' . $act['name'] . '</option>';
            }
            mysql_free_result($actorList);
        ?>
        </select>
        <br><br>
        Role: <input type="text" name="role" maxlength="50">
        <br><br>
        <input type="submit" name="submit" value="Add">
    </form>
    <?php
        if (isset($_GET['submit'])) {
            $movie = ($_GET["movie"]);
            $actor = ($_GET["actor"]);
            $role = ($_GET["role"]);


            // Escapes special characters in a string for use in an SQL statement
            $role = mysql_real_escape_string($role);
        
            if (mysql_query("INSERT INTO MovieActor VALUES($movie, $actor, '$role')", $db_connection)) {
                echo "Added the relation successfully!";
            } else {
                echo "Failed to add the relation.";
            }
            mysql_close();
        }
    ?>
</body>
</html>