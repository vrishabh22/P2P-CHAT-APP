<?php
try {
	$dbusername='root';
	$dbpassword='';
	$database = 'chatapp';
	$db = new PDO("mysql:host=localhost;dbname=$database",$dbusername,$dbpassword);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	echo "Unable to connect to the database </br>";
	echo $e->getMessage();
	exit;
}