<?php
// Database connection settings
$servername = "127.0.0.1";
$username = "cgcano";
$password = "Garvigujarat1960";
$dbname = "cgcano";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update records with completed payments
$updateQuery = "UPDATE invoices SET status = 1 WHERE status = 0 AND is_paid = 1";
$conn->query($updateQuery);

// Remove records with status 'pending' for 5 minutes or more
$currentTime = time();
$fiveMinutesAgo = $currentTime - (5 * 60);
$deleteQuery = "DELETE FROM invoices WHERE status = 0 AND created_at <= FROM_UNIXTIME($fiveMinutesAgo)";
$conn->query($deleteQuery);

// Log cron job details
$cronStatus = "Cron job executed successfully";
$logQuery = "INSERT INTO cron_logs (cron_status, created_at) VALUES ('$cronStatus', NOW())";
$conn->query($logQuery);

// Close the database connection
$conn->close();
?>
