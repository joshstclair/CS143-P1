<html>
<body>

<h2> Search Results </h2>

<?php
if ($_GET["search"]) {
    $db_connection = mysql_connect("localhost", "cs143", "");

    mysql_select_db("CS143", $db_connection); 
    if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br />";
   		exit(1);
    }
    //$sanitized_query = mysql_real_escape_string($_GET["query"], $db_connection);
    //echo $sanitized_query;
    $search_words = explode(" ", $_GET["search"]);
    $count = count($search_words);
    $movie_search = "SELECT * FROM Movie WHERE title LIKE \"%" . $search_words[0] . "%\"";
    if ($count == 1)
        $actor_search = "SELECT * FROM Actor WHERE first LIKE \"%" . $search_words[0] . "%\" OR last LIKE \"%" . $search_words[0] . "%\"";
    else
        $actor_search = "SELECT * FROM Actor WHERE first LIKE \"%" . $search_words[0] . "%\" AND last LIKE \"%" . $search_words[1] . "%\"";
    $i = 1;
    while ($i < $count)
    {
        $movie_search .= "AND title LIKE \"%" . $search_words[$i] . "%\"";
        $actor_search .= "OR first LIKE \"%" . $search_words[$i] . "%\" AND last LIKE \"%" . $search_words[$i] . "%\"";
        $i++;
    }
    $movie_search .= ";";
    $actor_search .= ";";

    echo "<b>You searched " . $_GET["search"] . "...</b><br><br>";

    echo "<b>Movie results:</b><br>";
    if ($rs = mysql_query($movie_search, $db_connection)) 
    {
        $i = 0;

        while($movie = mysql_fetch_assoc($rs))
        {
            $movie_link = "<a href = \"displayInfo.php?type=movie&movie_id=" . 
            $movie['id'] . "\">" . $movie['title'] . " (" . $movie['year'] . ")</a>";
            echo  $movie_link . "<br>";
            $i++;
        }   
    }
    else
    {
        print "Error processing the movie search query <br>";
        exit();
    }

    echo "<b>Actor results:</b><br>";
    if ($rs = mysql_query($actor_search, $db_connection)) 
    {
        $i = 0;
        while($actor = mysql_fetch_assoc($rs))
        {
            $actor_link = "<a href = \"displayInfo.php?type=actor&actor_id=" . 
            $actor['id'] . "\">" . $actor['first'] . " " . $actor['last'] . " (" . $actor['dob'] . ")</a>";
            echo  $actor_link . "<br>";
            $i++;
        }   
    }
    else
    {
        print "Error processing the actor search query <br>";
        exit();
    }

    mysql_close($db_connection);
}


?>

</body>
</html>
