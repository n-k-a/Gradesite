<?php 
//http://allwebco-templates.com/support/script-simple-captcha.htm

 $dbhost = "mysql.cms.gre.ac.uk";
 $dbuser = "na8363c";
 $dbpass = "na8363c";
 $db = "mdb_na8363c";
// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

 $link = mysqli_connect($dbhost, $dbuser, $dbpass, $db) or 
       die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
	  
if (isset($_POST['submit'])) // try doing opposite
{
	// $userID = mysqli_real_escape_string($conn,$_POST['userID']);
	// $userPasswd= mysqli_real_escape_string($conn,$_POST['userPasswd']);
	// $email= mysqli_real_escape_string($conn,$_POST['email']);
	// $groupNo= mysqli_real_escape_string($conn,$_POST['groupNo']);
	
// echo $userID;
// echo $userPasswd;
// echo $email;
// $echo $groupNo;
	 $userID = $_POST['userID'];
 $userPasswd = $_POST['userPasswd'];
 $email = $_POST['email'];
 $groupNo = $_POST['groupNo'];
 
 
//This page should not be accessed directly. Need to submit the form.
	 if (empty($userID)||empty($email)||empty($userPasswd))
 {
 echo " ID, password and email are required for the form! Please fill them out.";
 exit();
}

if(IsInjected($email))
{
echo "Bad email value!";
}
if (!strpos($email, '@gre.ac.uk')){
    echo 'Wrong email domain. Only "gre.ac.uk" emails are allowed';
exit();
}

$userID = mysqli_real_escape_string($conn,$_POST['userID']);
	//$userPasswd= mysqli_real_escape_string($conn,$_POST['userPasswd']);
	$userPasswd= trim($_POST['userPasswd']);
	$userPasswd = password_hash($userPasswd, PASSWORD_BCRYPT);
	$email= mysqli_real_escape_string($conn,$_POST['email']);
	$groupNo= mysqli_real_escape_string($conn,$_POST['groupNo']);

$sql = "SELECT *  FROM `User` WHERE `moduleGroup` = $groupNo";
$sqli = "SELECT *  FROM `User` WHERE `StudentID` = $userID";
$groupCount=mysqli_query($link, $sql);
$result =mysqli_num_rows($groupCount);
if ($result < 3){
	 $search = "SELECT * FROM `User` WHERE `StudentID` = $userID AND `Email` LIKE '$email'";
	$searchrs = mysqli_fetch_row(mysqli_query($link,$search));
	if (!$searchrs){
$sql = "INSERT INTO User (StudentID, Email, Password, moduleGroup) VALUES('$userID','$email','$userPasswd','$groupNo')"; 
 if (mysqli_query($conn, $sql) === TRUE) {
	  if (mysqli_errno() == 1062) {
		echo "<p>There is already an account with these details. Please enter a different Student ID and Email Address.</p>";
		//header( "refresh:3;url=Register_form.php" );
		header('refresh:3;urlLocation: ' . $_SERVER['HTTP_REFERER']);

	}
	else{
     echo "\n A new account created successfully. Please log in. \n";
	}
 }
 else {
     echo "Error: " .  mysqli_error($conn);
 }
	}
	
}
else{
	echo "\n This group has the maximum amount of members possible. Please join a different one when registering.\n";
		header('refresh:3;urlLocation: ' . $_SERVER['HTTP_REFERER']);
 }

 mysqli_close($conn);
header( "refresh:3;url=Login_form.php" );

}

//lc8884l@greenwich.ac.uk

//prevent email injection

function IsInjected($str)
{
$injections = array('(\n+)',
'(\r+)',
'(\t+)',
'(%0A+)',
'(%0D+)',
'(%08+)',
'(%09+)'
);
$inject = join('|', $injections);
$inject = "/$inject/i";
if(preg_match($inject,$str))
{
return true;
}
else
{
return false;
}
}
?>

