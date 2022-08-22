<?php
   session_start();
   session_regenerate_id();
if($_SESSION['login_user'] == null)      // if the user entering is a normal student
{
    header("Location: Login_form.php");
}
//if the user is the tutor
else if($_SESSION['login_user'] != "000000000"){
	echo '<script language="javascript">';
echo 'alert("Not allowed here, not a tutor.")';
echo '</script>';
    header("Location: Upload_form.php");

}
include('db_connection_page.php');


?>
<html>
<head>
<title>Global Task view</title>
   <link rel="stylesheet" type="text/css" href="Gradesite.css">
</head>
<body>
<div id="container"> 

<h1>Look at users<?=$userID?></h1>
<hr></hr>
<nav>
User:Tutor
</br>
<form method="get" action="logout_action.php">
    <button type="submit">Logout</button>
</form>

</nav>
    <div id="content">
<form method = "post" action = "">
User Search<input type="text" size="10" maxlength="9" name="userID" value=""/>
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

group: <select name="groupNo">
<?php 

for($i=1; $i<=10; $i++)
{
if ($sgroup ==$i){
	    echo "<option selected ='selected' value=".$i.">".$i."</option>";
}
else{
    echo "<option value=".$i.">".$i."</option>";
}
}
?> 
</select>


Mean grade search<input type="text" size="10" maxlength="5" name="grade" value=""/>
    <button type="submit">Go!</button>
</form>

  <table>
<tr>
  <th>ID</th>
  <th>Group</th>
  <th>select user</th>
  <th>calculated score</th>
</tr>
<?php
if(isset($get['pageno'])){
	$pageno = $_get['pageno'];
	
}
else{
	$pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;
//developing 
        $total_pages_sql = "SELECT COUNT(*) FROM `User`";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM User LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($res_data)){
			$rowID = $row['StudentID'];
			$rowmG = $row['moduleGroup'];
						if($rowID !=$_SESSION['login_user']){
							//echos row to show user records

										echo "<tr><td>$rowID</td><td>$rowmG</td><td><input type='radio' name='$rowID' value='$rowID'/>Select</td> </tr>";
}
		
			
		}
		
?>
</table>
<!--Buttons for pagination page turning -->
<ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
<!-- Form to open a selected user's page-->
<form method = "post" action = "">
View Selected user's grades
    <button type="submit">View</button>

</form>

<!--Form to send request to make a mailing list for the selected group-->
<form method = "post" action = "">
Send Grades to group.
group: <select name="groupNo">
<?php 

for($i=1; $i<=10; $i++)
{
if ($sgroup ==$i){
	    echo "<option selected ='selected' value=".$i.">".$i."</option>";
}
else{
    echo "<option value=".$i.">".$i."</option>";
}
}
?> 
</select>
    <button type="submit">Send</button>

</form>
</div>
<hr></hr>
<div id="footer">
</div>
</div>

</body>
</html>
<!--http://webreference.com/programming/php/search/index-2.html-->