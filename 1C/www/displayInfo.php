<html>
<body>

<?php
//TODO: Change TEST to CS143 when done

if ($_GET['type'] != "movie" && $_GET['type'] != "actor")
{
    $_GET["type"] = "movie";
    $_GET["movie_id"] = 100;
}

if ($_GET["type"] == "movie")
{
    $db_connection = mysql_connect("localhost", "cs143", "");

    mysql_select_db("TEST", $db_connection); 
    if(!$db_connection) {
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg <br />";
        exit(1);
    }
    //$sanitized_query = mysql_real_escape_string($_GET["query"], $db_connection);
    //echo $sanitized_query;

    $movie_info = "SELECT * FROM Movie WHERE id = " . $_GET["movie_id"] . ";";
    $movie_info_res;
    $movie_gen = "SELECT genre FROM MovieGenre WHERE mid = " . $_GET["movie_id"] . ";";
    $movie_gen_res;
    $movie_dir_id = "SELECT did FROM MovieDirector WHERE mid = " . $_GET["movie_id"] . ";";
    $movie_dir_id_res; // array of director id's
    $movie_act_id = "SELECT * FROM MovieActor WHERE mid = " . $_GET["movie_id"] . ";";
    $movie_act_id_res; // array of actor id's

    // get general movie information
    if ($result = mysql_query($movie_info, $db_connection)) {
        $movie_info_res = mysql_fetch_assoc($result);
    }
    else
    {
        print "Error processing the general movie info query <br>";
        exit();
    }
    // get movie genres
    $num_movie_gens = 0;
    if ($result = mysql_query($movie_gen, $db_connection)) {
        while ($row = mysql_result($result, $num_movie_gens))
        {
            $movie_gen_res[$num_movie_gens] = $row;
            $num_movie_gens++;
        }
    }
    else
    {
        print "Error processing the movie genre info query <br>";
        exit();
    }
    // get the ID's of all the directors of the movie
    $num_movie_dirs = 0;
    if ($result = mysql_query($movie_dir_id, $db_connection)) {
        while ($row = mysql_result($result, $num_movie_dirs))
        {
            $movie_dir_id_res[$num_movie_dirs] = $row;
            $num_movie_dirs++;
        }
    }
    else
    {
        print "Error processing the movie director id info query <br>";
        exit();
    }
    // get the director names
    $i = 0;
    $movie_dir_res; // array of directors 
    while ($i < $num_movie_dirs)
    {
         $movie_dir = "SELECT * FROM Director WHERE id = " . $movie_dir_id_res[$i] . ";";
         if ($result = mysql_query($movie_dir, $db_connection)) {
            $movie_dir_res[$i] = mysql_result($result, 0, 'first') . " " . mysql_result($result, 0, 'last');
            $i++;
         }
         else
         {
            print "Error processing the movie director info query <br>";
            exit();
         }
    }

    // get the ID's of all the actors of the movie
    $num_movie_actors = 0;
    $movie_act_role_res; // array of actors' roles in the movie
    if ($result = mysql_query($movie_act_id, $db_connection)) {
        while ($aid = mysql_result($result, $num_movie_actors, 'aid'))
        {
            $movie_act_id_res[$num_movie_actors] = $aid;
            $movie_act_role_res[$num_movie_actors] = mysql_result($result, $num_movie_actors, 'role');
            $num_movie_actors++;
        }
    }
    else
    {
        print "Error processing the movie actor id info query <br>";
        exit();
    }
    // get the actor names
    $k = 0;
    $movie_act_name_res; // array of actors' names
    
    while ($k < $num_movie_actors)
    {
         $movie_act = "SELECT * FROM Actor WHERE id = " . $movie_act_id_res[$k] . ";";
         if ($result = mysql_query($movie_act, $db_connection)) {
            $movie_act_name_res[$k] = mysql_result($result, 0, first) . " " . mysql_result($result, 0, last);
            $k++;
         }
         else
         {
            print "Error processing the movie actor info query <br>";
            exit();
         }
    }
    // generate webpage with movie data
    echo "<h2> ......MOVIE...... </h2>";
    echo "<b> Title: </b>" . $movie_info_res['title'] . " (" . $movie_info_res['year'] . ")<br>";
    echo "<b> Director: </b>";
    $j = 0;
    while ($j < $num_movie_dirs)
    {
        if ($num_movie_dirs == 1)
            echo $movie_dir_res[$j];
        else
            echo $movie_dir_res[$j] . ", ";
        $j++;
    }
    echo "<br><b> Producer: </b>" . $movie_info_res['company'] . "<br>";
    echo "<b> Genre: </b>";
    $j = 0;
    while ($j < $num_movie_gens)
    {
        if ($num_movie_gens == 1)
            echo $movie_gen_res[$j];
        else
            echo $movie_gen_res[$j] . ", ";
        $j++;
    }
    echo "<br><b> Rating: </b>" . $movie_info_res['rating'] . "<br>";
    echo "<br> ......CAST......<br>";
    $j = 0;
    while ($j < $num_movie_actors)
    {
        $actor_link = "<a href = \"displayInfo.php?type=actor&actor_id=" . $movie_act_id_res[$j] . "\">" . $movie_act_name_res[$j] . "</a>";
        echo  $actor_link . " ....... " . $movie_act_role_res[$j] . "<br>";
        $j++;
    }

    // User Reviews
    $movie_review = "SELECT * FROM Review WHERE mid = " . $_GET["movie_id"] . ";";
    $movie_review_res; // array of reviews
    $movie_rev_ratings = "SELECT AVG(rating) as avg, COUNT(*) as total FROM Review WHERE mid = " . $_GET["movie_id"] . ";";
    $movie_rev_ratings_res;

    echo "<br> ....... Reviews ....... <br>";

    // get average rating
    if ($result = mysql_query($movie_rev_ratings, $db_connection)) {
        
        if (mysql_result($result, 0, 'avg') == false)
        {
            echo "No reviews for this movie<br>Be the first to ";
            echo "<a href = \"addComment.php\"> Add a Review </a>";
        }
        else
        {
            echo "Average rating: " . mysql_result($result, 0, 'avg') . "/5 (" . mysql_result($result, 0, 'total') . " reviews)<br>";
            echo "<a href = \"addComment.php\"> Add a review </a><br><br>";
        }
    }
    else
    {
        print "Error processing the movie review ratings <br>";
        exit();
    }

    if ($result = mysql_query($movie_review, $db_connection)) {
        while ($review = mysql_fetch_assoc($result))
        {
            if ($review['name'] == "")
                echo "<b> Anonymous </b><br>";
            else  
                echo "<b>" . $review['name'] . "</b><br>";
            echo $review['time'] . "<br>";
            echo "Rating: " . $review['rating'] . "<br>";
            echo $review['comment'] . "<br>";
            echo "<br>";
        }
    }
    else
    {
        print "Error processing the movie reviews query <br>";
        exit();
    }
    


    mysql_close($db_connection);
}

else 
{
    $db_connection = mysql_connect("localhost", "cs143", "");

    mysql_select_db("TEST", $db_connection); 
    if(!$db_connection) {
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg <br />";
        exit(1);
    }
    //$sanitized_query = mysql_real_escape_string($_GET["query"], $db_connection);
    //echo $sanitized_query;

    $actor_info = "SELECT * FROM Actor WHERE id = " . $_GET["actor_id"] . ";";
    $actor_info_res;
    $actor_movie_id = "SELECT * FROM MovieActor WHERE aid = " . $_GET["actor_id"] . ";";
    $actor_movie_id_res; // array of actor id's

    // get general actor information
    if ($result = mysql_query($actor_info, $db_connection)) {
        $actor_info_res = mysql_fetch_assoc($result);
    }
    else
    {
        print "Error processing the general actor info query <br>";
        exit();
    }

    // get the ID's of all the movies the actor has been in
    $num_actor_movies = 0;
    $actor_role_res; // array of actors' roles in the movie
    if ($result = mysql_query($actor_movie_id, $db_connection)) {
        while ($mid = mysql_result($result, $num_actor_movies, 'mid'))
        {
            $actor_movie_id_res[$num_actor_movies] = $mid;
            $actor_role_res[$num_actor_movies] = mysql_result($result, $num_actor_movies, 'role');
            $num_actor_movies++;
        }
    }
    else
    {
        print "Error processing the actor movie id info query <br>";
        exit();
    }
    // get the movie names and years of release
    $k = 0;
    $actor_movie_title_res; // array of movies' names
    $actor_movie_year_res; // array of movies' years of release
    while ($k < $num_actor_movies)
    {
        $actor_movie_title = "SELECT * FROM Movie WHERE id = " . $actor_movie_id_res[$k] . ";";
        if ($result = mysql_query($actor_movie_title, $db_connection)) {
            $actor_movie_title_res[$k] = mysql_result($result, 0, 'title');
            $actor_movie_year_res[$k] = mysql_result($result, 0, 'year');
            $k++;
        }
        else
        {
            print "Error processing the actor movie title query <br>";
            exit();
        }
    }
    // generate webpage with actor data
    echo "<h2> ......ACTOR...... </h2>";
    echo "<b> Name: </b>" . $actor_info_res['first'] . " " . $actor_info_res['last'] . "<br>";
    echo "<b> Sex: </b>" . $actor_info_res['sex'] . "<br>";
    echo "<b> Born: </b>" . $actor_info_res['dob'] . "<br><br>";
    if ($actor_info_res['dod'] != "")
        echo "<b> Died: </b>" . $actor_info_res['dod'] . "<br><br>";

    echo "<b> Movies Appeared in... </b><br>";
    $j = 0;
    while ($j < $num_actor_movies)
    {
        $movie_link = "<a href = \"displayInfo.php?type=movie&movie_id=" . 
            $actor_movie_id_res[$j] . "\">" . $actor_movie_title_res[$j] . " (" . $actor_movie_year_res[$j] . ")</a>";
        echo  $movie_link . "<br>";
        $j++;
    }

    mysql_close($db_connection);

}


?>

</body>
</html>
