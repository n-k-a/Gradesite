<?php
session_start();
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

if($_SERVER['REQUEST_METHOD'] == 'POST') // if form is submitted...
  {
$reviewerID = mysqli_real_escape_string($conn,$_POST['passUserID']);
$moduleGroup=mysqli_real_escape_string($conn,$_POST['passGroup']);
$memberID = mysqli_real_escape_string($conn,$_POST['rmemberID']);
$rating = mysqli_real_escape_string($conn,$_POST['rating']);
$comment = mysqli_real_escape_string($conn,$_POST['comment']);

//Validate first if content is there
if(empty($comment) || empty($memberID))
{
echo " Please enter your comment";
exit();
} 
//looks for if there's a record that already exists for this member and the reviewer
	$sql = "SELECT * FROM `PeerGrades` WHERE `StudentID`= $memberID AND `MemberReviewerID` = $reviewerID";
$result = mysqli_query($conn,$sql);
$chkcount = mysqli_num_rows($result);
$reviewchk = mysqli_fetch_assoc($result);
//checks if the review was a final submission
$subchk  = $reviewchk['Submitted'];

//for selecting the save function
if(isset($_POST['suspend']))
{
	
//if there's no preexisting review, create a new one with the submitted data
if ($chkcount == 0)
 {
	$sqli ="INSERT INTO `PeerGrades` (StudentID, moduleGroup, MemberReviewerID, rating, MemberTXT, Submitted) 
	VALUES('$memberID','$moduleGroup','$reviewerID','$rating','$comment', 0)";
		
		if(mysqli_query($conn, $sqli))
	{
		
    echo "Saved data";
	if ( !($_FILES['userFile']['type']) ) {
   echo "no image used";
	}
	else{
		imgsv();
		$sqlimg ="UPDATE PeerGrades SET `name` = '$imgname' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
		mysqli_query($conn, $sqlimg);
	}
}
else{
	echo "failed to save review through creation";
}
 }
 

 //if there is an existing review with an existing submitted bool check
	else if($chkcount == 1)
{
	//if it hasn't been submitted, it updates the review text and rating
	if ($subchk == 0){
	$sqli ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID "; 


		if(mysqli_query($conn, $sqli))
	{
    echo "Records inserted successfully for update.";
		if ( !($_FILES['userFile']['type']) ) {
   echo "no image used";
	}
	else{
		imgsv();
		$sqlimg ="UPDATE PeerGrades SET `name` = '$imgname' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
		mysqli_query($conn, $sqlimg);
	}
}
else{
	echo "failed to save review through update";
}
	}
	else{
		echo "this review has already been submitted";
	}
	
}
else{
	echo "this review has already been submitted";
}
}


//finalised review submission
else if (isset($_POST['submit']))
{
	//if there was no review prior to this submission, send this new one as finalised
	if ($chkcount == 0)
 {
	 //main difference is that the submitted column has an entry of 1
	$sqli ="INSERT INTO `PeerGrades` (StudentID, moduleGroup, MemberReviewerID, rating, MemberTXT, Submitted) 
	VALUES('$memberID','$moduleGroup','$reviewerID','$rating','$comment', 1)";
		if(mysqli_query($conn, $sqli))
	{
		
    echo "Records inserted successfully for creation. Review has been submitted";
			if ( !($_FILES['userFile']['type']) ) {
   echo "no image used for this attempt.";
	}
	else{
		imgsv();
		$sqlimg ="UPDATE PeerGrades SET `name` = '$imgname' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
		mysqli_query($conn, $sqlimg);
		echo "image changed";
		
	}
}
else{
	echo "failed to save review through creation, review has not been submitted";
}	
}

	//if it hasn't been submitted but was saved, it updates the review text and rating before being submitted
	if ($subchk == 0){
	$sqli ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment', `Submitted` = 1 WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 

		if(mysqli_query($conn, $sqli))
	{
    echo "Review updated and submitted";
			if ( !($_FILES['userFile']['type']) ) {
   echo "no change to image";
	}
	else{
		imgsv();
		$imgname = $_FILES['userFile']['name'];
		$sqlimg ="UPDATE PeerGrades SET `name` = '$imgname' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
		mysqli_query($conn, $sqlimg);
		   echo "Image updated.";
		  

	}
}
else{
	echo "failed to send review";
}
	}
	else{
		echo "this review has already been submitted";
	}
	

}
	// header( "refresh:3;url=".$_SERVER['HTTP_REFERER'] );

}
function imgsv(){
	 include ("db_connection_page.php");

if ( !($_FILES['userFile']['type']) ) {
   echo'No image submitted';
   exit();
}
// Validate uploaded image file
if ( !preg_match( '/gif|png|x-png|jpeg/', $_FILES['userFile']['type']) ) 
{
die('Only browser compatible images allowed');
}

else if ( $_FILES['userFile']['size'] > 16384 ) 
{
die('Sorry file too large');
// Connect to database
}
else if ( !($conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db)) ) {
die('Error connecting to database');
// Copy image file into a variable
}
else if ( !($handle = fopen ($_FILES['userFile']['tmp_name'], "r")) ) 
{
die('Error opening temp file');
} 
else if ( !($image = fread ($handle, filesize($_FILES['userFile']['tmp_name']))) ) 
{
die('Error reading temp file');
} 
else 
{
fclose ($handle);

// Commit image to the database
$image = mysqli_real_escape_string($conn, $image);
   $query = 'INSERT INTO image (type,name,img) VALUES ("' . $_FILES['userFile']['type'] . '","' . $_FILES['userFile']['name']  . '","' . $image . '")';
   if ( !(mysqli_query($conn, $query)) ) {
die('Error writing image to database');
}
else {
echo 'Image successfully copied to database! ';
}
}
}
?>