<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://cache.careers360.mobi/media/article_images/2021/7/18/Featured_Image_-_SRM_University_AP.jpg'), linear-gradient(to bottom right, #ffd700, #ff6f00);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        table {
            height : 300px;
            width : 35%;
            margin: 60px auto; /* center the table */
            background-color: rgba(255, 255, 255);
            border: 1px solid #ccc; /* add a border to the table */
            border-collapse: collapse; /* collapse the borders to avoid double borders */
        }

        th, td {
        border: 1px solid #ccc; /* add a border to the table cells */
        padding: 8px; /* add some padding to the table cells */
        text-align: left; /* left-align the text in the table cells */
        }

        th {
        background-color: #f2f2f2; /* add a light gray background color to the table headers */
        }
        h3 {
            margin: 30px auto;
            text-align: center;
            width: 35%;
            background-color: rgba(255, 255, 255); /* set the background color to a semi-transparent white */
            padding: 10px;
            border-radius: 5px;
            }
    </style>
</head>
<body>
    <h3>Worker Details</h3>
    <br/>
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

            // Execute a SQL query to fetch worker details
            $sql = "SELECT * FROM worker_worklogin";
            $result = mysqli_query($conn, $sql);

            // Display the fetched worker details
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["first_name"] . "</td>";
                    echo "<td>" . $row["last_name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No worker details found.";
            }

            // Close the database connection
            mysqli_close($conn);
        ?>
</body>
</html>