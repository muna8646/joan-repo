<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Progress Update</title>
    <!-- Include necessary CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Child Progress Update</h1>
        <form action="submit_progress.php" method="POST">
            <div class="form-group">
                <label for="childName">Child Name</label>
                <input type="text" class="form-control" id="childName" name="childName" readonly>
            </div>
            <div class="form-group">
                <label for="ageMonths">Age (Months)</label>
                <input type="text" class="form-control" id="ageMonths" name="ageMonths" readonly>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <input type="text" class="form-control" id="gender" name="gender" readonly>
            </div>
            <div class="form-group">
                <label for="educationStatus">Education Status</label>
                <textarea class="form-control" id="educationStatus" name="educationStatus" required></textarea>
            </div>
            <div class="form-group">
                <label for="healthStatus">Health Status</label>
                <textarea class="form-control" id="healthStatus" name="healthStatus" required></textarea>
            </div>
            <div class="form-group">
                <label for="behavior">Behavior</label>
                <textarea class="form-control" id="behavior" name="behavior" required></textarea>
            </div>
            <!-- Hidden input field to pass child ID to the processing script -->
            <input type="hidden" id="childId" name="childId">
            <button type="submit" class="btn btn-primary">Submit Progress</button>
        </form>
    </div>

    <!-- Include necessary JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript to populate form fields based on selected child from the table
        $(document).ready(function() {
            // Get child ID from URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const childId = urlParams.get('id');

            // Fetch child details using AJAX
            $.ajax({
                url: 'fetch_child_details.php',
                type: 'POST',
                data: { childId: childId },
                dataType: 'json',
                success: function(response) {
                    $('#childName').val(response.childName);
                    $('#ageMonths').val(response.ageMonths);
                    $('#gender').val(response.gender);
                    $('#childId').val(childId); // Set child ID in hidden field for form submission
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching child details');
                }
            });
        });
    </script>
</body>
</html>
