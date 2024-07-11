<?php
session_start(); // Start the session
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $childId = $_POST['childId'];
    $educationStatus = $_POST['educationStatus'];
    $healthStatus = $_POST['healthStatus'];
    $behavior = $_POST['behavior'];

    // Check if childId exists in child_accounts table
    $check_sql = "SELECT id FROM child_accounts WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $childId);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Prepare SQL to insert progress details into progress table
        $sql = "INSERT INTO progress (childId, educationStatus, healthStatus, behavior) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $childId, $educationStatus, $healthStatus, $behavior);

        if ($stmt->execute()) {
            // Set a success message in session
            $_SESSION['message'] = "Progress details submitted successfully.";
            $_SESSION['message_type'] = "success";
        } else {
            // Set an error message in session
            $_SESSION['message'] = "Error inserting progress: " . $stmt->error;
            $_SESSION['message_type'] = "danger";
        }

        $stmt->close();
    } else {
        // Set an error message in session
        $_SESSION['message'] = "Error: Child ID does not exist in child_accounts table.";
        $_SESSION['message_type'] = "danger";
    }

    $check_stmt->close();
    $conn->close();

    // Redirect to childrenhomemanager.php
    header("Location: childrenmanagerdashbourd.php");
    exit();
}
?>
