<?php
session_start();

// Database connection
$db_hostname = "127.0.0.1"; // Replace with your database hostname
$db_username = "root";      // Replace with your database username
$db_password = "";          // Replace with your database password
$db_name = "college";       // Replace with your database name

$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming worker_id is stored in session when the worker logs in
if (!isset($_SESSION['worker_id'])) {
    echo "You must log in to view this page.";
    exit;
}

$worker_id = $_SESSION['worker_id']; // Fetch worker_id from session

// Query to fetch previous complaints (completed)
$query = "SELECT wa.id, c.description, wa.status, wa.assigned_at 
          FROM work_assignments wa 
          JOIN user_complaints c ON wa.complaint_id = c.id 
          WHERE wa.worker_id = $worker_id AND wa.is_completed = 1";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Previous Complaints</h2>
        <p>Here are the complaints you have completed:</p>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Assignment ID</th><th>Complaint</th><th>Status</th><th>Assigned At</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['assigned_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No previous complaints found.</p>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
