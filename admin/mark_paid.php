<?php
// Database connection parameters
$DB_HOST = "otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$DB_USER = "s9wgia2c6o9hkmiw";
$DB_PASSWORD = "q8picm6svmo4747m";
$DB_NAME = "tbg6k1c9f4ovc355";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $fee_id = $_GET['id'];

        // Mark fee as paid
        $stmt = $db->prepare("UPDATE overdue_fees SET paid = 1 WHERE fee_id = ?");
        $stmt->execute([$fee_id]);

        $message = "Fee ID $fee_id has been marked as paid.";
    } else {
        $message = "Invalid request.";
    }
} catch (PDOException $e) {
    $message = "Database connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Fee as Paid</title>
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
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container h2 {
            color: rgb(49, 112, 60);
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
        <h1>Mark Fee as Paid</h1>
        <div class="nav-buttons">
            <a href="dashboard.php">Return to Dashboard</a>
            <a href="manage_fees.php">Back to Manage Fees</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2><?php echo htmlspecialchars($message); ?></h2>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Library Management System. All Rights Reserved.
    </div>
</body>
</html>

