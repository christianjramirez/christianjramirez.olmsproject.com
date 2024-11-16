<!DOCTYPE html>
<html>
	<body>
		<h3>Search</h3>
		<form action="includes/formhandler.inc.php" method="post">
			<input type="text" name="titlesearch" placeholder="Title">
			<input type="text" name="isbnsearch" placeholder="ISBN">
			<input type="text" name="authorsearch" placeholder="Author">
			<button>Search</button>
		</form>
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
			while ($result = $sth->fetch(PDO::FETCH_OBJ))
			{
				$title1 = $result->title;;
				$pictureInfo1 = $result->pictureInfo;
				$author1 = $result->author;;
				$ISBN1 = $result->ISBN;

				if ($ISBN1 != '0000')
				{
					?>
					<img src=<?php echo $pictureInfo1; ?>>
					<figcaption>
					title: <?php echo $title1; ?><br>author: <?php echo $author1; ?><br>isbn: <?php echo $ISBN1; ?>
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
			$stmt = null;

		?>
	</body>
</html>