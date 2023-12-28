<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement with parameters for username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();
            $storedPassword = $user['password'];

            // Verify the password
            if (password_verify($password, $storedPassword)) {
                session_start(); // Start the session
                $_SESSION['user_id'] = $user['user_id']; // Set the user_id in the session
                // Other session variables or settings can be added as needed
                // Redirect to dashboard or another page
                header("Location: home.php");
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            // Invalid username
            echo "<script>alert('Invalid username');</script>";
        }
    } else {
        // Error in execution
        echo "Query Execution Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
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

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />

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