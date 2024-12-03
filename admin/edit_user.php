<?php
// Database connection parameters
$DB_HOST = "otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$DB_USER = "s9wgia2c6o9hkmiw";
$DB_PASSWORD = "q8picm6svmo4747m";
$DB_NAME = "tbg6k1c9f4ovc355";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update the user details
        $UID = $_POST['UID'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];

        $stmt = $db->prepare("UPDATE user2 SET name = ?, email = ?, phonenumber = ? WHERE UID = ?");
        $stmt->execute([$name, $email, $phonenumber, $UID]);

        header("Location: manage_users.php");
        exit;
    } else {
        // Fetch the user details for editing
        $UID = $_GET['UID'];
        $stmt = $db->prepare("SELECT * FROM user2 WHERE UID = ?");
        $stmt->execute([$UID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("User not found.");
        }
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
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(49, 112, 60);
            color: rgb(45, 44, 44);
        }

        .header {
            background-color: rgb(49, 112, 60);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .header .nav-buttons a {
            text-decoration: none;
            background-color: rgb(196, 182, 129);
            color: rgb(49, 112, 60);
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .header .nav-buttons a:hover {
            background-color: rgb(180, 168, 120);
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: rgb(49, 112, 60);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: rgb(36, 86, 47);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Edit User</h1>
        <div class="nav-buttons">
            <a href="manage_users.php">Back to Manage Users</a>
        </div>
    </div>

    <div class="container">
        <form method="post">
            <input type="hidden" name="UID" value="<?php echo htmlspecialchars($user['UID']); ?>">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Phone</label>
            <input type="text" name="phonenumber" value="<?php echo htmlspecialchars($user['phonenumber']); ?>" required>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
