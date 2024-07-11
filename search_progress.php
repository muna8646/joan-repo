<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Progress Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'db.php';

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $childName = $_GET['childName'];

            // Fetch child details from child_accounts table based on childName
            $sql_child = "SELECT * FROM child_accounts WHERE childName LIKE ?";
            $stmt_child = $conn->prepare($sql_child);
            $stmt_child->bind_param("s", $childName);
            $stmt_child->execute();
            $result_child = $stmt_child->get_result();

            if ($result_child->num_rows > 0) {
                // Fetch progress details from progress table based on childName
                $sql_progress = "SELECT p.*, c.id AS childId FROM progress p INNER JOIN child_accounts c ON p.childId = c.id WHERE c.childName LIKE ?";
                $stmt_progress = $conn->prepare($sql_progress);
                $stmt_progress->bind_param("s", $childName);
                $stmt_progress->execute();
                $result_progress = $stmt_progress->get_result();

                if ($result_progress->num_rows > 0) {
                    // Display child details
                    echo "<h1>Child Details</h1>";
                    echo "<div class='table-responsive'>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Child Name</th>";
                    echo "<th>Age (Months)</th>";
                    echo "<th>Gender</th>";
                    echo "<th>Guardian</th>";
                    echo "<th>Contact</th>";
                    echo "<th>Official's Name</th>";
                    echo "<th>Official's Contact</th>";
                    echo "<th>Official's ID</th>";
                    echo "<th>Children's Home</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row_child = $result_child->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_child['id'] . "</td>";
                        echo "<td>" . $row_child['childName'] . "</td>";
                        echo "<td>" . $row_child['ageMonths'] . "</td>";
                        echo "<td>" . $row_child['gender'] . "</td>";
                        echo "<td>" . $row_child['guardianName'] . "</td>";
                        echo "<td>" . $row_child['contact'] . "</td>";
                        echo "<td>" . $row_child['governmentOfficialName'] . "</td>";
                        echo "<td>" . $row_child['governmentOfficialContact'] . "</td>";
                        echo "<td>" . $row_child['governmentOfficialId'] . "</td>";
                        echo "<td>" . $row_child['childrenHome'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";

                    // Display progress details
                    echo "<h1>Progress Details</h1>";
                    echo "<div class='table-responsive'>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Education Status</th>";
                    echo "<th>Health Status</th>";
                    echo "<th>Behavior</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row_progress = $result_progress->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_progress['educationStatus'] . "</td>";
                        echo "<td>" . $row_progress['healthStatus'] . "</td>";
                        echo "<td>" . $row_progress['behavior'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No progress records found for the child.</p>";
                }

                // Close prepared statements
                $stmt_progress->close();
            } else {
                echo "<p>No child found with the given name.</p>";
            }

            // Close prepared statements and database connection
            $stmt_child->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
