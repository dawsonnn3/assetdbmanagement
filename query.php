<?php
include "include.php";
if (!$ISLOGGEDIN){
	header("location: login.php");
}
if (!isset($_GET['action'])){
	echo "
	<form action='query.php?action=search' method='post'>
	<table>
	<tr style='background-color:#95a5a6'>
	<td>Name</td>
	<td>Device Type</td>
	<td style='padding-right:10px'>Owner</td>
	<td>Operating System</td>
	<td>RAM </td>
	<td>Software </td>
	</tr>
	<tr>
	<td> <input type='text' name='deviceName'></td>
	<td> <select name='deviceType'>
	  <option value='' selected></option>
	  <option value='Desktop PC'>Desktop PC</option>
	  <option value='Laptop'>Laptop</option>
	  <option value='Tablet'>Tablet</option>
	  <option value='Mobile Phone'>Mobile Phone</option>
	  <option value='Other' $>Other</option>
	</select></td>
	<td><input type='text' name='deviceOwner'></td>
	<td><input type='text' name='deviceOS'></td>
	<td><input type='text' name='deviceRAM'></td>
	<td> <select name='softwareID'>   <option value='' selected></option>
	";

	$sql = mysql_query("SELECT ID, softwareName FROM software GROUP BY softwareName");

	while ($software = mysql_fetch_object($sql)){
		echo "<option value=".urlencode($software->softwareName).">".$software->softwareName."</option>";
	}

	echo "</select></td>

	<tr style='background-color:#95a5a6'>
	<td>GPU</td>
	<td>Motherboard</td>
	<td>Processor</td>
	<td>HDD Space (GB)</td>
	<td>SSD Space (GB)</td>
	<td>Actions</td>

	</tr>
	<tr>
	<td><input type='text' name='deviceGPU'></td>
	<td><input type='text' name='deviceMobo'></td>
	<td><input type='text' name='deviceProcessor'></td>
	<td><input type='text' name='deviceHDDSpace'></td>
	<td><input type='text' name='deviceSSDSpace'></td>
	<td><input type='submit'></td>

	</tr>
	</table>

	</form>

	<br/><br/>
	<a href='index.php'>[go back]</a>

	";

}
if (isset($_GET['action'])){
	if($_GET['action'] == "search"){
	$colarray = array();
	$searcharray = array();

	$dbcolcheck = array("deviceName","deviceType","deviceOwner","deviceOS","deviceRAM","deviceGPU","deviceMobo","deviceProcessor","deviceHDDSpace","deviceSSDSpace");
	foreach ($dbcolcheck as $dbcol){
		if (isset($_POST[$dbcol])){$sAddtoSearch = $_POST[$dbcol];}else if (isset($_GET[$dbcol])){$sAddtoSearch = $_GET[$dbcol];}
		if (!empty($sAddtoSearch)){
			array_push($colarray,$dbcol);
			array_push($searcharray,$sAddtoSearch);
			$sAddtoSearch =""; //Resets variable
		}
	}
	$softwareID = $_POST['softwareID'];

	/*
	if (isset($_POST['deviceType'])){$sDeviceType = $_POST['deviceType'];}elseif (isset($_GET['deviceType'])){$sDeviceType = $_GET['deviceType'];}
	if (!empty($sDeviceType)){
	array_push($colarray,"deviceType");
	array_push($searcharray,$sDeviceType);
	}


	if (isset($_POST['deviceOwner'])){$sDeviceOwner = $_POST['deviceOwner'];}elseif (isset($_GET['deviceOwner'])){$sDeviceOwner = $_GET['deviceOwner'];}
	if (!empty($sDeviceOwner)){
	array_push($colarray,"deviceOwner");
	array_push($searcharray,$sDeviceOwner);
	}

	if (isset($_POST['deviceOS'])){$sDeviceOS = $_POST['deviceOS'];}elseif (isset($_GET['deviceOS'])){$sDeviceOS = $_GET['deviceOS'];}
	if (!empty($sDeviceOS)){
	array_push($colarray,"deviceOS");
	array_push($searcharray,$sDeviceOS);
	}

	if (isset($_POST['deviceRAM'])){$sDeviceRAM = $_POST['deviceRAM'];}elseif (isset($_GET['deviceRAM'])){$sDeviceRAM = $_GET['deviceRAM'];}
	if (!empty($sDeviceRAM)){
	array_push($colarray,"deviceRAM");
	array_push($searcharray,$sDeviceRAM);
	}

	if (isset($_POST['deviceGPU'])){$sDeviceGPU = $_POST['deviceGPU'];}elseif (isset($_GET['deviceGPU'])){$sDeviceGPU = $_GET['deviceGPU'];}
	if (!empty($sDeviceGPU)){
	array_push($colarray,"deviceGPU");
	array_push($searcharray,$sDeviceGPU);
	}

	if (isset($_POST['deviceMobo'])){$sDeviceMobo = $_POST['deviceMobo'];}elseif (isset($_GET['deviceMobo'])){$sDeviceMobo = $_GET['deviceMobo'];}
	if (!empty($sDeviceMobo)){
	array_push($colarray,"deviceMobo");
	array_push($searcharray,$sDeviceMobo);
	}
	if (isset($_POST['deviceProcessor'])){$sDeviceProcessor = $_POST['deviceProcessor'];}elseif (isset($_GET['deviceProcessor'])){$sDeviceProcessor = $_GET['deviceProcessor'];}
	if (!empty($sDeviceProcessor)){
	array_push($colarray,"deviceProcessor");
	array_push($searcharray,$sDeviceProcessor);
	}
	if (isset($_POST['deviceHDDSpace'])){$sDeviceHDDSpace = $_POST['deviceHDDSpace'];}elseif (isset($_GET['deviceHDDSpace'])){$sDeviceHDDSpace = $_GET['deviceHDDSpace'];}
	if (!empty($sDeviceHDDSpace)){
	array_push($colarray,"deviceHDDSpace");
	array_push($searcharray,$sDeviceHDDSpace);
	}
	if (isset($_POST['deviceSSDSpace'])){$sDeviceSSDSpace = $_POST['deviceSSDSpace'];}elseif (isset($_GET['deviceSSDSpace'])){$sDeviceSSDSpace = $_GET['deviceSSDSpace'];}
	if (!empty($sDeviceSSDSpace)){
	array_push($colarray,"deviceSSDSpace");
	array_push($searcharray,$sDeviceSSDSp  ace);
	}
	*/
	
	$i = 0;
	$querystringarr = array();
	foreach($colarray as $col){
	if ($i == 0){
		array_push($querystringarr,"WHERE $col LIKE '$searcharray[$i]'");
	}else{
		array_push($querystringarr,"AND $col LIKE '$searcharray[$i]'");
	}
	$i++;
	}
	$querystring = implode("", $querystringarr);
	$sql = mysql_query("SELECT * 
	FROM  devices 
	$querystring
	LIMIT 0 , 30");

	$deviceIDlist = array();
	if (empty($softwareID)){
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
			echo "<td><a href='query.php?action=search&deviceRAM=".$device->deviceRAM."'>". $device->deviceRAM . " MB</a></td>";
			echo "<td><a href='query.php?action=search&deviceGPU=".$device->deviceGPU."'>". $device->deviceGPU . "</a></td>";
			echo "<td><a href='query.php?action=search&deviceMobo=".$device->deviceMobo."'>". $device->deviceMobo . "</a></td>";
			echo "<td><a href='query.php?action=search&deviceProcessor=".$device->deviceProcessor."'>". $device->deviceProcessor . "</a></td>";
			echo "<td><a href='query.php?action=search&deviceHDDSpace=".$device->deviceHDDSpace."'>". $device->deviceHDDSpace . " GB</a></td>";
			echo "<td><a href='query.php?action=search&deviceSSDSpace=".$device->deviceSSDSpace."'>". $device->deviceSSDSpace . " GB</a></td>";
			echo "<td><a href='viewdevices.php?editdevice=". $device->ID ."'>[edit]</a> <a href='viewdevices.php?	deletedevice=".$device->ID."'>[delete]</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}else{
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
			$devid = $device->ID;
			$dsoftwareName = urldecode($softwareID);
			$checksoftware = mysql_query("SELECT computerID FROM software WHERE softwareName = '$dsoftwareName' AND computerID = '$devid'");

			while ($dd = mysql_fetch_object($checksoftware)){
				$ddid = $dd->computerID;
				$sql2 = mysql_query("SELECT * FROM devices WHERE ID = '$ddid'");
				while ($device2 = mysql_fetch_object($sql2)){
					echo "<tr>";
					echo "<td>". $device2->ID . "</td>";
					echo "<td><a href='query.php?action=search&deviceName=".$device2->deviceName."'>". $device2->deviceName . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceType=".$device2->deviceType."'>". $device2->deviceType . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceOwner=".$device2->deviceOwner."'>". $device2->deviceOwner . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceOS=".$device2->deviceOS."'>". $device2->deviceOS . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceRAM=".$device2->deviceRAM."'>". $device2->deviceRAM . " MB</a></td>";
					echo "<td><a href='query.php?action=search&deviceGPU=".$device2->deviceGPU."'>". $device2->deviceGPU . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceMobo=".$device2->deviceMobo."'>". $device2->deviceMobo . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceProcessor=".$device2->deviceProcessor."'>". $device2->deviceProcessor . "</a></td>";
					echo "<td><a href='query.php?action=search&deviceHDDSpace=".$device2->deviceHDDSpace."'>". $device2->deviceHDDSpace . " GB</a></td>";
					echo "<td><a href='query.php?action=search&deviceSSDSpace=".$device2->deviceSSDSpace."'>". $device2->deviceSSDSpace . " GB</a></td>";
					echo "<td><a href='viewdevices.php?editdevice=". $device2->ID ."'>[edit]</a> <a href='viewsoftware.php?getdevice=".$device2->ID."'>[view software]</a> <a href='viewdevices.php?deletedevice=".$device2->ID."'>[delete]</a></td>";
					echo "</tr>";
				}
			}

		}
		echo "</table>";
	}
	if ($debug){
	echo  "<br/>";

	echo  "Column array: ";print_r($colarray);

	echo  "<br/>";
	echo  "Search array: ";print_r($searcharray);
	echo  "<br/>";
	echo  "Query array: "; print_r($querystringarr);
	echo  "<br/>";
		echo "Query performed: " . $querystring;
	}
	echo "<br/><br/><a href='query.php'>[search again]</a> <a href='index.php'>[go back]</a>";
	}

}
?>