<?php
include "include.php";
if (!$ISLOGGEDIN){
header("location: login.php");
}
echo "
<form action='addsoftware.php?action=submit' method='post'>
<label>Device</label>  <select name='deviceID'>";
$sql = mysql_query("SELECT ID, deviceName, deviceOwner FROM devices ORDER BY deviceOwner ASC");

while ($device = mysql_fetch_object($sql)){
echo "<option value=".$device->ID.">".$device->deviceOwner."'s ".$device->deviceName."</option>";
}

echo "</select><br/><br/>
<label>Software</label> <input type='text' name='software'><Br/><br/>


<input type='submit'>
</form>

<br/><br/>
<a href='index.php'>[go back]</a>

";


if (isset($_GET['action'])){
	if($_GET['action'] == "submit"){
		$sDeviceID = $_POST['deviceID'];
		$sSoftware = $_POST['software'];
		$currentTime = time();

		mysql_query("INSERT INTO software (softwareName, computerID, dateAdded) VALUES ('$sSoftware', $sDeviceID, $currentTime)");
		header("location: index.php");
	}

}
?>