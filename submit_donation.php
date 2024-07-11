<?php
session_start();
include 'db.php';

// Retrieve POST data
$donorName = $_POST['donorName'];
$donorEmail = $_POST['donorEmail'];
$donorPhone = $_POST['donorPhone'];
$donationCategory = $_POST['donationCategory'];
$childrenHome = $_POST['childrenHome'];
$managerName = $_POST['managerName'];  // Get manager name from POST data
$donationAmount = isset($_POST['donationAmount']) ? $_POST['donationAmount'] : null;
$donationDetails = $_POST['donationDetails'];

// Prepare and bind
$sql = "INSERT INTO donations (donorName, donorEmail, donorPhone, donationCategory, childrenHome, managerName, donationAmount, donationDetails) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssis", $donorName, $donorEmail, $donorPhone, $donationCategory, $childrenHome, $managerName, $donationAmount, $donationDetails);

// Execute and check
if ($stmt->execute()) {
    echo "Donation submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
