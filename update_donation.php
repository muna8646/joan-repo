<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $donationId = $_POST['id'];
    $donorName = $_POST['donorName'];
    $donorEmail = $_POST['donorEmail'];
    $donorPhone = $_POST['donorPhone'];
    $donationCategory = $_POST['donationCategory'];
    $childrenHome = $_POST['childrenHome'];
    $donationAmount = $_POST['donationAmount'];
    $donationDetails = $_POST['donationDetails'];
    
    // Update donation in database
    $sql = "UPDATE donations SET donorName = ?, donorEmail = ?, donorPhone = ?, donationCategory = ?, childrenHome = ?, donationAmount = ?, donationDetails = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdsi", $donorName, $donorEmail, $donorPhone, $donationCategory, $childrenHome, $donationAmount, $donationDetails, $donationId);
    
    if ($stmt->execute()) {
        echo "Donation updated successfully.";
    } else {
        echo "Error updating donation: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
