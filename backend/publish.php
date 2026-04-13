<?php
$Roomid = $_POST["Roomid"];
// $Temperature = $_POST["Temperature"];
// $Humidity = $_POST["Humidity"];
require("phpMQTT.php");
require("config.php");
$message = "$Roomid,"."$Temperature,"."$Humidity";
// $message = "Hello CloudAMQP MQTT! This is test from TAIWAN";
echo $message;
// MQTT client id to use for the device. "" will generate a client id automatically
$mqtt = new bluerhinos\phpMQTT($host, $port, "ClientID".rand());
$topicName = $_POST["topic"];
if ($mqtt->connect(true,NULL,$username,$password)) {
  	$mqtt->publish($topicName,$message, 0);
	$mqtt->close();
	// header('location:in.html');
}else{
  echo "Fail or time out";
}
?>