<html>
<body>
<p> Insert your query in the box below </p>
<br>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
   <textarea name="query" rows="10" cols="50"><?php echo $_GET["query"];?></textarea>
   <br>
   <input type="submit"/>
</form>
<?php

if ($_GET["query"]) {
     $db_connection = mysql_connect("localhost", "cs143", "");

     mysql_select_db("CS143", $db_connection); 
     if(!$db_connection) {
    	$errmsg = mysql_error($db_connection);
    	print "Connection failed: $errmsg <br />";
   		exit(1);
	   }
       //$sanitized_query = mysql_real_escape_string($_GET["query"], $db_connection);
       //echo $sanitized_query;
     if ($rs = mysql_query($_GET["query"], $db_connection)) 
     {
         
         $cols = mysql_num_fields($rs);
         echo "<h2> Results from MySQL:</h2>";
         echo "<table border=\"1\"><tr>";
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
