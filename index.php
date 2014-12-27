<?php
include "include.php";
if (!$ISLOGGEDIN){
	header("location: login.php");
}


echo "<h1>Asset Management System</h1>";
echo "

<a href='viewdevices.php'>View Devices</a><br/>
<a href='adddevice.php'>Add Devices</a><br/>
<a href='addsoftware.php'>Add Software</a><br/>
<a href='viewsoftware.php'>View Software</a><br/>
<a href='query.php'>Query</a><br/>
<a href='logout.php'>Logout</a><br/>

";

?>