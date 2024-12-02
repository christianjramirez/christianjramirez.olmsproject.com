<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	try {
		require_once "dbh.inc.php";

		$sth = $pdo->prepare('TRUNCATE searchresults');
		$sth->execute();

		$sth = $pdo->prepare('INSERT INTO searchresults (ISBN) VALUES (0000)');
		$sth->execute();

		$titlesearch = $_POST["titlesearch"];
		$isbnsearch = $_POST["isbnsearch"];
		$authorsearch = $_POST["authorsearch"];
		if (empty($titlesearch) && empty($isbnsearch) && empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2');
		}
		else if (!empty($titlesearch) && empty($isbnsearch) && empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE title = ?');
			$sth->bindParam(1, $titlesearch, PDO::PARAM_STR, 75);
		}
		else if (empty($titlesearch) && !empty($isbnsearch) && empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE ISBN = ?');
			$sth->bindParam(1, $isbnsearch, PDO::PARAM_INT, 13);
		}
		else if (empty($titlesearch) && empty($isbnsearch) && !empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE author = ?');
			$sth->bindParam(1, $authorsearch, PDO::PARAM_STR, 75);
		}
		else if (empty($titlesearch) && !empty($isbnsearch) && !empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE author = ? AND ISBN = ?');
			$sth->bindParam(1, $authorsearch, PDO::PARAM_STR, 75);
			$sth->bindParam(2, $isbnsearch, PDO::PARAM_INT, 13);
		}
		else if (!empty($titlesearch) && empty($isbnsearch) && !empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE author = ? AND title = ?');
			$sth->bindParam(1, $authorsearch, PDO::PARAM_STR, 75);
			$sth->bindParam(2, $titlesearch, PDO::PARAM_STR, 75);
		}
		else if (!empty($titlesearch) && !empty($isbnsearch) && empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE ISBN = ? AND title = ?');
			$sth->bindParam(1, $isbnsearch, PDO::PARAM_INT, 13);
			$sth->bindParam(2, $titlesearch, PDO::PARAM_STR, 75);
		}
		else if (!empty($titlesearch) && !empty($isbnsearch) && !empty($authorsearch))
		{
			$sth = $pdo->prepare('INSERT INTO searchresults SELECT ISBN, title, author, pictureInfo FROM book2
			WHERE ISBN = ? AND title = ? AND author = ?');
			$sth->bindParam(1, $isbnsearch, PDO::PARAM_INT, 13);
			$sth->bindParam(2, $titlesearch, PDO::PARAM_STR, 75);
			$sth->bindParam(3, $authorsearch, PDO::PARAM_STR, 75);
		}

		$sth->execute();

		$pdo = null;
		$sth = null;

		header("Location: ../index.php");

		die();
	} catch (PDOException $e) {
		die("Query failed: " . $e->getMessage());
	}
}
else {
	header("Location: ../index.php");
}