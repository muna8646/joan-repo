<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $donationId = $_GET['id'];
    
    // Delete donation from database
    $sql = "DELETE FROM donations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donationId);
    
    if ($stmt->execute()) {
        echo "Donation deleted successfully.";
    } else {
        echo "Error deleting donation: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
