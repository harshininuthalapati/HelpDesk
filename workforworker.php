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

// If a 'Done' button is clicked
if (isset($_POST['done'])) {
    $assignment_id = $_POST['assignment_id'];

    // Update the assignment status to completed
    $update_query = "UPDATE work_assignments SET is_completed = 1 WHERE id = $assignment_id";
    mysqli_query($conn, $update_query);

    // Redirect to the same page to refresh the assignments
    header("Location: workerdash.html");
    exit();
}

// Query to fetch active assignments for the worker with additional fields
$query = "SELECT wa.id, c.description, c.complaint_type, c.sub_type, c.category, c.query, wa.assigned_at 
          FROM work_assignments wa 
          JOIN user_complaints c ON wa.complaint_id = c.id 
          WHERE wa.worker_id = $worker_id AND wa.is_completed = 0";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard</title>
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
        <h2>Current Assignments</h2>
        <p>Welcome, here are your current assignments:</p>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Assignment ID</th><th>Block Type</th><th>Block</th><th>Category</th><th>Room Number</th><th>Query</th><th>Assigned At</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['complaint_type'] . "</td>";
                echo "<td>" . $row['sub_type'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['query'] . "</td>";
                echo "<td>" . $row['assigned_at'] . "</td>";
                echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='assignment_id' value='" . $row['id'] . "'>
                            <button type='submit' name='done' class='btn btn-success'>Mark as Done</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No current assignments found.</p>";
        }

        // Link to view previous complaints
        echo "<hr>";
        echo "<a href='workprevcom.php' class='btn btn-primary'>View Previous Complaints</a>";

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
