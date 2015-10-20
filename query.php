<html>
<body>
<p> Insert your query in the box below </p>
<br>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
   <textarea name="query" rows="10" cols="50"><?php echo $prev_query;?></textarea>
   <br>
   <input type="submit"/>
</form>
<?php

if ($_GET["query"]) {
     $prev_query = $_GET["query"];
     $db_connection = mysql_connect("localhost", "cs143", "");

     mysql_select_db("TEST", $db_connection); // change TEST to CS143 when done testing
     if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br />";
   		exit(1);
	   }
     if ($rs = mysql_query($_GET["query"], $db_connection)) 
     {
         									  // TODO: check for sanitization of characters
         $cols = mysql_num_fields($rs);
         echo "<table><tr>";
         while ($finfo = mysql_fetch_field($rs))
         {
            echo "<th>" . $finfo->name . "</th>";
         }
         echo "</tr>";
         while ($rows = mysql_fetch_array($rs, MYSQL_NUM))
         {
            $i = 0;
            echo "<tr>";
            while ($i < $cols)
            {
              echo "<td>" . $rows[$i] . "</td>";
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
