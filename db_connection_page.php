<?php

 $dbhost = "mysql.cms.gre.ac.uk";
 $dbuser = "na8363c";
 $dbpass = "na8363c";
 $db = "mdb_na8363c";
// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>