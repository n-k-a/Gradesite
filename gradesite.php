<?php
if if(!isset($_POST['submit']))
{
//This page should not be accessed directly. Need to submit the form.
echo "error; You need to submit the form!";
}
$userID = $_POST['userID'];
$userPasswd = $_POST['userPasswd'];
$email = $_POST['email'];
$groupNo = $_POST['groupNo'];

//Validate first
/**if(empty($firstname)||empty($lastname)||empty($email)) 
{
echo " First name, Last name and email are required for the form! Please fill them out.";
exit;
} */

if(IsInjected($email))
{
echo "Bad email value!";
exit;
}

?>