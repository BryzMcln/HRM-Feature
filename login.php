<?php
include 'db_conn.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare and bind the SQL statement with parameters
        $stmt = $conn->prepare("SELECT * FROM user WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, redirect to dashboard or another page
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid credentials
            echo "<script>alert('Invalid email or password');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="log_style.css" />
    <title>OneFamilyHRM-Login</title>
</head>

<body>
    <div class="login-container">
        <form action="" method="post" class="login-form">
            <h1>Login</h1>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <button type="submit" name="submit">Log In</button>
            <p class="register-link">
                Don't have an account? <a href="register.php">Register now!</a>
            </p>
        </form>
    </div>
</body>

</html>