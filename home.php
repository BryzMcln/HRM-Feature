<?php
include 'db_conn.php';


$creditsQuery = "SELECT SUM(credit_amount) AS total_credits FROM credits_assignment WHERE employees_id = 69001";
$creditsResult = $conn->query($creditsQuery);
$creditsData = $creditsResult->fetch_assoc();
$totalCredits = $creditsData['total_credits'] ?? 0; // Set default to 0 if no credits found


$salesQuery = "SELECT SUM(sales_amount) AS total_sales FROM sales_data WHERE employees_id = 69001";
$salesResult = $conn->query($salesQuery);
$salesData = $salesResult->fetch_assoc();
$totalSales = $salesData['total_sales'] ?? 0; // Set default to 0 if no sales found

$creditBalance = $totalCredits - $totalSales;

$conn->close();
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
        session_start(); // Start the session if not already started
        echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
        ?>
            </span></h2>
        <div class="collection">
            <section class="credit-balance">
                <h3>Credit Balance</h3>
                <h2><span id='creditBalance'><?php echo $creditBalance; ?></span></h2>
                <button onclick="redeemCredits()">Redeem</button>
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