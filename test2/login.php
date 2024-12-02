<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$dbObject = EnterDatabase();

	$usernameInput = $_POST["usernameInput"];
	$stmt = $dbObject->prepare('SELECT * FROM user2 WHERE name = :input;');
	$stmt->bindParam('input', $usernameInput);
	$stmt->execute();
	$userArray = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($userArray)
	{
		$_SESSION['userId'] = $userArray['name'];
	}

	$dbObject = null;
	$stmt = null;
	header("Location: index.php");
	die();
}
else
{
	header("Location: index.php");
}

function EnterDatabase()
{
	try
	{
		$dbObject = new PDO("mysql:host=localhost;dbname=test2db", "root", "");
		$dbObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbObject;
	} catch (PDOExeption $e)
	{
		echo $e->getMessage();
	}
}