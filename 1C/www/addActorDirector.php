<html>
<head>
<title>Add new actor / director</title>
</head>
<body>
    <?php
    $identity = $firstname = $lastname = $sex = $dob = $dod = "";
    ?>
    <h2>Add New Actor / Director</h2>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Identity:
   <input type="radio" name="identity" value="actor">Actor
   <input type="radio" name="identity" value="director">Director
   <br><br>
   First Name: <input type="text" name="firstname">
   <br><br>
   Last Name: <input type="text" name="lastname">
   <br><br>
   Sex:
   <input type="radio" name="sex" value="Male">Male
   <input type="radio" name="sex" value="Female">Female
   <br><br>
   Date of Birth:  <input type="text" name="dob"> (YYYY-MM-DD)
   <br><br>
   Date of Die:  <input type="text" name="dod"> (YYYY-MM-DD) (Leave blank if still alive)
   <br><br>
   <input type="submit" value="Add"> 
</form>
<?php
$identity = ($_GET["identity"]);
$firstname = ($_GET["firstname"]);
$lastname = ($_GET["lastname"]);
$sex = ($_GET["sex"]);
$dob = ($_GET["dob"]);
$dod = ($_GET["dod"]);
echo "<h2>Your Input:</h2>";
echo $identity;
echo "<br>";
echo $firstname;
echo "<br>";
echo $lastname;
echo "<br>";
echo $sex;
echo "<br>";
echo $dob;
echo "<br>";
echo $dod;
?>
</body>
</html>