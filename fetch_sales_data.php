<?php
session_start();

// Check if user is logged in and retrieve the user ID
if (!isset($_SESSION['user_id'])) {
    // Handle the case if the user is not logged in
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

// Include your database connection file
include 'db_conn.php';

// Fetch sales data for the logged-in user
$userId = $_SESSION['user_id'];

$salesData = array();

// SQL query to retrieve sales data for the specific user by month
$query = "SELECT u.user_id, MONTH(sd.sales_date) AS month, SUM(sd.sales_amount) AS total_sales
          FROM sales_data sd
          INNER JOIN employees e ON sd.employees_id = e.idemployees
          INNER JOIN user u ON e.idemployees = u.employees_id
          WHERE u.user_id = $userId
          GROUP BY u.user_id, MONTH(sd.sales_date)
          ORDER BY u.user_id, MONTH(sd.sales_date)";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = $row['month'];
        $totalSales = (float)$row['total_sales'];

        // Storing sales data in an associative array with month as key
        $salesData[$month] = $totalSales;
    }
}

// Close the database connection
$conn->close();

// Send the sales data as JSON
header('Content-Type: application/json');
echo json_encode($salesData);
?>
