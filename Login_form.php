<?php
session_start();
session_regenerate_id();
if(isset($_SESSION['login_user']))      // if there is a valid session
{
    header("Location: Upload_form.php");
}
//checks if cookie is set, and will set it to the last entered ID set
if (isset($_COOKIE['userID'])){
		$storedID = $_COOKIE['userID'];

}
else{
	$storedID = "xxxxxxxxx";
}
?>
<html>
<head>
<?php echo "<title>User Login</title>"?>
   <link rel="stylesheet" type="text/css" href="Gradesite.css">
</head>
<body>
<div id="container"> 
<h1>Log-in page for the peer assessment service</h1>
<hr></hr>

<nav>
<ul>
<li><a href="Register_form.php">Click to register an account.</a></li>
</ul>
</nav>

	<div id="content">

 <form action="Login_action.php" method="POST" onsubmit="return checkform(this);">
 <table class= "verify">
 <tr>
 <td>
 <?php
 if (isset($_COOKIE['userID'])){
		$storedID = $_COOKIE['userID'];

}
else{
	$storedID = "xxxxxxxxx";
}
 ?>
 <label for="userID">Student ID: </label>
<input type="text" size="10" maxlength="9" name="userID" value="<?=$storedID?>"/>
</td>
</tr>
<tr>
<td>
<label for="userPasswd">Password: </label>
<input type="password" maxlength="8" name="userPasswd" id="userPasswd" value="" alt="Please enter a password of up to 8 characters"/>
</td>
</tr>


<tr>
<td>
<!-- START CAPTCHA -->
<br>
<div class="capbox">

<div id="CaptchaDiv"></div>

<div class="capbox-inner">
Type the above number:<br>

<input type="hidden" id="txtCaptcha">
<input type="text" name="CaptchaInput" id="CaptchaInput" size="15"><br>

</div>
</div>
<br><br>
<!-- END CAPTCHA -->
<script type="text/javascript">

// Captcha Script

function checkform(theform){
var why = "";

if(theform.CaptchaInput.value == ""){
why += "- Please Enter CAPTCHA Code.\n";
}
if(theform.CaptchaInput.value != ""){
if(ValidCaptcha(theform.CaptchaInput.value) == false){
why += "- The CAPTCHA Code Does Not Match.\n";
}
}
if(why != ""){
alert(why);
return false;
}
}

var a = Math.ceil(Math.random() * 9)+ '';
var b = Math.ceil(Math.random() * 9)+ '';
var c = Math.ceil(Math.random() * 9)+ '';
var d = Math.ceil(Math.random() * 9)+ '';
var e = Math.ceil(Math.random() * 9)+ '';

var code = a + b + c + d + e;
document.getElementById("txtCaptcha").value = code;
document.getElementById("CaptchaDiv").innerHTML = code;

// Validate input against the generated number
function ValidCaptcha(){
var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
var str2 = removeSpaces(document.getElementById('CaptchaInput').value);
if (str1 == str2){
return true;
}else{
return false;
}
}

// Remove the spaces from the entered and generated code
function removeSpaces(string){
return string.split(' ').join('');
}
</script>
</td>
</tr>
<td>
<tr>
<!--tickbox to set the cookie-->
<label for="rememberID">Remember ID?: </label>
<input type="checkbox" name="rememberID" value="1">
</td>
</tr>
<tr>
<td>
<input type="submit" value="Log-in" name="submit"/>
</td>
</tr>
</table>
</div>
<hr></hr>
<div id="footer">
</div>
</div>
</body>
</div>
</html>