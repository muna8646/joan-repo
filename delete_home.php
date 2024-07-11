<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $homeId = $_GET['id'];
    
    // Delete home from database
    $sql = "DELETE FROM children_homes WHERE homeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $homeId);
    
    if ($stmt->execute()) {
        echo "Home deleted successfully.";
    } else {
        echo "Error deleting home: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
