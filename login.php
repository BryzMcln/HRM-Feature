<?php
include 'db_conn.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare and bind the SQL statement with parameters
        $stmt = $conn->prepare("SELECT employees.email, user.username, user.password FROM employees 
                                INNER JOIN user ON employees.email = ? AND user.username = ? AND user.password = ?");
        $stmt->bind_param("sss", $email, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, update last login and redirect to dashboard or another page
            $currentTime = date('Y-m-d H:i:s');

            // Update last login time for the user
            $updateQuery = "UPDATE user SET last_login = ? WHERE username = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param("ss", $currentTime, $username);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            header("Location: home.php");
            exit();
        } else {
            // Invalid credentials
            echo "<script>alert('Invalid email, username, or password');</script>";
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

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />

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