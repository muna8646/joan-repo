<?php
// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "chagua_upendo"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}

// Retrieve form data using POST method and sanitize inputs
$locationName = sanitize($conn, $_POST['locationName']);
$locationAddress = sanitize($conn, $_POST['locationAddress']);
$latitude = $_POST['latitude']; // No sanitization needed for numbers
$longitude = $_POST['longitude']; // No sanitization needed for numbers

// Prepare SQL statement with sanitized inputs to insert data into 'locations' table
$sql = "INSERT INTO locations (locationName, locationAddress, latitude, longitude)
        VALUES ('$locationName', '$locationAddress', '$latitude', '$longitude')";

// Execute SQL statement and handle result
if ($conn->query($sql) === TRUE) {
    echo "Location added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
