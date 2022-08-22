<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['login_user'])
{
			header( "refresh:3;url=Login_form.html" );
}
// if (!isset($_COOKIE[$cookie_StudentID]))
	// {
			// header( "refresh:url=Login_form.html" );
// }
?>