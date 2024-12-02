<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	header("Location: index.php");
	die();
}
else
{
	header("Location: index.php");
}