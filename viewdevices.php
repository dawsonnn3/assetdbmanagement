<?php
include "include.php";
if (!$ISLOGGEDIN){
	header("location: login.php");
}
if (!isset($_GET['editdevice'])){

	$sql = mysql_query("SELECT * FROM devices");

	echo "<table>
	<tr style='background-color:#95a5a6'>
	<td	>ID</td>
	<td>Name</td>
	<td>Device Type</td>
	<td style='padding-right:10px'>Owner</td>
	<td>Operating System</td>
	<td>RAM </td>
	<td>GPU</td>
	<td>Motherboard</td>
	<td>Processor</td>
	<td>HDD Space (GB)</td>
	<td>SSD Space (GB)</td>
	<td>Actions</td>
	</tr>";
	while ($device = mysql_fetch_object($sql)){
		echo "<tr>";
		echo "<td>". $device->ID . "</td>";
		echo "<td><a href='query.php?action=search&deviceName=".$device->deviceName."'>". $device->deviceName . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceType=".$device->deviceType."'>". $device->deviceType . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceOwner=".$device->deviceOwner."'>". $device->deviceOwner . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceOS=".$device->deviceOS."'>". $device->deviceOS . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceRAM=".$device->deviceRAM."'>". $device->deviceRAM . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceGPU=".$device->deviceGPU."'>". $device->deviceGPU . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceMobo=".$device->deviceMobo."'>". $device->deviceMobo . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceProcessor=".$device->deviceProcessor."'>". $device->deviceProcessor . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceHDDSpace=".$device->deviceHDDSpace."'>". $device->deviceHDDSpace . "</a></td>";
		echo "<td><a href='query.php?action=search&deviceSSDSpace=".$device->deviceSSDSpace."'>". $device->deviceSSDSpace . "</a></td>";
		echo "<td><a href='viewdevices.php?editdevice=". $device->ID ."'>[edit]</a> <a href='viewsoftware.php?getdevice=".$device->ID."'>[view software]</a> <a href='viewdevices.php?deletedevice=".$device->ID."'>[delete]</a></td>";
		echo "</tr>";
	}
	echo "<td><td><td></td><td></td><td><td><td></td><td></td><td><td><td></td><td><a href='adddevice.php'>[add device]</a></td>";
	echo "</table>";


	echo "<br/>
	<a href='index.php'>[go back]</a>
	";

}


if (isset($_GET['editdevice'])){
	$deviceid = $_GET['editdevice'];


	if (is_numeric($deviceid)){
		$sql = mysql_query("SELECT * FROM devices WHERE ID = $deviceid");
		if (!$sql){
			die("error");
		}
		$getinfo = mysql_fetch_object($sql);


		if ($getinfo->deviceType == "Desktop  PC"){$desktopdefault = "selected";}else{$desktopdefault="";}
		if ($getinfo->deviceType == "Laptop"){$laptopdefault = "selected";}else{$laptopdefault="";}
		if ($getinfo->deviceType == "Tablet"){$tabletdefault = "selected";}else{$tabletdefault="";}
		if ($getinfo->deviceType == "Mobile"){$mobiledefault = "selected";}else{$mobiledefault="";}
		if ($getinfo->deviceType == "Other"){$otherdefault = "selected";}else{$otherdefault="";}
		echo "
		<form action='viewdevices.php?editdevice=submit' method='post'>
		<label>Device Name</label> <input type='text' value='".$getinfo->deviceName."' name='deviceName'><br/><br/>
		<label>Device Type</label> <select name='deviceType'>
		  <option value='Desktop PC' $desktopdefault>Desktop PC</option>
		  <option value='Laptop' $laptopdefault>Laptop</option>
		  <option value='Tablet' $tabletdefault>Tablet</option>
		  <option value='Mobile Phone' $mobiledefault>Mobile Phone</option>
		  <option value='Other' $otherdefault>Other</option>
		</select><Br/><br/>
		<label>Device Owner</label> <input type='text' value='".$getinfo->deviceOwner."' name='deviceOwner'><Br/><br/>
		<label>Operating System</label> <input type='text' value='".$getinfo->deviceOS."' name='deviceOS'><br/><br/>
		<label>RAM Amount</label> <input type='text' value='".$getinfo->deviceRAM."' name='deviceRAM'><br/><br/>
		<label>GPU</label> <input type='text' value='".$getinfo->deviceGPU."' name='deviceGPU'><br/><br/>
		<label>Motherboard</label> <input type='text' value='".$getinfo->deviceMobo."' name='deviceMobo'><br/><br/>
		<label>Processor</label> <input type='text' value='".$getinfo->deviceProcessor."' name='deviceProcessor'><br/><br/>
		<label>HDD Space</label> <input type='text' value='".$getinfo->deviceHDDSpace."' name='deviceHDDSpace'><br/><br/>
		<label>SSD Space</label> <input type='text' value='".$getinfo->deviceSSDSpace."' name='deviceSSDSpace'><br/><br/>
		<input type='hidden' value='".$getinfo->ID."' name='ID'>

		<input type='submit'>
		</form>

		<br/><br/>
		<a href='viewdevices.php'>[go back]</a>

		";
	}

	if ($_GET['editdevice'] == "submit"){
		$sDeviceName = $_POST['deviceName'];
		$sDeviceType = $_POST['deviceType'];
		$sDeviceOwner = $_POST['deviceOwner'];
		$sDeviceOS = $_POST['deviceOS'];
		$sDeviceRAM = $_POST['deviceRAM'];
		$sDeviceGPU = $_POST['deviceGPU'];
		$sDeviceMobo = $_POST['deviceMobo'];
		$sDeviceProcessor = $_POST['deviceProcessor'];
		$sDeviceHDDSpace = $_POST['deviceHDDSpace'];
		$sDeviceSSDSpace = $_POST['deviceSSDSpace'];
		$sDeviceID = $_POST['ID'];

		mysql_query("UPDATE devices SET
		 deviceName = '$sDeviceName',
		 deviceType = '$sDeviceType',
		 deviceOwner = '$sDeviceOwner',
		 deviceOS = '$sDeviceOS',
		 deviceRAM = '$sDeviceRAM',
		 deviceGPU = '$sDeviceGPU',
		 deviceMobo = '$sDeviceMobo',
		 deviceProcessor = '$sDeviceProcessor',
		 deviceHDDSpace = '$sDeviceHDDSpace',
		 deviceSSDSpace = '$sDeviceSSDSpace'
		 WHERE ID = $sDeviceID");
		 header ("location: viewdevices.php");
	}
}

if (isset($_GET['deletedevice'])){
	$getdeviceid = $_GET['deletedevice'];
	if (is_numeric($getdeviceid)){
		$sql = mysql_query("SELECT deviceName FROM devices WHERE ID = $getdeviceid");
		if (!$sql){
			die("error");
		}
		$geti = mysql_fetch_object($sql);

		echo "<br/><br/>Are you sure you want to delete <b>".$geti->deviceName."</b>?";
		echo "<br/><br/><a href='viewdevices.php?confdelete=".$getdeviceid."'>[yes]</a> <a href='viewdevices.php'>[no]</a>";


	}

}
if (isset($_GET['confdelete'])){
	$getdeviceid = $_GET['confdelete'];
	if (is_numeric($getdeviceid)){
		$sql = mysql_query("SELECT deviceName FROM devices WHERE ID = $getdeviceid");
		if (!$sql){
			die("error");
		}
		mysql_query("DELETE FROM devices WHERE ID=$getdeviceid");
		header("location: viewdevices.php");



	}

}
?>