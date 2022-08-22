<?php
session_start();
	 include ("db_connection_page.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') // if form is submitted...
  {
$reviewerID = mysqli_real_escape_string($conn,$_POST['passUserID']);
$moduleGroup=mysqli_real_escape_string($conn,$_POST['passGroup']);
$memberID = mysqli_real_escape_string($conn,$_POST['rmemberID']);
$rating = mysqli_real_escape_string($conn,$_POST['rating']);
$comment = mysqli_real_escape_string($conn,$_POST['comment']);
 $sqlr = "SELECT * FROM `PeerGrades` WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID AND Submitted = 1";
$result = mysqli_query($conn,$sqlr);
$chkcount = mysqli_num_rows($result);
$subchk  = $reviewchk['Submitted'];
//checks if the review was a final submission
if ($subchk == 1){
	die ("review already submitted, no editing.");
}

//Validate first if content is there
if(empty($comment) || empty($memberID))
{
echo " Please enter your comment";
exit();
} 
//looks for if there's a record that already exists for this member and the reviewer

 }
 




//for selecting the save function
if(isset($_POST['suspend']))
{
	$sqll = "SELECT * FROM `PeerGrades` WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID AND Submitted = 0";

	//$sql ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 

	
$rs = mysqli_query($conn,$sqll);
	
	if ((mysqli_num_rows($rs)==1) && ($subchk == 0)){
			$sql ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
 mysqli_query($conn,$sql);
     echo "updated review";

	}
//if there's no preexisting review, create a new one with the submitted data
else if ($subchk == 0){
	$sqli ="INSERT INTO `PeerGrades` (StudentID, moduleGroup, MemberReviewerID, rating, MemberTXT, Submitted) 
	VALUES('$memberID','$moduleGroup','$reviewerID','$rating','$comment', 0)";
		if(mysqli_query($conn, $sqli))
	{	
    echo "Saved new review";
}
else{
	die("failed");
}
}
 }



//finalised review submission
 if (isset($_POST['submit']))
{
	$sqll = "SELECT * FROM `PeerGrades` WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID AND `Submitted` = 0";

	//$sql ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment' WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
$final = mysqli_real_escape_string($conn,1);

	
$rs = mysqli_query($conn,$sqll);
	
	if ((mysqli_num_rows($rs)==1) &&($subchk == 0)){
			$sql ="UPDATE PeerGrades SET `rating`= '$rating', `MemberTXT` = '$comment', `Submitted` = '$final'  WHERE `MemberReviewerID` = '$reviewerID' AND `StudentID`= $memberID"; 
 mysqli_query($conn,$sqll);
     echo "updated new review";

	}
//if there's no preexisting review, create a new one with the submitted data
else if ($subchk == 0){
	
	$sqli ="INSERT INTO `PeerGrades` (StudentID, moduleGroup, MemberReviewerID, rating, MemberTXT, Submitted) 
	VALUES('$memberID','$moduleGroup','$reviewerID','$rating','$comment', '$final')";
		if(mysqli_query($conn, $sqli))
	{	
    echo "sent new review";
}
else{
	die("failed");
}
}

}

		imgsv();

	
	// header( "refresh:3;url=".$_SERVER['HTTP_REFERER'] );


function imgsv(){
	

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
	$contents = bin2hex(($image));
fclose ($handle);

// Commit image to the database
//             echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';

$image = mysqli_real_escape_string($conn, $image);
   $filetype =mysqli_real_escape_string($conn,$_FILES['userFile']['type']) ;
   $filename =mysqli_real_escape_string($conn,$_FILES['userFile']['name']) ;
   
     // $query = 'INSERT INTO image (type,name,img) VALUES ("' . $_FILES['userFile']['type'] . '","' . $_FILES['userFile']['name']  . '","' . $image . '")';

      $query = 'UPDATE `PeerGrades` SET `type` ="'. $_FILES['userFile']['type'] .'", `name` = "'. $_FILES['userFile']['name'] .'", `img` = "'. $contents .'" WHERE `MemberReviewerID` = "$reviewerID" AND `StudentID`= "$memberID" ';
   if (!(mysqli_query($conn, $query))) {
die('Error writing image to database');
}
else {
echo 'Image successfully copied to database! ';
}
}
}
?>