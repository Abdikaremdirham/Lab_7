<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $metric = $_POST['metric'];
    $Username = $_POST['name'];
    $Password = $_POST['password'];
    $role = $_POST['role'];

    // SQL to insert user into database
    $sql = "INSERT INTO users (metric, name, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $metric, $Username, $Password, $role);

    if ($stmt->execute() === TRUE) {
        header("Location: dashbord.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container d-flex m-4 fs-2 flex-row justify-content-center">
      <form action="registration.php" method="post">
          <label for="metric">Metric No</label>
          <input type="text" class="form-control" placeholder="Insert your metric" name="metric" required>
          <label for="name">Name</label>
          <input type="text" class="form-control" placeholder="Insert your name" name="name" required>
          <label for="password">Password</label>
          <input type="password" class="form-control" placeholder="Insert your password" name="password" required>
          <label for="role">Role</label>
          <select class="form-select" name="role" required>
              <option value="student">Student</option>
              <option value="lecturer">Lecturer</option>
          </select>
          <button class="btn btn-primary mt-3" type="submit">Submit</button>
          <p><a href="login.php">login</a> here if you have account.</p>
      </form>
    </div>

    <?php
    if (isset($error_message)) {
        echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
