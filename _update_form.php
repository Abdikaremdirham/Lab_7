<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['metric'])) {
    // Retrieve the metric value from the GET request
    $metric = $_GET['metric'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Lab_7";
    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define a function to fetch user details from the database
    function getUser($conn, $metric)
    {
        $sql = "SELECT * FROM users WHERE metric = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $metric);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $stmt->close();
            return $user;
        } else {
            return "Error: " . $conn->error;
        }
    }

    // Retrieve user details
    $user = getUser($conn, $metric);

    // Close database connection
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Update User</title>
</head>

<body>
    <form action="update.php" method="post" class="form-control">
        <div class="container">
        <input disabled class="form-control" name="metric" value="<?php echo $user['metric']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" class="form-control" name="name" value="<?php echo $user['name']; ?>"><br>
        <label for="role">Role:</label>
        <select name="role" id="role" required class="form-control">
            <option value="">Please select</option>
            <option value="lecturer" <?php if ($user['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
            <option value="student" <?php if ($user['role'] == 'student') echo "selected"; ?>>Student</option>
        </select><br>
        <input type="submit" value="Update">
    </form></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
} else {
    echo "Metric parameter is missing.";
}
?>
