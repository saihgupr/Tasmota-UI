<?php

#Receive and Parse URL Params
	$URI = $_SERVER['REQUEST_URI'];
	$URL = urldecode($URI);
	$URL = strtolower($URL);
	$ARRAY = explode("/", $URL);

#Get Json File Data
	$jsonFile = file_get_contents("devices.json");
	$json = json_decode($jsonFile, true);

#IF URL Command
	if ($ARRAY[2] == "add") {
		addJson($ARRAY,$json);
	} else if ($ARRAY[2] == "delete") {
		deleteJson($ARRAY,$json);
	} else if ($ARRAY[2] == "get") {
		jsonList($ARRAY,$json);
	} else if ($ARRAY[2] == "group") {
		groupCurl($ARRAY,$json);
	} else if ($ARRAY[2] == "ha") {
		ha($ARRAY,$json);
	} else if ($ARRAY[2] == "km") {
		km($ARRAY,$json);
	} else if ($ARRAY[2] == "ssh") {
		ssh($ARRAY,$json);
	} else if ($ARRAY[2] == "post") {
		postCurl($ARRAY,$json);
	} else if ($ARRAY[2] == "mqtt") {
		mqtt($ARRAY,$json);
	}

#Post Commands To Device
	function postCurl($ARRAY,$json) {
		$type = $ARRAY[3];
		$deviceName = $ARRAY[4];
		$cmd = $ARRAY[5];
		$parm = $ARRAY[6];
		$deviceIP = $json[$type][$deviceName];
		echo "http://$deviceIP/cm?cmnd=$cmd%20$parm";
		$output = shell_exec("curl http://$deviceIP/cm?cmnd=$cmd%20$parm");
		echo "$output\n";
	}

#Add Items To JSON File
	function addJson($ARRAY, $json) {
		$type = $ARRAY[3];
		$deviceName = $ARRAY[4];
		$deviceIp = $ARRAY[5];
		$addition[$deviceName] = $deviceIp;
		$typeArray = $json[$type]; # Get JSON Of That Type
		$mergedArray = array_merge($typeArray, $addition);
		echo json_encode($mergedArray);
		$pizza[$type] = $mergedArray;
		$mergedArray = array_merge($json, $pizza);
		file_put_contents("devices.json", json_encode($mergedArray, JSON_PRETTY_PRINT));
	}

#Remove Items From JSON File
	function deleteJson($ARRAY,$json) {
		$type = $ARRAY[3];
		$deviceName = $ARRAY[4];
		unset($json[$type][$deviceName]);
		echo json_encode($json[$type]);
		file_put_contents("devices.json", json_encode($json, JSON_PRETTY_PRINT));
	}

#Call JSON File Devices
	function jsonList($ARRAY,$json) {
		$type = $ARRAY[3];
		$deviceName = $ARRAY[4];
		if(isset($deviceName)){
			$deviceName = $json[$type][$deviceName];
			echo json_encode($deviceName);
		} else if(isset($type)){
			$typeList = $json[$type];
			echo json_encode($typeList);
		} else {
			echo json_encode($json);
		}
	}

#Call JSON Group
	function groupCurl($ARRAY,$json) {
		$type = $ARRAY[3];
		$cmd = $ARRAY[4];
		$parm = $ARRAY[5];
		foreach($json[$type] as $key=>$val){
	        json_encode($val);
	        echo $val;
			$deviceIP = $val;
			$output = shell_exec("curl http://$deviceIP/cm?cmnd=$cmd%20$parm");
			echo "$output\n";
		}
	}
	

?>