<?php
// Database connection parameters
$DB_HOST = "otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$DB_USER = "s9wgia2c6o9hkmiw";
$DB_PASSWORD = "q8picm6svmo4747m";
$DB_NAME = "tbg6k1c9f4ovc355";
$DB_PORT = 3306;

try {
    // Connect to the database
    $db = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch total books
    $totalBooks = $db->query("SELECT COUNT(*) FROM book2")->fetchColumn();

    // Fetch total members
    $totalMembers = $db->query("SELECT COUNT(*) FROM user2")->fetchColumn();

    // Fetch total loans
    $totalLoans = $db->query("SELECT COUNT(*) FROM loan2")->fetchColumn();

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .header .nav-buttons {
            display: flex;
            gap: 15px;
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stats .card-container {
            flex: 1;
            max-width: 30%;
            padding: 20px;
            background-color: rgb(196, 182, 129);
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .stats .card-container .card h2 {
            margin: 0;
            font-size: 2rem;
            color: rgb(49, 112, 60);
        }

        .stats .card-container .card p {
            margin: 10px 0 15px;
            font-size: 1.2rem;
        }

        .stats .card-container a {
            display: inline-block;
            text-decoration: none;
            background-color: rgb(49, 112, 60);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .stats .card-container a:hover {
            background-color: rgb(36, 86, 47);
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgb(196, 182, 129);
            color: rgb(0, 132, 82);
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div class="nav-buttons">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <p>Overview of the system:</p>

        <!-- Stats Section -->
        <div class="stats">
            <div class="card-container">
                <div class="card">
                    <h2><?php echo $totalMembers; ?></h2>
                    <p>Total Members</p>
                </div>
                <a href="manage_users.php">Manage Users</a>
            </div>
            <div class="card-container">
                <div class="card">
                    <h2><?php echo $totalBooks; ?></h2>
                    <p>Total Books</p>
                </div>
                <a href="manage_books.php">Manage Books</a>
            </div>
            <div class="card-container">
                <div class="card">
                    <h2><?php echo $totalLoans; ?></h2>
                    <p>Total Loans</p>
                </div>
                <a href="manage_fees.php">Manage Fees</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Library Management System.
    </div>
</body>
</html>

