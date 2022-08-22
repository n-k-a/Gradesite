<?php
session_start();
session_regenerate_id();
if(isset($_SESSION['login_user']))      // if there is no valid session
{
    header("Location: Upload_form.php");
}

?>

<html>
<head>
<title>User Registration</title>
   <link rel="stylesheet" type="text/css" href="Gradesite.css">
</head>
<body>
<div id="container"> 
<h1>Registration page for the peer assessment service</h1>
<hr></hr>
<nav>
<ul>
<li><a href="Login_form.php">Click to login to your account.</a> </li>
</ul>
</nav>

	<div id="content">
 <form action="Register_action.php" method="POST"  onsubmit="return checkform(this);">
  <table class= "verify">
<tr> 
<td>
Student ID:<input type="text" size="9" maxlength="9" name="userID" value="" alt="Please enter your student ID"/>
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
Email: <input type="text" size="25" maxlength="25" name="email" value="example@gre.ac.uk"/>
</td>
</tr>
<tr>
<td>
 Group: <select name="groupNo">
<script type="text/javascript">
for(var i = 1;i<=10;i++){
document.write("<option>"+i+"</option>");
}
</script>
</select> 
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
<tr>
<td>
<input type="submit" value="Register" name= "submit" />
</form
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