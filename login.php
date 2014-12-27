<?php
include "include.php";
echo "<h2>Login</h2>



Enter password: 

<form action='login.php?action=auth' method='post'>
<input type='password' name='password'>
<input type='submit'>
</form>";



if (isset($_GET['action'])){
	if ($_GET['action'] == "auth"){

		$submittedpassword = $_POST['password'];

		if ($submittedpassword == $correctpassword){
			$_SESSION["loggedin"] = "true";

		if($_SESSION['loggedin'] == "true"){
			header("location: index.php");
		}

		}else{

			die("Error. Wrong password");
		}
	}
}
?>