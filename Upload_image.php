<!-- COde basis from  https://stuweb.cms.gre.ac.uk/~ha07/web/PHP/imageUpload.htm-->
</html>
<title> save img</title>
<body>
<h1>Uploading Images to MySQL</h1><p>
<?php
if ( !($_FILES['userFile']['type']) ) {
   die('<p>No image submitted</p></body></html>');
}
?>
You submitted this file:<br /><br />
Temporary name: <?php echo $_FILES['userFile']['tmp_name'] ?><br />
Original name: <?php echo $_FILES['userFile']['name'] ?><br />
Size: <?php echo $_FILES['userFile']['size'] ?> bytes<br />
Type: <?php echo $_FILES['userFile']['type'] ?></p>

<?php
if ( !($_FILES['userFile']['type']) ) {
   die('<p>No image submitted</p></body></html>');
}
   session_start();
 include ("db_connection_page.php");
if (!isset($_POST['submit']))
{
//This page should not be accessed directly. Need to submit the form.
echo "error; You need to submit the form!";
}
// Validate uploaded image file
if ( !preg_match( '/gif|png|x-png|jpeg/', $_FILES['userFile']['type']) ) 
{
die('<p>Only browser compatible images allowed</p></body></html>');
}

else if ( $_FILES['userFile']['size'] > 16384 ) 
{
die('<p>Sorry file too large</p></body></html>');
// Connect to database
}
else if ( !($conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db)) ) {
die('<p>Error connecting to database</p></body></html>');
// Copy image file into a variable
}
else if ( !($handle = fopen ($_FILES['userFile']['tmp_name'], "r")) ) 
{
die('<p>Error opening temp file</p></body></html>');
} 
else if ( !($image = fread ($handle, filesize($_FILES['userFile']['tmp_name']))) ) 
{
die('<p>Error reading temp file</p></body></html>');
} 
else 
{
fclose ($handle);

// Commit image to the database
$image = mysqli_real_escape_string($conn, $image);
   //$query = 'INSERT INTO image (type,name,alt,img) VALUES ("' . $_FILES['userFile']['type'] . '","' . $_FILES['userFile']['name']  . '","' . $alt  . '","' . $image . '")';
   $query = 'INSERT INTO image (type,name,img) VALUES ("' . $_FILES['userFile']['type'] . '","' . $_FILES['userFile']['name']  . '","' . $image . '")';
   if ( !(mysqli_query($conn, $query)) ) {
die('<p>Error writing image to database</p></body></html>');
}
else {
die('<p>Image successfully copied to database</p></body></html>');
}
}

?>
</body>
</html>