<?php

   session_start();
   //include("loadfunct.php");
   session_regenerate_id();
if($_SESSION['login_user'] == null)      // if there is no valid session
{
	echo '<script language="javascript"> alert("Need to log in first")</script>';
    header("Location: Login_form.php");
	
}
else if ($_SESSION['login_user'] == "000000000"){
		    header("Location: tutorview.php");

	}
	


include('db_connection_page.php');
// $userID = $_GET['uID'];
// $passgroup = $_GET['uGroup'];
// $userID = $_POST['passUserID'];
// $passgroup = $_POST['passGroup'];
//$groupnum = mysqli_real_escape_string($conn,$groupnum);
$userID = $_SESSION['login_user'];
$groupnum = mysqli_real_escape_string($conn,$_SESSION['groupnum']);
      include("delfunct.php");

$sql= "SELECT * FROM `User` WHERE `moduleGroup` = '$groupnum'";
$result = mysqli_query($conn,$sql);
$searchrs = mysqli_fetch_assoc($result);
$groupmemcnt = mysqli_num_rows($result);


if(isset($_POST['loadup'])){
	$lmemberID = $_POST['lmemberID'];
$sqll ="SELECT * FROM `PeerGrades` WHERE `StudentID`= $lmemberID AND `MemberReviewerID` = $userID AND `Submitted` = 0";
if (!empty(mysqli_query($conn, $sqll))) {
$resultl = mysqli_query($conn,$sqll);
$loadrs = mysqli_fetch_assoc($resultl);
$rate = $loadrs['rating'];
$lcomment = $loadrs['MemberTXT'];

	echo '<script language="javascript">';
echo 'alert("Loaded Review")';
echo '</script>';
}
else
{
		echo '<script language="javascript">';
echo 'alert("No review for user exists")';
echo '</script>';
}
}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peer Review</title>
   <link rel="stylesheet" type="text/css" href="Gradesite.css">
</head>
<body>
<div id="container"> 

<h1>Review page for user <?=$userID?></h1>
<hr></hr>
<nav>
User:<?=$userID?> 
</br>
Group:<?=$groupnum?>
</br>
Members:<?=$groupmemcnt?>/3
</br>
<form method="get" action="logout_action.php">
    <button type="submit">Logout</button>
</form>
<b>Other Group Members</b>
<ul>
<?php
$resulti = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($resulti)){
	$rowc=$row['StudentID'];
		if($rowc!=$userID){
	echo "<li>$rowc</li>";
		}
	}
	
?>
</ul>
</nav>
    <div id="content">
  <table class= "verify">
<tr>
<td>

<!--loading a record -->
<form method="post" action="">
 <input type="hidden" id="passUserID" name="passUserID" value="<?=$userID?>">
  <input type="hidden" id="passGroup" name="passGroup" value="<?=$groupnum?>">


<select name = "lmemberID">
<?php
	$sqli= "SELECT * FROM `User` WHERE `moduleGroup` = '$groupnum'";
$resulti = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($resulti)){
	$rowc=$row['StudentID'];
	if($rowc!=$userID){
	echo "<option>$rowc</option>";
	}
	}
?> 
<input type="submit" value="loadup" name="loadup"/>
</form>


<!--Deleting a record -->
<form method="post" action="delfunct.php">
 <input type="hidden" id="passUserID" name="passUserID" value="<?=$userID?>">
 <input type="hidden" id="passGroup" name="passGroup" value="<?=$groupnum?>">

<select name = "rmemberID">
<?php
	$sqli= "SELECT * FROM `User` WHERE `moduleGroup` = '$groupnum'";
$resulti = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($resulti)){
	$rowc=$row['StudentID'];
	if($rowc!=$userID){
	echo "<option>$rowc</option>";
	}
	}
?> 
<input type="submit" value="del" name="del"/>
</form>
</td>
</tr>
<tr> 
<td>
<!--Review submission section-->
<form action="Upload_save.php" method="POST"  enctype="multipart/form-data">
 <input type="hidden" id="passUserID" name="passUserID" value="<?=$userID?>">
 <input type="hidden" id="passGroup" name="passGroup" value="<?=$groupnum?>">
Member ID:
<select name = "rmemberID">
<?php
	$sqli= "SELECT * FROM `User` WHERE `moduleGroup` = '$groupnum'";
$resulti = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($resulti)){
	$rowc=$row['StudentID'];
	if($rowc!=$userID){
	echo "<option>$rowc</option>";
	}
	}
?> 
</select>

<!-- -->
Rating: <select name="rating">
<?php 

for($i=1; $i<=10; $i++)
{
if ($rate ==$i){
	    echo "<option selected ='selected' value=".$i.">".$i."</option>";
}
else{
    echo "<option value=".$i.">".$i."</option>";
}
}
?> 
</select> 
</td>
</tr>
<tr>
<td>

</td>
</tr>

<tr>
<td>
Review: <textarea name="comment" id="comment" value/><?=$lcomment?>
</textarea>
    Select image to upload:
    <input type="file" name="userFile" id="userFile">
</td>
</tr>
<tr>
<td>
<input type="submit" value="Save" name="suspend"/>
<input type="submit" value="Send" name="submit"/>
</form>

</td>
</tr>
</table>
</div>
<hr></hr>
<div id="footer">
</div>
</div>

</body>
</html>