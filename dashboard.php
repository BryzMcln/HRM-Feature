<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="home_style.css" />
    <title>OneFamilyHR - Home</title>
    <script>
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2004', 1000, 400],
                ['2005', 1170, 460],
                ['2006', 660, 1120],
                ['2007', 1030, 540]
            ]);

            var options = {
                title: 'Company Performance',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
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
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="user-welcome" id="userWelcome">
        <h2>Welcome, <span id="userName">
                <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest'; ?>
            </span></h2> <!-- Displaying the user's name or 'Guest' -->
        <div class="collection">
            <section class="credit-balance">
                <h3>Credit Balance</h3>
                <p>Credits:</p>
                <h1>305.75</h1>
                <button>View Details</button>
                <button>Redeem</button>
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
            <section>
                <div id="curve_chart" style="width: 900px; height: 500px"></div>
            </section>
        </div>
    </div>
</body>

</html>