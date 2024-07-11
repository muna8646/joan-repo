<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $childId = $_GET['id'];
    
    // Delete child from database
    $sql = "DELETE FROM children_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $childId);
    
    if ($stmt->execute()) {
        echo "Child deleted successfully.";
    } else {
        echo "Error deleting child: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
