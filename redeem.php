<?php
session_start();
include 'db_conn.php';

$creditBalance = 0;

// Check if user is logged in and the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch total credits for the logged-in user
    // (You might need to modify this query to match your updated database structure)
    $creditsQuery = "SELECT total_credits 
                 FROM credit_balance 
                 WHERE employees_id = (SELECT employees_id FROM user WHERE user_id = $userId)";


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

        </div>
        <div class="options">
            <section class="credit-balance">
                <h3>Credit Balance</h3>
                <h2><span id='creditBalance'>
                        <?php echo $creditBalance; ?>
                    </span></h2>
                <p>Max: 500.00</p>
            </section>
            <section class="educ">
                <h1>Education</h1>
                <img src="educ.png" class="img_sec" style="width: 100px; height: 100px;">
                <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                    name="educ_amount" id="educ_amount" required>
                <button for="educ_amount" class="btn">Redeem</button>
            </section>
            <section class="loadn">
                <h1>Loan</h1>
                <img src="loan.png" class="img_sec" style="width: 100px; height: 100px; ">
                <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                    name="loan_amount" id="loan_amount" required>
                <button for="loan_amount" class="btn">Redeem</button>

            </section>
            <section class="job">
                <h1>Job</h1>
                <img src="job.png" class="img_sec" style="width: 95px; height: 95px;">
                <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                    name="job_amount" id="job_amount" required>
                <button for="job_amount" class="btn">Redeem</button>
            </section>
        </div>
    </div>
</body>

</html>