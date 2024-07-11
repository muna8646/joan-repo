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
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-+fXv3nZB8eDrjbO7A7D2p7h0CuwgR7c6OvDx1KSgPEbA4c0+1y3ZdqRt1CJlO7Z3Zrw4mw3m+s7fZlUwF4d/iQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
  
<div class="d-flex" id="wrapper">
  
  <!-- Sidebar -->
  <div class="bg-primary border-right sidebar" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin Dashboard</div>
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action" data-content-id="dashboard-content">Dashboard</a>
      <a href="#" class="list-group-item list-group-item-action" data-content-id="children-home-form">Add Children Home</a>
      <a href="#" class="list-group-item list-group-item-action" data-content-id="settings-content">Settings</a>
    </div>
  </div>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    
    <!-- Header with user profile and logout dropdown -->
    <!-- Header with user profile and logout dropdown -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom header">
  <div class="ml-auto">
    <div class="profile-dropdown">
      <button class="btn btn-outline-secondary dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Welcome, <strong><?php echo $_SESSION['username']; ?></strong>
      </button>
      <div class="dropdown-menu dropdown-menu-right profile-dropdown-content" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</nav>


    <div class="container-fluid content">
      <!-- Dashboard Content -->
      <div id="dashboard-content">
        <h1 class="mt-4"> <p>Welcome to your admin dashboard.</p></h1>     
       <!-- Users List -->
        <div class="container mt-4">
        <h1>Data Management</h1>
        
        <!-- Users List Button -->
        <button class="btn btn-info mb-2" type="button" data-toggle="collapse" data-target="#usersList" aria-expanded="false" aria-controls="usersList">
            Users List
        </button>
        
        <!-- Users List Table -->
        <div class="collapse" id="usersList">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php';
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['role'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                                echo "<a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm ml-2' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Children Accounts Button -->
        <button class="btn btn-info mb-2" type="button" data-toggle="collapse" data-target="#childrenAccounts" aria-expanded="false" aria-controls="childrenAccounts">
            Children Accounts
        </button>
        
        <!-- Children Accounts Table -->
        <div class="collapse" id="childrenAccounts">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php';
                        $sql = "SELECT * FROM child_accounts";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['childName'] . "</td>";
                                echo "<td>" . $row['ageMonths'] . "</td>";
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "<td>" . $row['guardianName'] . "</td>";
                                echo "<td>" . $row['contact'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_child.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                                echo "<a href='delete_child.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm ml-2' onclick='return confirm(\"Are you sure you want to delete this child?\");'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No children accounts found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div> <!-- Donations Button -->
        <button class="btn btn-info mb-2" type="button" data-toggle="collapse" data-target="#donations" aria-expanded="false" aria-controls="donations">
            Donations
        </button>
        
        <!-- Donations Table -->
        <div class="collapse" id="donations">
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
                            <th>Donation Amount</th>
                            <th>Donation Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php';
                        $sql = "SELECT * FROM donations";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['donorName'] . "</td>";
                                echo "<td>" . $row['donorEmail'] . "</td>";
                                echo "<td>" . $row['donorPhone'] . "</td>";
                                echo "<td>" . $row['donationCategory'] . "</td>";
                                echo "<td>" . $row['childrenHome'] . "</td>";
                                echo "<td>" . $row['donationAmount'] . "</td>";
                                echo "<td>" . $row['donationDetails'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_donation.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                                echo "<a href='delete_donation.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm ml-2' onclick='return confirm(\"Are you sure you want to delete this donation?\");'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No donations found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <button class="btn btn-info mb-2" type="button" data-toggle="collapse" data-target="#childrenHomes" aria-expanded="false" aria-controls="childrenHomes">
            Children Homes
        </button>
        
        <!-- Children Homes Table -->
        <div class="collapse" id="childrenHomes">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Home ID</th>
                            <th>Home Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
              <tbody>
                <?php
                include 'db.php';

                $sql = "SELECT * FROM children_homes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['homeName'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['capacity'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_home.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                    echo "<a href='delete_home.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm ml-2' onclick='return confirm(\"Are you sure you want to delete this home?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='6'>No children homes found</td></tr>";
                }

                $conn->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        </div>

        
      </div>

      <!-- Add Children Home Form -->
<div id="children-home-form" style="display: none;">
  <h2>Add Children Home</h2>
  <form action="add_children_home.php" method="POST">
    <div class="form-group">
      <label for="homeName">Home Name</label>
      <input type="text" class="form-control" id="homeName" name="homeName" required>
    </div>
    <div class="form-group">
      <label for="location">Location</label>
      <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <div class="form-group">
      <label for="capacity">Capacity</label>
      <input type="number" class="form-control" id="capacity" name="capacity" required>
    </div>
    <div class="form-group">
      <label for="contact">Contact</label>
      <input type="text" class="form-control" id="contact" name="contact" required>
    </div>
    <div class="form-group">
      <label for="managerName">Manager's Name</label>
      <input type="text" class="form-control" id="managerName" name="managerName" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Home</button>
  </form>
</div>

      <!-- Settings Content -->
      <div id="settings-content" style="display: none;">
        <h2>Settings</h2>
        <p>Settings content goes here.</p>
      </div>
    </div>

  </div>
  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  // Function to show only the selected content
  function showContent(contentId) {
    // Hide all content sections
    $("#dashboard-content").hide();
    $("#children-home-form").hide();
    $("#managed-account-content").hide();
    $("#settings-content").hide();

    // Show the selected content section
    $("#" + contentId).show();
  }

  // Show dashboard content by default
  $(document).ready(function() {
    showContent("dashboard-content");

    // Attach click event handlers for each link
    $(".list-group-item-action").click(function(e) {
      e.preventDefault();
      var contentId = $(this).data("content-id");
      showContent(contentId);
    });
  });
</script>

</body>
</html>
