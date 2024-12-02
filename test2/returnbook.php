<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$LIDInput = $_POST["LIDInput"];
	$authorInput = $_POST["authorInput"];
	$titleInput = $_POST["titleInput"];
	$ISBNInput = $_POST["ISBNInput"];
	$timeInput = $_POST["timeInput"];
	$UIDInput = $_POST["UIDInput"];

	$dbObject = EnterDatabase();

	$sth = $dbObject->prepare('DELETE FROM user_has_loan2 WHERE userHasLID = :LIDInput;');
	$sth->bindParam('LIDInput', $LIDInput);
	$sth->execute();

	$sth = $dbObject->prepare('DELETE FROM book_has_loan2 WHERE bookHasLID = :LIDInput;');
	$sth->bindParam('LIDInput', $LIDInput);
	$sth->execute();

	$sth = $dbObject->prepare('DELETE FROM loan2 WHERE LID = :LIDInput;');
	$sth->bindParam('LIDInput', $LIDInput);
	$sth->execute();

	$sth = $dbObject->prepare('INSERT INTO loan_history2 (histLID, histTime, histUID, histISBN,
		histTitle, histAuthor) VALUES (:LIDInput, :timeInput, :UIDInput, :ISBNInput,
		:titleInput, :authorInput);');
	$sth->bindParam('LIDInput', $LIDInput);
	$sth->bindParam('authorInput', $authorInput);
	$sth->bindParam('titleInput', $titleInput);
	$sth->bindParam('ISBNInput', $ISBNInput);
	$sth->bindParam('timeInput', $timeInput);
	$sth->bindParam('UIDInput', $UIDInput);
	$sth->execute();

	header("Location: viewloans.php");
}
else
{
	header("Location: viewloans.php");
}

$dbObject = null;
$sth = null;

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