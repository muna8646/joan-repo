<?php
session_start();
include 'db.php'; // connection to the db

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['formType'])) {
        if ($_POST['formType'] == 'login') {
            $email = validateInput($_POST['email']);
            $password = validateInput($_POST['password']);
            
            // Validate login
            $sql = "SELECT users.*, children_homes.managerName FROM users
                    LEFT JOIN children_homes ON users.username = children_homes.managerName
                    WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password_hash'])) {
                    // Login successful
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $user['username']; // Store username in session
                    $_SESSION['role'] = $user['role']; // Store role in session
                    
                    // Check if the user is a manager
                    if (!is_null($user['managerName'])) {
                        $_SESSION['is_manager'] = true;
                        header("Location: childrenmanagerdashbourd.php");
                    } else {
                        // Redirect based on role
                        switch ($user['role']) {
                            case 'admin':
                                header("Location: dashbourd.php");
                                break;
                            case 'wellwisher':
                                header("Location: wellwisher.php");
                                break;
                            default:
                                // Handle unexpected roles here
                                break;
                        }
                    }
                    exit;
                } else {
                    echo "<script>alert('Invalid password.');</script>";
                }
            } else {
                echo "<script>alert('No user found with this email.');</script>";
            }
            
        } elseif ($_POST['formType'] == 'createAccount') {
            $username = validateInput($_POST['username']);
            $email = validateInput($_POST['email']);
            $password = validateInput($_POST['password']);
            $confirmPassword = validateInput($_POST['confirmPassword']);
            
            if ($password != $confirmPassword) {
                die("<script>alert('Passwords do not match.');</script>");
            }

            $passwordHash = hashPassword($password);
            
            // Insert new user with default role 'wellwisher'
            $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, 'wellwisher')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $passwordHash);
            
            if ($stmt->execute()) {
                // Account created successfully
                echo "<script>alert('Account created successfully!'); window.location.href = 'login.html';</script>";
                exit;
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
}
?>
