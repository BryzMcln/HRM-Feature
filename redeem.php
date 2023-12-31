<?php
session_start();
include 'db_conn.php';

$creditBalance = 0;

// Check if user is logged in and the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch total credits for the logged-in user
    $creditsQuery = "SELECT total_credits 
                 FROM credit_balance 
                 WHERE employees_id = (SELECT employees_id FROM user WHERE user_id = $userId)";

    $creditsResult = $conn->query($creditsQuery);

    if ($creditsResult) {
        $creditsData = $creditsResult->fetch_assoc();
        $totalCredits = $creditsData['total_credits'];

        $creditBalance = $totalCredits;
    } else {
        echo "Error fetching credit data: " . $conn->error;
    }

    $conn->close();
} else {
    // Handle case where user is not logged in or user ID is not set in session
    // Redirect or display an error message
}

// Handle form submission for credit redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['option']) && isset($_POST['credit_amount'])) {
        $option = $_POST['option'];
        $amount = $_POST['credit_amount'];

        $employeesQuery = "SELECT employees_id FROM user WHERE user_id = $userId";
        $employeesResult = $conn->query($employeesQuery);

        if ($employeesResult) {
            $employeeData = $employeesResult->fetch_assoc();
            $employeeId = $employeeData['employees_id'];

            $reason = ''; // Set default reason
            // Assign reason based on the selected option
            if ($option === 'education') {
                $reason = 'Education expense';
            } elseif ($option === 'loan') {
                $reason = 'Loan payment';
            } elseif ($option === 'job') {
                $reason = 'Job-related expense';
            }

            // Insert into credits_assignment table
            $insertQuery = "INSERT INTO credits_assignment (employees_id, assigned_by_id, reason, credit_amount, date_assigned)
                            VALUES ($employeeId, 0, '$reason', $amount, CURRENT_DATE)";

            if ($conn->query($insertQuery) === TRUE) {
                // Update credit_balance table
                $updateQuery = "UPDATE credit_balance
                                SET total_credits = total_credits - $amount
                                WHERE employees_id = $employeeId";

                if ($conn->query($updateQuery) === FALSE) {
                    echo "Error updating credit balance: " . $conn->error;
                }
            } else {
                echo "Error inserting credits assignment: " . $conn->error;
            }
        }
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
    <script>
        // The redeemCredits function needs to pass the entered credit amount
        function redeemCredits(option) {
            let creditsToRedeem = document.getElementById(`${option}_amount`).value; // Get the entered credit amount

            let xhr = new XMLHttpRequest();
            let url = 'redeem.php'; // Update this URL to the same PHP file handling the form submission

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(`Credits redeemed successfully for ${option}`);
                        // Handle success - update UI or show a success message
                    } else {
                        console.error('Redemption failed');
                        // Handle failure - display an error message or take appropriate action
                    }
                }
            };

            // Send the request with the chosen option and entered credit amount
            xhr.send(`option=${option}&credit_amount=${creditsToRedeem}`);
        }
    </script>
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
                <form method="POST" action="redeem.php"> <!-- Form for Education -->
                    <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                        name="educ_amount" id="educ_amount" required>
                    <button type="submit" name="option" value="education" class="btn">Redeem</button>
                </form>
            </section>
            <section class="loadn">
                <h1>Loan</h1>
                <img src="loan.png" class="img_sec" style="width: 100px; height: 100px; ">
                <form method="POST" action="redeem.php"> <!-- Form for Loan -->
                    <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                        name="loan_amount" id="loan_amount" required>
                    <button type="submit" name="option" value="loan" class="btn">Redeem</button>
                </form>
            </section>
            <section class="job">
                <h1>Job</h1>
                <img src="job.png" class="img_sec" style="width: 95px; height: 95px;">
                <form method="POST" action="redeem.php"> <!-- Form for Job -->
                    <input type="number" min="1" max="500" placeholder="Enter credit amount" class="input_amount"
                        name="job_amount" id="job_amount" required>
                    <button type="submit" name="option" value="job" class="btn">Redeem</button>
                </form>
            </section>

        </div>
    </div>
</body>

</html>