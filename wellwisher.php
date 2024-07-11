<?php
// Ensure session is started at the beginning of your script
session_start();

// Check if the session variable is set, and handle accordingly
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

include 'db.php';

// Fetch all children homes along with their managers for the dropdown
$sql_homes = "SELECT * FROM children_homes";
$result_homes = $conn->query($sql_homes);
$homes = [];
while ($row = $result_homes->fetch_assoc()) {
    $homes[] = $row;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Well Wisher Dashboard</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-+fXv3nZB8eDrjbO7A7D2p7h0CuwgR7c6OvDx1KSgPEbA4c0+1y3ZdqRt1CJlO7Z3Zrw4mw3m+s7fZlUwF4d/iQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    body {
      display: flex;
    }
    #sidebar-wrapper {
      width: 150px;
      position: fixed;
      height: 100%;
      background-color: #007bff;
      color: #fff;
    }
    #page-content-wrapper {
      margin-left: 150px;
      width: calc(100% - 150px);
      padding: 20px;
    }
    .content {
      overflow: auto;
    }
    .content-section {
      display: none;
      padding-top: 20px;
    }
    .content-section.active {
      display: block;
    }
    .sidebar-heading {
      text-align: center;
      padding: 10px 0;
      font-size: 1.2rem;
    }
    .list-group-item {
      color: #fff;
      background-color: transparent;
      border: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .list-group-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .list-group-item.active {
      background-color: rgba(255, 255, 255, 0.1);
      font-weight: bold;
    }
    .header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      padding: 10px 20px;
    }
    .profile-dropdown .dropdown-toggle {
      color: #007bff;
      border: 1px solid #007bff;
    }
    .profile-dropdown .dropdown-menu {
      margin-top: 5px;
      min-width: 150px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 0.25rem;
    }
    .profile-dropdown .dropdown-item {
      color: #007bff;
    }
    .profile-dropdown .dropdown-item:hover {
      background-color: rgba(0, 123, 255, 0.1);
    }
    .container-fluid {
      padding-right: 0;
      padding-left: 0;
    }
    .form-group label {
      font-weight: bold;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }
  </style>
</head>
<body>
  
<div id="wrapper">
  
  <!-- Sidebar -->
  <div class="bg-primary border-right sidebar" id="sidebar-wrapper">
    <div class="sidebar-heading">Well Wisher Dashboard</div>
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action active" data-target="#dashboard-content">Dashboard</a>
      <a href="#" class="list-group-item list-group-item-action" data-target="#donation-content">Donation</a>
      <a href="#" class="list-group-item list-group-item-action" data-target="#child-account-content">Child Account</a>
      <a href="#" class="list-group-item list-group-item-action" data-target="#location-content">Add Location</a>
      <a href="#" class="list-group-item list-group-item-action" data-target="#settings-content">Settings</a>
    </div>
  </div>
  <div id="page-content-wrapper">
    
    <!-- Header with user profile and logout dropdown -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom header">
      <div class="ml-auto">
        <div class="profile-dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>
          </button>
          <div class="dropdown-menu dropdown-menu-right profile-dropdown-content" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </nav>
    <div class="container-fluid content" id="main-content">
      <div id="dashboard-content" class="content-section active">
        <h1 class="mt-4">Dashboard</h1>
        <p>Welcome to your well-wisher dashboard.</p>
        <div class="container mt-4">
          <h1>Child Progress</h1>
          <form action="search_progress.php" method="GET" class="mb-4">
            <div class="form-group">
              <label for="childName">Search by Child Name:</label>
              <input type="text" class="form-control" id="childName" name="childName" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </div>
        <div class="container mt-4">
          <h1>Donation Status</h1>
          <form action="search_donation_status.php" method="GET" class="mb-4">
            <div class="form-group">
              <label for="donorEmail">Search by Donor Email:</label>
              <input type="email" class="form-control" id="donorEmail" name="donorEmail" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </div>
      </div>

      <div id="donation-content" class="content-section">
        <div class="container">
          <div class="donation-form">
            <h2 class="form-title">Donate to Children's Home</h2>
            <form id="donationForm" action="submit_donation.php" method="post" onsubmit="showNotification('Donation form submitted!'); return true;">
              <div class="form-group">
                <label for="donorName">Your Name</label>
                <input type="text" class="form-control" id="donorName" name="donorName" required>
              </div>
              <div class="form-group">
                <label for="donorEmail">Your Email</label>
                <input type="email" class="form-control" id="donorEmail" name="donorEmail" required>
              </div>
              <div class="form-group">
                <label for="donorPhone">Your Phone Number</label>
                <input type="tel" class="form-control" id="donorPhone" name="donorPhone" required>
              </div>
              <div class="form-group">
                <label for="donationCategory">Category of Donation</label>
                <select class="form-control" id="donationCategory" name="donationCategory" required>
                  <option value="">Select Category</option>
                  <option value="Monetary">Monetary</option>
                  <option value="Food">Food</option>
                  <option value="Clothing">Clothing</option>
                  <option value="Educational Supplies">Educational Supplies</option>
                  <option value="Toys">Toys</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="form-group">
                <label for="childrenHome">Select Children's Home</label>
                <select class="form-control" id="childrenHome" name="childrenHome" required>
                  <option value="">Select Children's Home</option>
                  <?php foreach ($homes as $home): ?>
                    <option value="<?php echo htmlspecialchars($home['homeName']); ?>" data-manager="<?php echo htmlspecialchars($home['managerName']); ?>">
                      <?php echo htmlspecialchars($home['homeName']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <input type="hidden" id="managerName" name="managerName">
              </div>
              <div class="form-group">
                <label for="donationAmount">Donation Amount (if monetary)</label>
                <input type="number" class="form-control" id="donationAmount" min="0" name="donationAmount">
              </div>
              <div class="form-group">
                <label for="donationDetails">Details of Donation</label>
                <textarea class="form-control" id="donationDetails" name="donationDetails" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Submit Donation</button>
            </form>
          </div>
        </div>
      </div>

      <div id="child-account-content" class="content-section">
        <div class="container">
          <h2>Child Account</h2>
          <form id="childAccountForm" action="add_child_account.php" method="POST" onsubmit="showNotification('Child account added!'); return true;">
            <div class="form-group">
              <label for="childName">Child Name</label>
              <input type="text" class="form-control" id="childName" name="childName" required>
            </div>
            <div class="form-group">
              <label for="childAge">Child Age</label>
              <div class="d-flex">
                <input type="number" class="form-control mr-2" id="childAgeYears" name="childAgeYears" min="0" required placeholder="Years">
                <input type="number" class="form-control" id="childAgeMonths" name="childAgeMonths" min="0" max="11" required placeholder="Months">
              </div>
            </div>
            <div class="form-group">
              <label for="childGender">Gender</label>
              <select class="form-control" id="childGender" name="childGender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="guardianName">Guardian Name</label>
              <input type="text" class="form-control" id="guardianName" name="guardianName" required>
            </div>

            <!-- Government Official Details (if needed) -->
            <div class="government-official-details">
              <h3>Government Official Details</h3>
              <div class="form-group">
                <label for="governmentOfficialName">Official's Name</label>
                <input type="text" class="form-control" id="governmentOfficialName" name="governmentOfficialName" required>
              </div>
              <div class="form-group">
                <label for="governmentOfficialOccupation">Occupation</label>
                <select class="form-control" id="governmentOfficialOccupation" name="governmentOfficialOccupation" required onchange="checkOccupation()">
                  <option value="">Select Occupation</option>
                  <option value="Chief">Chief</option>
                  <option value="D O">D O</option>
                  <option value="Manager">Manager</option>
                  <option value="Officer">Officer</option>
                  <option value="Supervisor">Supervisor</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="form-group">
                <label for="governmentOfficialContact">Contact</label>
                <input type="text" class="form-control" id="governmentOfficialContact" name="governmentOfficialContact" required>
              </div>
              <div class="form-group">
                <label for="governmentOfficialId">ID</label>
                <input type="text" class="form-control" id="governmentOfficialId" name="governmentOfficialId" required>
              </div>
            </div>

            <div class="form-group">
              <label for="childrenHome">Select Children's Home</label>
              <select class="form-control" id="childrenHomeChildAccounts" name="childrenHome" required>
                <option value="">Select Children's Home</option>
                <?php foreach ($homes as $home): ?>
                  <option value="<?php echo htmlspecialchars($home['homeName']); ?>" data-manager="<?php echo htmlspecialchars($home['managerName']); ?>">
                    <?php echo htmlspecialchars($home['homeName']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <input type="hidden" id="managerNameChildAccounts" name="managerName">

            <div class="form-group">
              <label for="contact">Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Child</button>
          </form>
        </div>
      </div>

      <div id="location-content" class="content-section">
        <div class="container">
          <h2>Add Location</h2>
          <form id="locationForm" action="add_location.php" method="POST">
            <div class="form-group">
              <label for="locationName">Location Name</label>
              <input type="text" class="form-control" id="locationName" name="locationName" required>
            </div>
            <div class="form-group">
              <label for="locationAddress">Location Address</label>
              <input type="text" class="form-control" id="locationAddress" name="locationAddress" required>
            </div>
            <div class="form-group">
              <label for="latitude">Latitude</label>
              <input type="text" class="form-control" id="latitude" name="latitude">
            </div>
            <div class="form-group">
              <label for="longitude">Longitude</label>
              <input type="text" class="form-control" id="longitude" name="longitude">
            </div>
            <button type="submit" class="btn btn-primary">Add Location</button>
          </form>
        </div>
      </div>

      <div id="settings-content" class="content-section">
        <div class="container">
          <h2>Settings</h2>
          <p>Manage your settings here.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Menu Toggle Script -->
<script>
  $(document).ready(function() {
    $('.list-group-item').on('click', function(e) {
      e.preventDefault();
      $('.content-section').removeClass('active');
      var target = $(this).data('target');
      $(target).addClass('active');
    });
  });

  function showNotification(message) {
    toastr.success(message);
  }
</script>

<script>
  $(document).ready(function() {
    // Function to update managerName based on selected childrenHome
    $('#childrenHome').change(function() {
      var selectedOption = $(this).children("option:selected");
      var managerName = selectedOption.data('manager');
      $('#managerName').val(managerName);
    });

    // Trigger change event to set initial managerName if a home is already selected
    $('#childrenHome').change();
  });

  $(document).ready(function() {
    var childrenHomeSelect = document.getElementById('childrenHomeChildAccounts');
    var managerNameInput = document.getElementById('managerNameChildAccounts');

    childrenHomeSelect.addEventListener('change', function() {
      var selectedOption = childrenHomeSelect.options[childrenHomeSelect.selectedIndex];
      var managerName = selectedOption.getAttribute('data-manager');
      managerNameInput.value = managerName;
    });

    // Trigger change event to set the initial managerName if one is already selected
    childrenHomeSelect.dispatchEvent(new Event('change'));
  });
</script>

</body>
</html>
