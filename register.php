<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    include 'db_conn.php'; // Include your database connection file

    // Collect user input
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone_num'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Prepare and execute SQL query to insert data into the employees table
    $sql = "INSERT INTO employees (first_name, last_name, email, contactno, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the query
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNum, $hashedPassword);

    // Execute the query
    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
        // Redirect to a success page or perform other actions
    } else {
        // Registration failed
        echo "Registration failed: " . $stmt->error;
        // Handle the failure (e.g., show an error message)
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="register_style.css" />
    <script src="reg_js.js"></script>
    <title>Register</title>
</head>

<body>
    <div class="register-container">
        <form action="" method="post" class="register-form">
            <h1 class="head-title">Register</h1>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required />

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />

            <label for="phone_num">Phone Number:</label>
            <input type="text" id="phone_num" name="phone_num" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required />

            <button type="submit" name="submit">Register</button>
            <p class="login-link">Already have an account? <a href="login.html">Login here</a></p>
        </form>
    </div>
</body>

</html>