<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_SESSION['userId']))
	{
		$title2 = $_POST["title"];
		echo $title2 . "<br>";
		$ISBN2 = $_POST["ISBN"];
		echo $ISBN2 . "<br>";
		echo "you are logged in as " . $_SESSION['userId'];

		$dbObject = EnterDatabase();

		$stmt = $dbObject->prepare('INSERT INTO loan2 () VALUES ();');
		$stmt->execute();

		$stmt = $dbObject->prepare('SELECT MAX(LID) FROM loan2;');
		$stmt->execute();
		$recentLIDArray = $stmt->fetch(PDO::FETCH_ASSOC);
		$recentLID = $recentLIDArray['MAX(LID)'];
		echo $recentLID;

		$stmt = $dbObject->prepare('INSERT INTO book_has_loan2 (bookHasLID, bookHasISBN)
			VALUES (:LIDInput, :ISBNInput);');
		$stmt->bindParam('LIDInput', $recentLID);
		$stmt->bindParam('ISBNInput', $ISBN2);
		$stmt->execute();

		$stmt = $dbObject->prepare('SELECT UID FROM user2 WHERE name = :nameInput;');
		$stmt->bindParam('nameInput', $_SESSION['userId']);
		$stmt->execute();
		$UIDArray = $stmt->fetch(PDO::FETCH_OBJ);
		$UIDCurrent = $UIDArray->UID;

		
		$stmt = $dbObject->prepare('INSERT INTO user_has_loan2 (userHasLID, userHasUID)
			VALUES (:LIDInput, :UIDInput);');
		$stmt->bindParam('LIDInput', $recentLID);
		$stmt->bindParam('UIDInput', $UIDCurrent);
		$stmt->execute();
	}
	else
	{
		header("Location: index.php");
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