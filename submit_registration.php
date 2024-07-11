<?php
// Assuming your database connection is established
$conn = new mysqli('localhost', 'root', '', 'chagua_upendo');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $childName = $_POST['childName'];
    $childDOB = $_POST['childDOB'];
    $childGender = $_POST['childGender'];
    $guardianName = $_POST['guardianName'];
    $guardianPhone = $_POST['guardianPhone'];
    $guardianEmail = $_POST['guardianEmail'];
    $relationship = $_POST['relationship'];
    $address = $_POST['address'];

    // Insert into database
    $sql = "INSERT INTO children_registration (childName, childDOB, childGender, guardianName, guardianPhone, guardianEmail, relationship, address) 
            VALUES ('$childName', '$childDOB', '$childGender', '$guardianName', '$guardianPhone', '$guardianEmail', '$relationship', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Redirect or display success message as needed
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
