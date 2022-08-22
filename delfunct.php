<?php
session_start();

include('db_connection_page.php');

if(isset($_POST['del'])){
		  $rmemberID = mysqli_real_escape_string($conn,$_POST['rmemberID']);
		  	  $rreviewerID = mysqli_real_escape_string($conn,$_POST['passUserID']);
		  echo $rmemberID;
		  echo $rreviewerID;
$sqll ="DELETE FROM `PeerGrades` WHERE `StudentID`= '$rmemberID' AND `MemberReviewerID` = '$rreviewerID' AND `Submitted` = 0";
if ( mysqli_query($conn, $sqll)) {
echo '<script language="javascript">';
echo 'alert("Deleted review.")';
echo '</script>';
}
else{
	echo '<script language="javascript">';
echo 'alert("No review for user exists")';
echo '</script>';
}
}


?>