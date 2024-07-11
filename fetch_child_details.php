<?php
include 'db.php';

if (isset($_POST['childId'])) {
    $childId = $_POST['childId'];

    // Prepare SQL to fetch child details by ID
    $sql = "SELECT * FROM child_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $childId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $childDetails = [
            'childName' => $row['childName'],
            'ageMonths' => $row['ageMonths'],
            'gender' => $row['gender'],
        ];
        echo json_encode($childDetails);
    } else {
        echo json_encode(['error' => 'Child not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
