<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['homeID'])) {
    $homeId = $_POST['homeID'];
    $homeName = $_POST['homeName'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $contact = $_POST['contact'];
    
    // Update home in database
    $sql = "UPDATE children_homes SET homeName = ?, location = ?, capacity = ?, contact = ? WHERE homeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $homeName, $location, $capacity, $contact, $homeId);
    
    if ($stmt->execute()) {
        echo "Home updated successfully.";
    } else {
        echo "Error updating home: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
