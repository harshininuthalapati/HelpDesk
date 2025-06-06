<?php
// Database connection details
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "college";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$complaintType = $_POST['complaint-type'];
$subType = $_POST['sub-type'];
$category = $_POST['category'];
$description = $_POST['description'];
$query = $_POST['query'];

// Insert the data into the database
$sql = "INSERT INTO user_complaints (complaint_type, sub_type, category, description, query) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $complaintType, $subType, $category, $description, $query);
$stmt->execute();

// Check for errors
if ($stmt->error) {
    echo "Error: " . $stmt->error;
} else {
    echo "Complaint submitted successfully!";
}
header('Location: /admin/userdash.html');
// Close the database connection
$stmt->close();
$conn->close();
?>