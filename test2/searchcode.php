<?php

?>
<form action="includes/formhandler.inc.php" method="post">
	<input type="text" name="titlesearch" placeholder="Title">
	<input type="text" name="isbnsearch" placeholder="ISBN">
	<input type="text" name="authorsearch" placeholder="Author">
	<button>Search</button>
</form>
<?php

$dsn = "mysql:host=localhost;dbname=test2db";
$dbusername = "root";
$dbpassword = "";
try {
	$pdo = new PDO($dsn, $dbusername, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOExeption $e) {
	echo "Connection failed: " . $e->getMessage();
}

$sth = $pdo->prepare('SELECT ISBN, title, author, pictureInfo FROM searchresults WHERE ISBN = 0000;');
$sth->execute();
$result = $sth->fetch(PDO::FETCH_OBJ);

if (!empty($result))
{
	$sth = $pdo->prepare('DELETE FROM searchresults WHERE ISBN = 0000;');
	$sth->execute();

	$sth = $pdo->prepare('SELECT ISBN, title, author, pictureInfo FROM searchresults;');
	$sth->execute();
}
else
{
	$sth = $pdo->prepare('SELECT ISBN, title, author, pictureInfo FROM book2;');
	$sth->execute();
}

?><h3>Results:</h3><br><?php
$count = 0;
$results = $sth->fetchAll();
foreach ($results as $result)
{
	$title1 = $result['title'];
	$pictureInfo1 = $result['pictureInfo'];
	$author1 = $result['author'];
	$ISBN1 = $result['ISBN'];

	if ($ISBN1 != '0000')
	{
		?>
		<img src=<?php echo $pictureInfo1; ?>>
		<figcaption>
		title: <?php echo $title1; ?><br>author: <?php echo $author1; ?><br>isbn: <?php echo $ISBN1; ?>
		<?php

		$sth = $pdo->prepare('SELECT * FROM book_has_loan2 WHERE bookHasISBN = :ISBNInput;');
		$sth->bindParam('ISBNInput', $ISBN1);
		$sth->execute();
		$loanArray = $sth->fetch(PDO::FETCH_OBJ);

		if (isset($_SESSION['userId']))
		{
			if(!$loanArray)
			{
				?>
				<br>this book is not loaned:
				<form action="loanbook.php" method="post">
					<input type = "hidden" name = "title" value = "<?php
						echo $title1;
					?>">
					<input type = "hidden" name = "ISBN" value = "<?php
						echo $ISBN1;
					?>">
					<button>go to loanbook.php</button>
				</form>
				<?php
			}
			else
			{
				echo "<br>this book is loaned";
			}
		}
		?>
		</figcaption>
		<?php
	}
	$count++;
}
if ($count == 0)
{
	print "There are no results";
}

$pdo = null;
$sth = null;