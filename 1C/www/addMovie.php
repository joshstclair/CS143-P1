<html>
<head>
<title>Add a new movie</title>
</head>
<body>
    <?php
    $title = $company = $year = $rating = "";
    ?>
    <h2>Add a Movie</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Title: <input type="text" name="title">
    <br><br>
    Company: <input type="text" name="company">
    <br><br>
    Year: <input type="text" name="year">
    <br><br>
    Rating: <select name="rating">
    <?php
      $mpaarating = array( 'G', 'PG', 'PG-13', 'R', 'NC-17', 'X' );
      foreach ( $mpaarating as $eachrating ) {
          echo '<option value="' . $eachrating . '">' . $eachrating . '</option>';
      }
    ?>
  </select>
   <br><br>
   Genres (Please check all that apply):
   <?php
   $genres = array("Action", "Adult", "Adventure", "Animation", "Comedy", "Crime",
    "Documentary", "Drama", "Family", "Fantasy", "Horror", "Musical", "Mystery",
    "Romance", "Sci-Fi", "Short", "Thriller", "War", "Western");
   foreach ($genres as $genre) {
      echo '<input type="checkbox" name="genre[]" value="' . $genre . '"/>' . $genre;
   }
   ?>
   <br><br>
   <input type="submit" name="submit" value="Add"> 
</form>
<?php
if (isset($_GET['submit'])) {
    $title = ($_GET["title"]);
    $company = ($_GET["company"]);
    $year = ($_GET["year"]);
    $rating = ($_GET["rating"]);
    $genres = array();

    //bad input check
    if (str_replace(" ", "", $title) == "") {
      echo "You must enter a title!";;
    } else if (str_replace(" ", "", $company) == "") {
      echo "You must enter a company!";
    } else if (str_replace(" ", "", $year) == "") {
      echo "You must enter a year!";
    } else {
        $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);

        if (!$db_connection) {
            $errmsg = mysql_error($db_connection);
            print "Connection failed: $errmsg <br />";
            exit(1);
        }

        // Get all the genres
        for ($i = 0; $i < 19; $i++) {
          if (isset($_GET["genre"][$i])) {
            array_push($genres, $_GET["genre"][$i]);
          }
        }

        // Get the maximum person ID
        $maximumMovieIDQuery = "SELECT id FROM MaxMovieID";
        $maximumMovieIDGet = mysql_query($maximumMovieIDQuery, $db_connection);
        $maximumMovieIDFetch = mysql_fetch_row($maximumMovieIDGet);
        $maximumMovieID = $maximumMovieIDFetch[0];

        // Escapes special characters in a string for use in an SQL statement
        $title = mysql_real_escape_string($title);
        $company = mysql_real_escape_string($company);

        // Queries for the database
        $movieAddQuery = "INSERT INTO Movie VALUES ($maximumMovieID, '$title', $year, '$rating', '$company')";
        $updateMaxMovieIDQuery = "UPDATE MaxMovieID SET id=id+1";

        // If successfully added the movie to the database
        if (mysql_query($movieAddQuery, $db_connection)) {
          echo "Added $title to the database!";
          // Adding genres into MovieGenre table
          foreach ($genres as $genre) {
            mysql_query("INSERT INTO MovieGenre VALUES ($maximumMovieID, '$genre')", $db_connection);
          }
          mysql_query($updateMaxMovieIDQuery, $db_connection);
        } else {
           echo "Failed to add $title to the database.";
        }

        mysql_close();
    }
}
?>
</body>
</html>