<?php
session_start();
include 'db_conn.php';

$creditBalance = 0;

// Check if user is logged in and the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch total credits for the logged-in user
    // (You might need to modify this query to match your updated database structure)
    $creditsQuery = "SELECT SUM(ca.credit_amount) AS total_credits
        FROM credits_assignment ca
        JOIN user u ON ca.employees_id = u.employees_id
        WHERE u.user_id = $userId";

    $creditsResult = $conn->query($creditsQuery);

    if ($creditsResult) {
        $creditsData = $creditsResult->fetch_assoc();
        $totalCredits = $creditsData['total_credits']; // Set default to 0 if no credits found

        // Set the credit balance for the logged-in user
        $creditBalance = $totalCredits;
    } else {
        echo "Error fetching credit data: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle case where user is not logged in or user ID is not set in session
    // Redirect or display an error message
}

// Handle credit redemption for Education, Loan, Job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option'])) {
    // Assuming 'option' contains the benefit type (education, loan, job)
    $option = $_POST['option'];

    // Query the Benefits table to get credit cost for the selected option
    $benefitQuery = "SELECT credit_cost FROM Benefits WHERE benefit_name = '$option'";
    $benefitResult = $conn->query($benefitQuery);

    if ($benefitResult) {
        $benefitData = $benefitResult->fetch_assoc();
        $creditCost = $benefitData['credit_cost'];

        // Check if the user has enough credits to redeem for the selected benefit
        if ($creditBalance >= $creditCost) {
            // Update Credits_Benefits table with redemption details
            $redeemQuery = "INSERT INTO Credits_Benefits (employee_id, benefit_id, credits_redeemed) VALUES ($userId, (SELECT benefit_id FROM Benefits WHERE benefit_name = '$option'), $creditCost)";
            
            if ($conn->query($redeemQuery) === TRUE) {
                // Update user's total credits after redemption
                $updateCreditsQuery = "UPDATE credits_assignment SET credit_amount = credit_amount - $creditCost WHERE employees_id = (SELECT employees_id FROM user WHERE user_id = $userId)";
                $conn->query($updateCreditsQuery);

                // Refresh the credit balance after redemption
                // ... (Similar to the logic above to fetch and display the updated balance)
            } else {
                echo "Error redeeming credits: " . $conn->error;
            }
        } else {
            echo "Insufficient credits to redeem for $option";
        }
    } else {
        echo "Error fetching benefit details: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="redeem.css" />
    <title>OneFamilyHR - Redeem</title>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="logo.png" alt="Website Logo" class="logo-image" />
                <h1 class="site-title">OneFamilyHR</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="logout.php">Sign out</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="user-welcome" id="userWelcome">
        <h1>Redeem your Credit!</h1>
        <div class="collection">
            <section class="credit-balance">
                <h3>Credit Balance</h3>
                <h2><span id='creditBalance'>
                        <?php echo $creditBalance; ?>
                    </span></h2>
                <p>Max: 500.00</p>
        </div>
        <div class="options">
            <section class="educ">
                <h1>Education</h1>
                <form method="POST" action="redeem.php"> <!-- Modify the form to post data -->
                    <input type="hidden" name="option" value="education"> <!-- Hidden input to specify option -->
                    <button type="submit" class="btn">Redeem</button> <!-- Use a form submit button -->
                </form>
            </section>
            <section class="loadn">
                <h1>Loan</h1>
                <form method="POST" action="redeem.php"> <!-- Modify the form to post data -->
                    <input type="hidden" name="option" value="loan"> <!-- Hidden input to specify option -->
                    <button type="submit" class="btn">Redeem</button> <!-- Use a form submit button -->
                </form>
            </section>
            <section class="job">
                <h1>Job</h1>
                <form method="POST" action="redeem.php"> <!-- Modify the form to post data -->
                    <input type="hidden" name="option" value="job"> <!-- Hidden input to specify option -->
                    <button type="submit" class="btn">Redeem</button> <!-- Use a form submit button -->
                </form>
            </section>
    </div>
</body>

</html>