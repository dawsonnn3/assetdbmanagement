<?php
include "include.php";
if (!$ISLOGGEDIN){
	header("location: login.php");
}
if (!isset($_GET['editdevice'])){
	if (!isset($_GET['viewdevice'])){


	if (isset($_GET['order'])){
		$getorder = mysql_real_escape_string($_GET['order']) .  " desc";
	}else{
		$getorder = "ID";
	}
	if (isset($_GET['getdevice'])){
		$getsdevice = "WHERE computerID = ".$_GET['getdevice'];
	}else{
		$getsdevice = "";
	}
	$sql = mysql_query("SELECT * , COUNT( * ) TotalCount
	FROM software
	$getsdevice
	GROUP BY softwareName
	ORDER BY $getorder");
	echo "<table>
	<tr style='background-color:#95a5a6'>
	<td>ID</td>
	<td>Software</td>
	<td>Installed Amount</td>
	<td>Actions</td>
	</tr>";
	while ($device = mysql_fetch_object($sql)){
		echo "<tr>";
		echo "<td>". $device->ID . "</td>";
		echo "<td>". $device->softwareName . "</td>";
		echo "<td>". $device->TotalCount . "</td>";
		echo "<td><a href='viewsoftware.php?viewdevice=". urlencode($device->softwareName) ."'>[view devices]</a> <a href='viewsoftware.php?deletesoftware=".urlencode($device->softwareName)."'>[delete]</a></td>";
		echo "</tr>";
	}
	echo "</table>";


	echo "<br/>
	<a href='index.php'>[go back]</a>
	";
	}
}



if (isset($_GET['viewdevice'])){
	$getsName = mysql_real_escape_string($_GET['viewdevice']);
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
		$sql = mysql_query("SELECT computerID FROM software WHERE softwareName = '$getsName'");
		while ($device = mysql_fetch_object($sql)){
			$deviceid = $device->computerID;
			$getdeviceinfo = mysql_query("SELECT * FROM devices WHERE ID = $deviceid");
			$deviceInfo = mysql_fetch_object($getdeviceinfo);
				echo "<tr>";
				echo "<td>". $deviceInfo->ID . "</td>";
				echo "<td><a href='query.php?action=search&deviceName=".$deviceInfo->deviceName."'>". $deviceInfo->deviceName . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceType=".$deviceInfo->deviceType."'>". $deviceInfo->deviceType . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceOwner=".$deviceInfo->deviceOwner."'>". $deviceInfo->deviceOwner . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceOS=".$deviceInfo->deviceOS."'>". $deviceInfo->deviceOS . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceRAM=".$deviceInfo->deviceRAM."'>". $deviceInfo->deviceRAM . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceGPU=".$deviceInfo->deviceGPU."'>". $deviceInfo->deviceGPU . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceMobo=".$deviceInfo->deviceMobo."'>". $deviceInfo->deviceMobo . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceProcessor=".$deviceInfo->deviceProcessor."'>". $deviceInfo->deviceProcessor . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceHDDSpace=".$deviceInfo->deviceHDDSpace."'>". $deviceInfo->deviceHDDSpace . "</a></td>";
				echo "<td><a href='query.php?action=search&deviceSSDSpace=".$deviceInfo->deviceSSDSpace."'>". $deviceInfo->deviceSSDSpace . "</a></td>";
				echo "<td><a href='viewdevices.php?editdevice=". $deviceInfo->ID ."'>[edit]</a> <a href='viewdevices.php?deletedevice=".$deviceInfo->ID."'>[delete]</a></td>";
				echo "</tr>";					
		}
		echo"</table>";
		echo "<br/>
		<a href='viewsoftware.php'>[go back]</a>
		";
}

if (isset($_GET['deletesoftware'])){
$getsoftwarename = $_GET['deletesoftware'];

$sql = mysql_query("SELECT softwareName FROM software WHERE softwareName = '$getsoftwarename'");
if (!$sql){
die("error");
}
$geti = mysql_fetch_object($sql);

echo "<br/><br/>Are you sure you want to delete all records of <b>".$geti->softwareName."</b>?";
echo "<br/><br/><a href='viewsoftware.php?confdelete=".urlencode($getsoftwarename)."'>[yes]</a> <a href='viewdevices.php'>[no]</a>";




}
if (isset($_GET['confdelete'])){
$getsoftwarename = $_GET['confdelete'];
$sql = mysql_query("SELECT softwareName FROM software WHERE softwareName = '$getsoftwarename'");
if (!$sql){
die("error");
}
mysql_query("DELETE FROM software WHERE softwareName = '$getsoftwarename'");
header("location: viewsoftware.php");





}

?>