<?php 	 
	session_start();
	 $dbhost = "mysql.cms.gre.ac.uk";
 $dbuser = "na8363c";
 $dbpass = "na8363c";
 $db = "mdb_na8363c";
$conn= mysqli_connect($dbhost, $dbuser, $dbpass, $db) or 
      die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
   if($_SERVER["REQUEST_METHOD"] == "POST") {

$userID = $_POST['userID'];
$userPasswd = $_POST['userPasswd'];

//This page should not be accessed directly. Need to submit the form.
 if (empty($userID)|| empty($userPasswd))
 {
 echo " ID and password are required for the form! Please fill them out.";
 exit;
}
$userID = mysqli_real_escape_string($conn,$_POST['userID']);
$userPasswd = mysqli_real_escape_string($conn,$_POST['userPasswd']);

	//$userPasswd = password_hash($userPasswd, PASSWORD_BCRYPT);
$sql = "SELECT * FROM `User` WHERE `StudentID` = '$userID'";
$result = mysqli_query($conn,$sql);
$searchrs = mysqli_fetch_assoc($result);
$countchk = mysqli_num_rows($result);

 if ($countchk == 1){
	 if (password_verify($userPasswd, $searchrs['Password']))
{  
 echo "Account exists.";
 if (isset($_POST['rememberID'])) {
            /* Set cookie to last 1 day */
            setcookie('userID', $userID, time() + (86400), "/");
        
        }
	  $_SESSION['login_user']=$searchrs['StudentID'];
	  	  $passdownID = $searchrs['StudentID'];
	  $passdownGroup = $searchrs['moduleGroup'];
	  	  $_SESSION['groupnum']=$passdownGroup;

	  if ($_SESSION['login_user'] == "000000000"){
		  echo "Welcome tutor, You will be directed your management page in a moment";
		  	 header( "refresh:3;url=tutorview.php" );

			 exit();
	  }
	  else{
	   echo "Welcome, " . $passdownID . "of group " . $passdownGroup . ". You will be redirected to your tasks page in a moment";
	 header( "refresh:3;url=Upload_form.php" );

	  }
	 }
else
{
	echo "This account does not seem to exist. Please check if your StudentID or password is correct1 ";
	 	 header( "refresh:2;url=Login_form.php" );
}
	 	      

 }
 
	   else {
		        echo "This account does not seem to exist. Please check if your StudentID or password is correct2";
	 	 header( "refresh:2;url=Login_form.php" );
  }
	 //header("refresh:3;Location:Upload_form.php"  . "?userID=" . $passdownID . "&userGroup=" . $passdownGroup);

	   }


//https://johnmorrisonline.com/build-php-login-form-using-sessions/
//https://www.tutorialspoint.com/php/php_mysql_login.htm
//$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//https://stackoverflow.com/questions/17797211/how-to-encrypt-a-password-that-is-inserted-into-a-mysql-table
//https://zinoui.com/blog/storing-passwords-securely
?>
<html>
<head></head>
<body>
<form method="POST" action="">
 <input type="hidden" id="passUserID" name="passUserID" value="<?=$userID?>">
  <input type="hidden" id="passGroup" name="passGroup" value="<?=$passdownGroup?>">
</form>
</body>
</html>
