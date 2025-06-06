<?php
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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
// Check if email already exists
    $sql = "SELECT * FROM admin_adminlogin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'Email already exists.';
        exit;
    }
    // Insert user into the database
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin_adminlogin (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
    $stmt->execute();

    // Redirect to login page
    
    if ($result) 
        { 
            echo "<script>alert('Successfully registered!'); </script>"; 
            echo "<script>setTimeout(function(){ window.location.href = 'adminlogin.html'; }, 700);</script>"; 
        } 
        else { echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>"; 
        }   
    exit;
?>