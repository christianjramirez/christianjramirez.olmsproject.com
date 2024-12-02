<?php

session_start();

if(isset($_SESSION['userId']))
{
	$dbObject = EnterDatabase();

	$sth = $dbObject->prepare('SELECT UID FROM user2 WHERE name = :nameInput;');
	$sth->bindParam('nameInput', $_SESSION['userId']);
	$sth->execute();
	$UIDArray = $sth->fetch(PDO::FETCH_OBJ);
	$UIDCurrent = $UIDArray->UID;

	$sth = $dbObject->prepare('SELECT userHasLID FROM user_has_loan2
		WHERE userHasUID = :UIDInput;');
	$sth->bindParam('UIDInput', $UIDCurrent);
	$sth->execute();
	$loanArray = $sth->fetchAll();

	$count = 1;
	$outputArray = [
		"ISBN" => "",
		"title" => "",
		"author" => "",
		"time" => "",
	];

	?>
	<h3>active loans:</h3>
	<?php
	if ($loanArray)
	{
		foreach ($loanArray as $LID)
		{
			$sth = $dbObject->prepare('SELECT bookHasISBN FROM book_has_loan2
				WHERE bookHasLID = :LIDInput;');
			$sth->bindParam('LIDInput', $LID['userHasLID']);
			$sth->execute();
			$ISBNArray = $sth->fetch(PDO::FETCH_OBJ);
			$ISBNCurrent = $ISBNArray->bookHasISBN;

			$outputArray["ISBN"] = $ISBNCurrent;

			$sth = $dbObject->prepare('SELECT title, author FROM book2
				WHERE ISBN = :ISBNInput;');
			$sth->bindParam('ISBNInput', $ISBNCurrent);
			$sth->execute();
			$infoArray = $sth->fetch(PDO::FETCH_OBJ);
			$titleCurrent = $infoArray->title;
			$authorCurrent = $infoArray->author;

			$outputArray["title"] = $titleCurrent;
			$outputArray["author"] = $authorCurrent;

			$sth = $dbObject->prepare('SELECT time FROM loan2
				WHERE LID = :LIDInput;');
			$sth->bindParam('LIDInput', $LID['userHasLID']);
			$sth->execute();
			$timeArray = $sth->fetch(PDO::FETCH_OBJ);
			$timeCurrent = $timeArray->time;

			$outputArray["time"] = $timeCurrent;

			?>
			<p>
				title:
				<?php echo $outputArray["title"]; ?>______author:
				<?php echo $outputArray["author"]; ?>______ISBN:
				<?php echo $outputArray["ISBN"]; ?>______time loaned:
				<?php echo $outputArray["time"]; ?>

				<form action="returnbook.php" method="post">
					<input type = "hidden" name = "LIDInput" value = "<?php
						echo $LID['userHasLID'];
					?>">
					<input type = "hidden" name = "authorInput" value = "<?php
						echo $outputArray["author"];
					?>">
					<input type = "hidden" name = "titleInput" value = "<?php
						echo $outputArray["title"];
					?>">
					<input type = "hidden" name = "ISBNInput" value = "<?php
						echo $outputArray["ISBN"];
					?>">
					<input type = "hidden" name = "timeInput" value = "<?php
						echo $outputArray["time"];
					?>">
					<input type = "hidden" name = "UIDInput" value = "<?php
						echo $UIDCurrent;
					?>">
					<button>return book</button>
				</form>
			</p>
			<?php

			$count++;
		}
	}
	else
	{
		echo "there are no active loans";
	}

	$sth = $dbObject->prepare('SELECT * FROM loan_history2 WHERE histUID = :UIDInput
		ORDER BY timeReturned DESC;');
	$sth->bindParam('UIDInput', $UIDCurrent);
	$sth->execute();
	$histArray = $sth->fetchAll();

	?>
	<h3>returned loans:</h3>
	<?php
	if ($histArray)
	{
		foreach ($histArray as $loanHist)
		{
			?>
			<p>
				title:
				<?php echo $loanHist["histTitle"]; ?>______author:
				<?php echo $loanHist["histAuthor"]; ?>______ISBN:
				<?php echo $loanHist["histISBN"]; ?>______time loaned:
				<?php echo $loanHist["histTime"]; ?>______time returned:
				<?php echo $loanHist["timeReturned"]; ?>
			</p>
			<?php
		}
	}
	else
	{
		?>
		<p>
			there are no returned loans
		</p>
		<?php
	}

	?>
	<form action="index.php" method="post">
		<button>go to index</button>
	</form>
	<?php
}
else
{
	header("Location: index.php");
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