<?php
session_start();
include 'db.php'; // Ensure this file includes your database connection

// Initialize variables to store current values
$homeId = $homeName = $location = $capacity = $contact = $managerName = '';

// Check if 'id' parameter is set in GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $homeId = $_GET['id'];

    // Fetch home details from database
    $sql = "SELECT * FROM children_homes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $homeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $home = $result->fetch_assoc();
        $homeName = $home['homeName'];
        $location = $home['location'];
        $capacity = $home['capacity'];
        $contact = $home['contact'];
        $managerName = $home['managerName'];
    } else {
        echo "Home not found.";
        exit; // Exit if home ID not found
    }

    $stmt->close();
}

// Check if form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data using POST method
    $homeId = $_POST['id'];
    $homeName = $_POST['homeName'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $contact = $_POST['contact'];
    $managerName = $_POST['managerName'];

    // Prepare SQL statement to update data in 'children_homes' table
    $sql = "UPDATE children_homes SET homeName = ?, location = ?, capacity = ?, contact = ?, managerName = ? WHERE homeID = ?";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $homeName, $location, $capacity, $contact, $managerName, $homeId);

    // Execute SQL query
    if ($stmt->execute()) {
        // Success message
        echo "Children home updated successfully!";
        // Optionally redirect to another page after successful update
        // header("Location: dashboard.php");
    } else {
        // Error message
        echo "Error updating home: " . $conn->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Children Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Edit Children Home</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="homeID" value="<?php echo $homeId; ?>">
            <div class="form-group">
                <label for="homeName">Home Name</label>
                <input type="text" class="form-control" id="homeName" name="homeName" value="<?php echo $homeName; ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $capacity; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact; ?>" required>
            </div>
            <div class="form-group">
                <label for="managerName">Manager's Name</label>
                <input type="text" class="form-control" id="managerName" name="managerName" value="<?php echo $managerName; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Home</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
