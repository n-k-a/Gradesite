<?php
   session_start();
	   if (isset($_SESSION['login_user'])){
session_destroy();
header("Location: Login_form.php");

   }
   else{
	   header( "refresh:3;url={$_SERVER['HTTP_REFERER']}" );
		exit;
	     }
?>