<?php
if (!isset($_POST['submit']))
{
//This page should not be accessed directly. Need to submit the form.
echo "error; You need to submit the form!";
}
$userID = $_POST['userID'];
$userPasswd = $_POST['userPasswd'];


//Validate first
if(empty($userID)||empty($userPasswd)
{
echo " First name, Last name and email are required for the form! Please fill them out.";
exit;
} 

if(IsInjected($email))
{
echo "Bad email value!";
exit;
}
// Function to validate against any email injection attempts
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