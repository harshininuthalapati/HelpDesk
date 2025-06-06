<?php
session_start();

// Database connection details
$db_hostname = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "college";

// Create a new database connection
$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);

// Check if the connection was successful
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}

// Get the complaint ID and worker ID from the form
$complaint_id = $_POST['complaint_id'];
$worker_id = $_POST['worker_id'];

// Insert the assignment into the database
$sql_assign = "INSERT INTO work_assignments (complaint_id, worker_id, status) VALUES (?, ?, 'Assigned')";
$stmt = $conn->prepare($sql_assign);
$stmt->bind_param("ii", $complaint_id, $worker_id);

if ($stmt->execute()) {
    echo "Complaint ID $complaint_id successfully assigned to Worker ID $worker_id.";
} else {
    echo "Error assigning worker: " . $conn->error;
}

// Close the database connection
$conn->close();

// Redirect to the complaints page or worker dashboard
header("Location: /see.html");
exit;
?>
