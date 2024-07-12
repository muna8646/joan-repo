<?php
session_start();
include 'db.php'; // Ensure db.php is correctly included and sets up $conn

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $donorName = $_POST['donorName'];
    $donorEmail = $_POST['donorEmail'];
    $donorPhone = $_POST['donorPhone'];
    $donationCategory = $_POST['donationCategory'];
    $childrenHome = $_POST['childrenHome'];
    $managerName = $_POST['managerName']; // Get manager name from POST data
    $donationAmount = isset($_POST['donationAmount']) ? $_POST['donationAmount'] : null;
    $donationDetails = $_POST['donationDetails'];

    // Prepare SQL statement
    $sql = "INSERT INTO donations (donorName, donorEmail, donorPhone, donationCategory, childrenHome, managerName, donationAmount, donationDetails) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssds", $donorName, $donorEmail, $donorPhone, $donationCategory, $childrenHome, $managerName, $donationAmount, $donationDetails);

    // Execute statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "Donation submitted successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: some_success_page.php"); // Redirect to a success page
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
        header("Location: wellwisher.php"); // Redirect to an error page
        exit();
    }

    // Close statement
    $stmt->close();
} else {
    die("Invalid request"); // Handling if the script is accessed directly without POST data
}

// Close connection
$conn->close();
?>
