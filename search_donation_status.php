<?php
// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['donorEmail'])) {
    $donorEmail = $_GET['donorEmail'];

    // Fetch donation details including email, category, and status from managerdonation table based on donorEmail
    $sql = "SELECT d.donorEmail, d.donationCategory, md.action
            FROM donations d 
            LEFT JOIN managerdonation md ON d.id = md.donationid 
            WHERE d.donorEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $donorEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        ?>
        <style>
        /* Define embedded CSS styles for table */
        .table-custom {
            width: 100%;
            margin-bottom: 1rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            overflow: hidden; /* Ensure table is responsive */
        }

        .table-custom thead {
            background-color: #343a40; /* Dark background for header */
            color: #fff; /* Light text color for header */
        }

        .table-custom th {
            padding: 0.75rem;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }

        .table-custom tbody {
            background-color: #f8f9fa; /* Lighter background for body */
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #e9ecef; /* Alternate row background color */
        }

        .table-custom td {
            padding: 0.75rem;
            vertical-align: middle; /* Center content vertically */
        }
        </style>

        <div class="container mt-4">
            <h2 class="mb-4">Donation Status for Donor Email: <?php echo htmlspecialchars($donorEmail); ?></h2>

            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Donor Email</th>
                            <th>Donation Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['donorEmail']); ?></td>
                                <td><?php echo htmlspecialchars($row['donationCategory']); ?></td>
                                <td><?php echo htmlspecialchars($row['action']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div> <!-- Close table-responsive -->

        </div> <!-- Close container -->
        <?php
    } else {
        ?>
        <div class="container mt-4">
            <p>No donation status found for donor email: <?php echo htmlspecialchars($donorEmail); ?></p>
        </div> <!-- Close container -->
        <?php
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
