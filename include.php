<?php
$debug = false;
$correctpassword = "pineapple";

$dbuser = "root";
$dbpass = "";
$dbserver = "localhost";
$dbname = "assetdb";
// Create connection
$connect = mysql_connect($dbserver, $dbuser, $dbpass);

// Check connection
if (!$connect) {
    die("Database connection failed: " . mysql_error());
}
mysql_select_db($dbname, $connect)
  or die("Could not select database");


session_start();
ob_start();


$stylesheet = "stylesheet.css";


if(isset($_SESSION['loggedin'])){
	if($_SESSION['loggedin'] == "true"){
		$ISLOGGEDIN = true;
	}else{
		$ISLOGGEDIN = false;
	}
}


echo "
<!DOCTYPE html>
<head>
<meta charset='utf-8'>
<link rel='stylesheet' href='".$stylesheet."'>
<title>Asset DB Management System</title>
</head>
<body> ";

?>