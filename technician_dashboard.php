<?php
session_start();
include 'db_config.php';

// Get the username and role_id from the session
$username = $_SESSION['username'];
$role = $_SESSION['role'];

if (isset($_GET['logout'])) {
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="homepage-container">
        <div class="homepage-content">



            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>You are logged in as a Technician.</p>

            <br>
            <div class="button-group">
                <!-- Show Hardware Dashboard button for hardware technician -->
                <a href="hardware_dashboard.php"
                    class="btn btn-primary <?php echo ($role === 'hardware_technician' ? '' : 'hidden'); ?>">
                    Go to Hardware Dashboard
                </a>

                <!-- Show Software Dashboard button for software technician -->
                <a href="software_dashboard.php"
                    class="btn btn-secondary <?php echo ($role === 'software_technician' ? '' : 'hidden'); ?>">
                    Go to Software Dashboard
                </a>

                <br>
                <a href="?logout=true" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>

</body>

</html>