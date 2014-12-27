<?php
include "include.php";
if (!$ISLOGGEDIN){
	header("location: login.php");
}
echo "
<i>If any specifications do not apply to the device, type \"N/A\" without quotations</i><br/><br/>
<form action='adddevice.php?action=submit' method='post'>
<label>Device Name</label> <input type='text' name='deviceName'><br/><br/>
<label>Device Type</label> <select name='deviceType'>
  <option value='Desktop PC'>Desktop PC</option>
  <option value='Laptop' >Laptop</option>
  <option value='Tablet'>Tablet</option>
  <option value='Mobile Phone'>Mobile Phone</option>
  <option value='Other' $>Other</option>
</select><Br/><br/>
<label>Device Owner</label> <input type='text' name='deviceOwner'><Br/><br/>
<label>Operating System</label> <input type='text' name='deviceOS'><br/><br/>
<label>RAM Amount  (MB)</label> <input type='text' name='deviceRAM'><br/><br/>
<label>GPU</label> <input type='text' name='deviceGPU'><br/><br/>
<label>Motherboard</label> <input type='text' name='deviceMobo'><br/><br/>
<label>Processor</label> <input type='text' name='deviceProcessor'><br/><br/>
<label>HDD Space (GB)</label> <input type='text' name='deviceHDDSpace'><br/><br/>
<label>SSD Space (GB)</label> <input type='text' name='deviceSSDSpace'><br/><br/>

<input type='submit'>
</form>

<br/><br/>
<a href='index.php'>[go back]</a>

";


if (isset($_GET['action'])){
	if($_GET['action'] == "submit"){
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

		mysql_query("INSERT INTO devices (deviceName, deviceType, deviceOwner, deviceOS, deviceRAM, deviceGPU, deviceMobo, deviceProcessor, deviceHDDSpace, deviceSSDSpace) VALUES ('$sDeviceName', '$sDeviceType', '$sDeviceOwner', '$sDeviceOS', '$sDeviceRAM', '$sDeviceGPU', '$sDeviceMobo', '$sDeviceProcessor', '$sDeviceHDDSpace', '$sDeviceSSDSpace')");
		header("location: viewdevices.php");
	}

}
?>