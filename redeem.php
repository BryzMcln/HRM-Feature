<?php
session_start();
include 'db_conn.php';

$creditBalance = 0; 
// Check if user is logged in and the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch total credits for the logged-in user
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
                <a href="redeem.php" class="redeem_bt"><button>Redeem</button></a>
                <p>Max: 500.00</p>
            </section>
            <section class="educ">
                <h1>Education</h1>
            </section>
            <section class="loadn">
                <h1>Loan</h1>
            </section>
            <section class="Health Care">
                <h1>Job</h1>
            </section>
        </div>
    </div>
</body>

</html>