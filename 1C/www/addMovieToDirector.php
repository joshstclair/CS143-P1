<html>
<head>
<title>Add a new director to a movie</title>
</head>
<body>
    <?php
    $movie = $director = "";
    $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);

        if (!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br>";
            exit(1);
        }
    $movieList = mysql_query('SELECT id, CONCAT(title, " (", year, ")") as title FROM Movie ORDER BY title');
    $directorList = mysql_query('SELECT id, CONCAT(first, " ", last, " (", dob, ")") as name FROM Director ORDER BY first, last');
    ?>
    <h2>Add a New Director to a Movie</h2>
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
        Director: <select name="director">
        <?php
            while ($dir = mysql_fetch_assoc($directorList)) {
                echo '<option value="' . $dir['id'] . '">' . $dir['name'] . '</option>';
            }
            mysql_free_result($directorList);
        ?>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Add">
    </form>
    <?php
        if (isset($_GET['submit'])) {
            $movie = ($_GET["movie"]);
            $director = ($_GET["director"]);
        
            if (mysql_query("INSERT INTO MovieDirector VALUES($movie, $director)", $db_connection)) {
                echo "Added the relation successfully!";
            } else {
                echo "Failed to add the relation.";
            }
            mysql_close();
        }
    ?>
</body>
</html>