<html>
<head>
<title>Add a comment to a movie</title>
</head>
<body>
    <?php
    $movie = $name = $rating = $comment = "";
    $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);

        if (!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br>";
            exit(1);
        }
    $movieList = mysql_query('SELECT id, CONCAT(title, " (", year, ")") as title FROM Movie ORDER BY title');
    ?>
    <h2>Add a comment to a Movie</h2>
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
        Your name: <input type="text" name="name" maxlength="20">
        <br><br>
        Rating: <select name="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        <br><br>
        Comment: <textarea name="comment" rows="10" cols="50" maxlength = "50"></textarea>
        <br><br>
        <input type="submit" name="submit" value="Add">
    </form>
    <?php
        if (isset($_GET['submit'])) {
            $movie = ($_GET["movie"]);
            $name = ($_GET["name"]);
            $rating = ($_GET["rating"]);
            $comment = ($_GET["comment"]);
            $time = time();
            $time = date('Y-m-d H:i:s', $time);

            // Escapes special characters in a string for use in an SQL statement
            $name = mysql_real_escape_string($name);
            $comment = mysql_real_escape_string($comment);
        
            if (mysql_query("INSERT INTO Review VALUES('$name', '$time', $movie, $rating, '$comment')", $db_connection)) {
                echo "Added the comment successfully!";
            } else {
                echo "Failed to add the relation.";
            }
            mysql_close();
        }
    ?>
</body>
</html>