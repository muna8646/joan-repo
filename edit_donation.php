<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $donationId = $_GET['id'];
    
    // Fetch donation details from database
    $sql = "SELECT * FROM donations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donationId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $donation = $result->fetch_assoc();
        // Display edit form with current values
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Donation</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-4">
                <h1>Edit Donation</h1>
                <form action="update_donation.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $donation['id']; ?>">
                    <div class="form-group">
                        <label for="donorName">Donor Name</label>
                        <input type="text" class="form-control" id="donorName" name="donorName" value="<?php echo $donation['donorName']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="donorEmail">Email</label>
                        <input type="email" class="form-control" id="donorEmail" name="donorEmail" value="<?php echo $donation['donorEmail']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="donorPhone">Phone Number</label>
                        <input type="text" class="form-control" id="donorPhone" name="donorPhone" value="<?php echo $donation['donorPhone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="donationCategory">Donation Category</label>
                        <input type="text" class="form-control" id="donationCategory" name="donationCategory" value="<?php echo $donation['donationCategory']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="childrenHome">Children Home</label>
                        <input type="text" class="form-control" id="childrenHome" name="childrenHome" value="<?php echo $donation['childrenHome']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="donationAmount">Donation Amount</label>
                        <input type="number" class="form-control" id="donationAmount" name="donationAmount" value="<?php echo $donation['donationAmount']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="donationDetails">Donation Details</label>
                        <textarea class="form-control" id="donationDetails" name="donationDetails" required><?php echo $donation['donationDetails']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Donation</button>
                </form>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Donation not found.";
    }
} else {
    echo "Invalid request.";
}
?>
