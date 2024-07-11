<?php
session_start();
include 'db.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $childName = $_POST['childName'];
    $childAgeYears = $_POST['childAgeYears'];
    $childAgeMonths = $_POST['childAgeMonths'];
    $childGender = $_POST['childGender'];
    $guardianName = $_POST['guardianName'];
    $governmentOfficialName = $_POST['governmentOfficialName'];
    $governmentOfficialOccupation = $_POST['governmentOfficialOccupation'];
    $governmentOfficialContact = $_POST['governmentOfficialContact'];
    $governmentOfficialId = $_POST['governmentOfficialId'];
    $childrenHome = $_POST['childrenHome'];
    $managerName = $_POST['managerName'];
    $contact = $_POST['contact'];

    // Calculate age in months
    $ageMonths = ($childAgeYears * 12) + $childAgeMonths;

    // Prepare SQL statement to insert into child_accounts table
    $sql = "INSERT INTO child_accounts (childName, ageMonths, gender, guardianName, governmentOfficialName, governmentOfficialOccupation, governmentOfficialContact, governmentOfficialId, childrenHome, managerName, contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssssssss", $childName, $ageMonths, $childGender, $guardianName, $governmentOfficialName, $governmentOfficialOccupation, $governmentOfficialContact, $governmentOfficialId, $childrenHome, $managerName, $contact);

    // Execute prepared statement
    if ($stmt->execute()) {
        echo "Child account added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
