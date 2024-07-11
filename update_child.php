<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $childId = $_POST['id'];
    $childName = $_POST['childName'];
    $ageMonths = $_POST['ageMonths'];
    $gender = $_POST['gender'];
    $guardianName = $_POST['guardianName'];
    $contact = $_POST['contact'];
    
    // Update child in database
    $sql = "UPDATE children_accounts SET childName = ?, ageMonths = ?, gender = ?, guardianName = ?, contact = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $childName, $ageMonths, $gender, $guardianName, $contact, $childId);
    
    if ($stmt->execute()) {
        echo "Child updated successfully.";
    } else {
        echo "Error updating child: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
