<?php
// Database connection settings
$servername = "127.0.0.1";
$username = "cgcano";
$password = "Garvigujarat1960";
$dbname = "cgcano";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update records with completed payments
    $invoiceTicketQuery = "UPDATE invoice_ticket SET status = 1 WHERE status = 0 AND is_paid = 1";
    $invoiceComboQuery = "UPDATE invoice_combo SET status = 1 WHERE status = 0 AND is_paid = 1";
    $invoicePackageQuery = "UPDATE invoice_packages SET status = 1 WHERE status = 0 AND is_paid = 1";


    // Remove records with status 'pending' for 5 minutes or more
    $currentTime = time();
    $fiveMinutesAgo = $currentTime - (5 * 60);
    $deleteTicket = "DELETE FROM invoice_ticket WHERE status = 0 AND created_at <= FROM_UNIXTIME($fiveMinutesAgo)";
    $deleteCombo = "DELETE FROM invoice_combo WHERE status = 0 AND created_at <= FROM_UNIXTIME($fiveMinutesAgo)";
    $deletePackage = "DELETE FROM invoice_packages WHERE status = 0 AND created_at <= FROM_UNIXTIME($fiveMinutesAgo)";
    $conn->query($invoiceTicketQuery);
    $conn->query($invoiceComboQuery);
    $conn->query($invoicePackageQuery);
    $conn->query($deleteTicket);
    $conn->query($deleteCombo);
    $conn->query($deletePackage);
} catch (Exception $e) {
    // Log cron job details
    $cronStatus = $e->getMessage();
    $logQuery = "INSERT INTO cron_logs (cron_status, created_at) VALUES ('$cronStatus', NOW())";
    $conn->query($logQuery);
} finally {
    // Close the database connection
    $conn->close();
}
?>
