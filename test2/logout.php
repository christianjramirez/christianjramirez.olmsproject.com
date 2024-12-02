<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	unset($_SESSION['userId']);
	header("Location: index.php");
	die();
}
else
{
	header("Location: index.php");
}