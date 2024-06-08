<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Lab_7";

    // Retrieve the data from the POST request
    $metric = $_POST['metric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update user information in the database
    $sql = "UPDATE users SET name='?', role='?' WHERE metric='?'";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $name, $role, $metric);
        if ($stmt->execute()) {
            echo "User information updated successfully.";
            header('location:dashbord.php');
        } else {
            echo "Error updating user information: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}

?>