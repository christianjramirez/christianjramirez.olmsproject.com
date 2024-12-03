<?php
// Database connection parameters
$DB_HOST = "otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$DB_USER = "s9wgia2c6o9hkmiw";
$DB_PASSWORD = "q8picm6svmo4747m";
$DB_NAME = "tbg6k1c9f4ovc355";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all overdue fees
    $fees = $db->query("
        SELECT f.fee_id AS id, u.name AS user, f.amount, f.paid, l.due_date
        FROM overdue_fees f
        JOIN user2 u ON f.user_id = u.UID
        JOIN loan2 l ON f.loan_id = l.LID
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Overdue Fees</title>
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
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgb(196, 182, 129);
            color: rgb(49, 112, 60);
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: rgb(49, 112, 60);
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
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
        <h1>Manage Overdue Fees</h1>
        <div class="nav-buttons">
            <a href="dashboard.php">Return to Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fee['id']); ?></td>
                    <td><?php echo htmlspecialchars($fee['user']); ?></td>
                    <td><?php echo htmlspecialchars($fee['due_date']); ?></td>
                    <td><?php echo htmlspecialchars('$' . number_format($fee['amount'], 2)); ?></td>
                    <td><?php echo $fee['paid'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="mark_paid.php?id=<?php echo $fee['id']; ?>">Mark Paid</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Library Management System.
    </div>
</body>
</html>

