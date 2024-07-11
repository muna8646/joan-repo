<?php
session_start();
include 'db.php'; // Ensure this file includes your database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data using POST method
  $homeName = $_POST['homeName'];
  $location = $_POST['location'];
  $capacity = $_POST['capacity'];
  $contact = $_POST['contact'];
  $managerName = $_POST['managerName']; // Manager's Name

  // Prepare SQL statement to insert data into 'children_homes' table
  $sql = "INSERT INTO children_homes (homeName, location, capacity, contact, managerName)
          VALUES (?, ?, ?, ?, ?)";

  // Use prepared statement to prevent SQL injection
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssiss", $homeName, $location, $capacity, $contact, $managerName);

  // Execute SQL query
  if ($stmt->execute()) {
    // Success message
    echo "Children home added successfully!";
    // Optionally redirect to another page after successful insertion
    // header("Location: dashboard.php");
  } else {
    // Error message
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // Close prepared statement
  $stmt->close();
}

// Close database connection
$conn->close();
?>
