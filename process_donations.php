<?php
session_start(); // Start the session
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actions = $_POST['action'];

    foreach ($actions as $donationId => $action) {
        // Fetch donation details from the donations table
        $sql = "SELECT * FROM donations WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $donationId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $donation = $result->fetch_assoc();

            // Prepare SQL to insert or update the managerdonation table
            $sql = "INSERT INTO managerdonation (donationId, action) VALUES (?, ?) ON DUPLICATE KEY UPDATE action = VALUES(action)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $donationId, $action);

            if ($stmt->execute()) {
                // Set a success message in session
                $_SESSION['message'] = "Donations processed successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                // Set an error message in session
                $_SESSION['message'] = "Error processing donation ID $donationId: " . $stmt->error;
                $_SESSION['message_type'] = "danger";
            }

            $stmt->close();
        } else {
            // Set an error message in session
            $_SESSION['message'] = "Error: Donation ID $donationId does not exist in donations table.";
            $_SESSION['message_type'] = "danger";
        }
    }

    $conn->close();

    // Redirect to the dashboard page
    header("Location: childrenmanagerdashbourd.php");
    exit();
}
?>
