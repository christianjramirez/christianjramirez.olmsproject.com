<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_start();
?>

<!DOCTYPE html>
<html>

	<head>
	</head>

	<body>

		<?php
		if(isset($_SESSION['userId']))
		{
			echo "you are logged in as " . $_SESSION['userId'];

			?>
			<br>
			<form action="viewloans.php" method="post"">
				<button>view loans</button>
			</form>

			<form action="logout.php" method="post"">
				<button>logout</button>
			</form>
			<?php
		}
		else
		{
			echo "you are not logged in";

			?>
			<form action="login.php" method="post"">
				<input type="text" name="usernameInput"
					placeholder="usernameInput">
				<button>login</button>
			</form>
			<?php
		}
		?>

		<?php
		require_once "searchcode.php";
		?>

	</body>

</html>