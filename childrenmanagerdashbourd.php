<?php
// Ensure session is started at the beginning of your script
session_start();

// Check if the session variable is set, and handle accordingly
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Children-Home Manager</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-+fXv3nZB8eDrjbO7A7D2p7h0CuwgR7c6OvDx1KSgPEbA4c0+1y3ZdqRt1CJlO7Z3Zrw4mw3m+s7fZlUwF4d/iQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/dashboard.css">
  <!-- Additional Custom styles -->
  <style>
    .hidden-submenu {
      display: none;
    }
  </style>
</head>
<body>
  
<div class="d-flex" id="wrapper">
  
  <!-- Sidebar -->
  <div class="bg-primary border-right sidebar" id="sidebar-wrapper">
    <div class="sidebar-heading">Children-Home Manager</div>
    <div class="list-group list-group-flush">
      <button class="list-group-item list-group-item-action btn btn-primary" data-content-id="dashboard-content">Dashboard</button>
      <button class="list-group-item list-group-item-action btn btn-primary" data-content-id="children-home-form">Register</button>
      <button class="list-group-item list-group-item-action btn btn-primary" data-content-id="settings-content">Settings</button>
    </div>
  </div>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    
    <!-- Header with user profile and logout dropdown -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom header">
      <div class="ml-auto">
        <div class="profile-dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Welcome, <strong><?php echo $_SESSION['username']; ?></strong>
          </button>
          <div class="dropdown-menu dropdown-menu-right profile-dropdown-content" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="#">Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- Dashboard Content -->

    <div class="d-flex" id="wrapper">
      <div class="bg-primary border-right sidebar" id="sidebar-wrapper" direction="column">
        <div class="list-group list-group-flush" id="submenu">
          <button class="list-group-item list-group-item-action btn btn-primary" data-content-id="Children_Accounts-content">Child-Accounts</button>
          <button class="list-group-item list-group-item-action btn btn-primary" data-content-id="Donations-content">Donations</button>
          
        </div>
      </div>

      <!-- Content Sections -->
      <div id="content-sections">
        <!-- Users List -->
        

        <!-- Children Accounts -->
<div id="Children_Accounts-content" style="display: none;">
    <div class="container mt-4">
        <h1>Children Accounts</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child Name</th>
                        <th>Age (Months)</th>
                        <th>Gender</th>
                        <th>Guardian</th>
                        <th>Contact</th>
                        <th>Official's Name</th>
                        <th>Official's Contact</th>
                        <th>Official's ID</th>
                        <th>Children's Home</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    // Check if the session variable is set
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                    // Prepare SQL query to fetch children accounts where managerName matches username
                    $sql = "SELECT * FROM child_accounts WHERE managerName = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['childName'] . "</td>";
                            echo "<td>" . $row['ageMonths'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['guardianName'] . "</td>";
                            echo "<td>" . $row['contact'] . "</td>";
                            echo "<td>" . $row['governmentOfficialName'] . "</td>";
                            echo "<td>" . $row['governmentOfficialContact'] . "</td>";
                            echo "<td>" . $row['governmentOfficialId'] . "</td>";
                            echo "<td>" . $row['childrenHome'] . "</td>";
                            echo "<td>";
                            echo "<a href='progress_child.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Progress</a>";
                            echo "<a href='update_child.php?id=" . $row['id'] . "' class='btn btn-secondary btn-sm ml-2'>Update Details</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No children accounts found</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Donations -->
<div id="Donations-content" style="display: none;">
    <div class="container mt-4">
        <h1>Donations</h1>
        <form id="donationsForm" action="process_donations.php" method="post">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Donor Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Donation Category</th>
                            <th>Children Home</th>
                            <th>Receive / Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php';

                        // Check if the session variable is set
                        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                        // Prepare SQL query to fetch donations where managerName matches username
                        $sql = "SELECT * FROM donations WHERE managerName = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['donorName'] . "</td>";
                                echo "<td>" . $row['donorEmail'] . "</td>";
                                echo "<td>" . $row['donorPhone'] . "</td>";
                                echo "<td>" . $row['donationCategory'] . "</td>";
                                echo "<td>" . $row['childrenHome'] . "</td>";
                                echo "<td>";
                                echo "<label><input type='radio' name='action[" . $row['id'] . "]' value='receive'> Receive</label>";
                                echo "<label><input type='radio' name='action[" . $row['id'] . "]' value='decline'> Decline</label>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No donations found</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


        <!-- Add Children Home Form -->
<div id="children-home-form" style="display: none;">
  <h2>Register</h2>
  
</div>


        <!-- Settings Content -->
        <div id="settings-content" style="display: none;">
          <div class="container mt-4">
            <h1>Settings</h1>
            <!-- Add your settings form or content here -->
          </div>
        </div>
        
      </div>
    </div>

    <!-- Add content sections as needed -->

  </div>
  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom Script -->
<script>
  $(document).ready(function() {
    $('.list-group-item').on('click', function() {
      var contentId = $(this).data('content-id');
      
      // Hide all content sections
      $('#content-sections > div').hide();
      
      // Show the selected content section
      $('#' + contentId).show();
      
      // Hide submenu when "Add Children Home" form or "Settings" content is displayed
      if (contentId === 'children-home-form' || contentId === 'settings-content') {
        $('#submenu').addClass('hidden-submenu');
      } else {
        $('#submenu').removeClass('hidden-submenu');
      }
    });
  });
</script>
</body>
</html>
