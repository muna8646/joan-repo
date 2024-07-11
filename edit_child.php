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

// Check if 'id' parameter is set in GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $childAccountId = $_GET['id'];

    // Fetch child account details from database
    $sql = "SELECT * FROM children_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $childAccountId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $childAccount = $result->fetch_assoc();

        // Display edit form with current values
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Child Account</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-4">
                <h1>Edit Child Account</h1>
                <form action="update_child_account.php" method="POST">
                    <input type="hidden" name="childAccountId" value="<?php echo $childAccount['id']; ?>">
                    <div class="form-group">
                        <label for="childName">Child Name</label>
                        <input type="text" class="form-control" id="childName" name="childName" value="<?php echo $childAccount['childName']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="childAge">Child Age</label>
                        <div class="d-flex">
                            <?php
                            $years = floor($childAccount['ageMonths'] / 12);
                            $months = $childAccount['ageMonths'] % 12;
                            ?>
                            <input type="number" class="form-control mr-2" id="childAgeYears" name="childAgeYears" value="<?php echo $years; ?>" min="0" required placeholder="Years">
                            <input type="number" class="form-control" id="childAgeMonths" name="childAgeMonths" value="<?php echo $months; ?>" min="0" max="11" required placeholder="Months">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="childGender">Gender</label>
                        <select class="form-control" id="childGender" name="childGender" required>
                            <option value="Male" <?php if ($childAccount['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($childAccount['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if ($childAccount['gender'] === 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guardianName">Guardian Name</label>
                        <input type="text" class="form-control" id="guardianName" name="guardianName" value="<?php echo $childAccount['guardianName']; ?>" required>
                    </div>

                    <!-- Government Official Details Box -->
                    <div class="government-official-details">
                        <h3>Government Official Details</h3>
                        <div class="form-group">
                            <label for="governmentOfficialName">Official's Name</label>
                            <input type="text" class="form-control" id="governmentOfficialName" name="governmentOfficialName" value="<?php echo $childAccount['governmentOfficialName']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="governmentOfficialOccupation">Occupation</label>
                            <select class="form-control" id="governmentOfficialOccupation" name="governmentOfficialOccupation" required onchange="checkOccupation()">
                                <option value="Chief" <?php if ($childAccount['governmentOfficialOccupation'] === 'Chief') echo 'selected'; ?>>Chief</option>
                                <option value="D O" <?php if ($childAccount['governmentOfficialOccupation'] === 'D O') echo 'selected'; ?>>D O</option>
                                <option value="Manager" <?php if ($childAccount['governmentOfficialOccupation'] === 'Manager') echo 'selected'; ?>>Manager</option>
                                <option value="Officer" <?php if ($childAccount['governmentOfficialOccupation'] === 'Officer') echo 'selected'; ?>>Officer</option>
                                <option value="Supervisor" <?php if ($childAccount['governmentOfficialOccupation'] === 'Supervisor') echo 'selected'; ?>>Supervisor</option>
                                <option value="Other" <?php if ($childAccount['governmentOfficialOccupation'] === 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group" id="otherOccupation" style="<?php echo ($childAccount['governmentOfficialOccupation'] === 'Other') ? 'display: block;' : 'display: none;'; ?>">
                            <label for="governmentOfficialOccupationOther">Specify Occupation</label>
                            <input type="text" class="form-control" id="governmentOfficialOccupationOther" name="governmentOfficialOccupationOther" value="<?php echo $childAccount['governmentOfficialOccupation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="governmentOfficialContact">Contact</label>
                            <input type="text" class="form-control" id="governmentOfficialContact" name="governmentOfficialContact" value="<?php echo $childAccount['governmentOfficialContact']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="governmentOfficialId">ID</label>
                            <input type="text" class="form-control" id="governmentOfficialId" name="governmentOfficialId" value="<?php echo $childAccount['governmentOfficialId']; ?>" required>
                        </div>
                    </div>
                    <!-- End Government Official Details Box -->

                    <div class="form-group">
                        <label for="childrenHome">Select Children's Home</label>
                        <select class="form-control" id="childrenHome" name="childrenHome" required>
                            <!-- Replace with PHP loop to populate options -->
                            <?php
                            $homes = array("Home A", "Home B", "Home C"); // Example array of homes
                            foreach ($homes as $home) {
                                $selected = ($childAccount['childrenHome'] === $home) ? 'selected' : '';
                                echo "<option value='$home' $selected>$home</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $childAccount['contact']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Child Account</button>
                </form>
            </div>
            <script>
                function checkOccupation() {
                    var occupation = document.getElementById("governmentOfficialOccupation").value;
                    var otherOccupation = document.getElementById("otherOccupation");
                    if (occupation === "Other") {
                        otherOccupation.style.display = "block";
                        document.getElementById("governmentOfficialOccupationOther").setAttribute("required", "required");
                    } else {
                        otherOccupation.style.display = "none";
                        document.getElementById("governmentOfficialOccupationOther").removeAttribute("required");
                        document.getElementById("governmentOfficialOccupationOther").value = "";
                    }
                }
                checkOccupation(); // Call initially to set display based on current value
            </script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Child account not found.";
    }
} else {
    echo "Invalid request.";
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
