<?php
    session_start();
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "college";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "hi";
    // Validate user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists in the database
    $sql = "SELECT * FROM admin_adminlogin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo 'User not found.';
        exit;
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        echo 'Incorrect password.';
        exit;
    }

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];

    // Redirect to admin.html
    header('Location: /see.html');
    exit;
?>