<?php
// Database connection parameters
$DB_HOST = "otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$DB_USER = "s9wgia2c6o9hkmiw";
$DB_PASSWORD = "q8picm6svmo4747m";
$DB_NAME = "tbg6k1c9f4ovc355";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['ISBN'])) {
        $ISBN = $_GET['ISBN'];

        // Confirm deletion
        if (isset($_POST['confirm'])) {
            $stmt = $db->prepare("DELETE FROM book2 WHERE ISBN = ?");
            $stmt->execute([$ISBN]);
            header("Location: manage_books.php");
            exit;
        }
    } else {
        die("ISBN not provided.");
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(49, 112, 60);
            color: white;
            text-align: center;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: white;
            color: black;
            border-radius: 10px;
            display: inline-block;
        }

        .container button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: rgb(49, 112, 60);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container button:hover {
            background-color: rgb(36, 86, 47);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Book</h1>
        <p>Are you sure you want to delete this book?</p>
        <form method="post">
            <button type="submit" name="confirm">Yes, Delete</button>
        </form>
        <a href="manage_books.php" style="text-decoration: none; margin-top: 20px; display: inline-block;">Cancel</a>
    </div>
</body>
</html>
