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
    <link rel="stylesheet" href="home_style.css" />
    <title>OneFamilyHR - Home</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="home.js"></script>
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
        <h2>Welcome, <span id="userName">
                <?php
                echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
                ?>
            </span></h2>
        <div class="collection">
            <section class="credit-balance">
                <h3>Credit Balance</h3>
                <h2><span id='creditBalance'><?php echo $creditBalance; ?></span></h2>
                <button>Recieve Credits</button>
                <button>Redeem Credits</button>
                <p>Max: 500.00</p>
            </section>

            <section class="rewards">
                <h3>Rewards</h3>
                <ul>
                    <li>
                        <p><strong>05/17/2022 - 0.23 credits:</strong>
                            <br>Congratulations on May 17, 2022! Your hard work earned you 0.23 credits - fantastic job!
                        </p>
                    </li>
                    <li>
                        <p><strong>10/12/2022 - 0.23 credits:</strong>
                            <br>As of October 12, 2022, your sales efforts have resulted in 0.23 credits. Great
                            progress!
                        </p>
                    </li>
                    <li>
                        <p><strong>12/08/2022 - 0.23 credits:</strong>
                            <br>On December 8, 2022, you've earned 0.23 credits. Excellent work!
                        </p>
                    </li>
                </ul>
            </section>
            <section class="graph">
                <div id="line_top_x"></div>
            </section>
        </div>
    </div>
</body>

</html>