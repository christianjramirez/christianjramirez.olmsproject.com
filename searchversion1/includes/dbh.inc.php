<?php

$dsn = "mysql:host=localhost;dbname=searchtest1";
$dbusername = "root";
$dbpassword = "";

try {
	$pdo = new PDO($dsn, $dbusername, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOExeption $e) {
	echo "Connection failed: " . $e->getMessage();
}