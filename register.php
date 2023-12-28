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

    // Check if the user exists based on provided details (e.g., first name, last name, email, contact number)
    $checkUserQuery = "SELECT idemployees, email FROM employees WHERE first_name = ? AND last_name = ? AND email = ? AND contactno = ?";
    $stmtCheck = $conn->prepare($checkUserQuery);
    $stmtCheck->bind_param("ssss", $firstName, $lastName, $email, $phoneNum);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // User exists, proceed to create a user in the 'user' table
        $employeeData = $result->fetch_assoc();
        $employeeId = $employeeData['idemployees'];
        $employeeEmail = $employeeData['email'];

        // Insert user into the 'user' table along with the fetched employee ID and email
        $insertUserQuery = "INSERT INTO user (user_id, employees_id, employee_email, username, password, created_at) VALUES (DEFAULT, ?, ?, ?, ?, NOW())";
        $stmtInsertUser = $conn->prepare($insertUserQuery);
        $stmtInsertUser->bind_param("iss", $employeeId, $employeeEmail, $firstName, $hashedPassword);
        
        if ($stmtInsertUser->execute()) {
            // User created successfully
            echo "User created successfully!";
            // Redirect to a success page or perform other actions
        } else {
            // User creation failed
            echo "User creation failed: " . $stmtInsertUser->error;
            // Handle the failure (e.g., show an error message)
        }
        
        $stmtInsertUser->close();
    } else {
        // User doesn't exist, handle the case as needed
        echo "No matching user found for registration.";
        // Redirect or display a message to guide the user
    }

    $stmtCheck->close();
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
            <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>

</html>