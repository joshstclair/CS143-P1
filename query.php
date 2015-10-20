<html>
<body>
<p> Insert your query in the box below </p>
<br>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
   <textarea name="query" rows="10" cols="50"></textarea>
   <br>
   <input type="submit"/>
</form>
<?php

if ($_GET["query"]) {
    
     $db_connection = mysql_connect("localhost", "cs143", "");

     mysql_select_db("cs143", $db_connection); // change TEST to cs143 when done testing
     if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br />";
   		exit(1);
	   }
       $test = "SELECT * FROM Actor WHERE id=10"; 
     if ($rs = mysql_query($test, $db_connection)) // change $test to $_GET["query"]
     {
         									  // TODO: check for sanitization of characters
         $cols = mysqli_num_fields($rs);
         
         echo "<table><tr>";
         while ($finfo = mysqli_fetch_field($rs))
         {
            echo "test1";
            echo "<th>" . $finfo->name . "</th>";
         }
         echo "</tr>";
         while ($rows = mysqli_fetch_array($rs, MYSQLI_NUM))
         {
            echo "test2";
            $i = 0;
            echo "<tr>";
            while ($i < $cols)
            {
              echo "<td>" . $rows[i] . "</td>";
              $i++;
            }
            echo "</tr>";
         }
         echo "</table>";

     }
     else
     {
        print "Error processing the query <br>";
        exit();
     }
     mysql_close($db_connection);
}
?>
</body>
</html>
