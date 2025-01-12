<?php
session_start(); // Start the session
include 'db_config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $error_message = '';

    // Validate username and password are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        // Prepare and execute the query to check credentials
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $db_password, $role);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $db_password)) {
                // Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $role;

                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($role === 'hardware_technician' || $role === 'software_technician') {
                    header("Location: technician_dashboard.php");
                } else {
                    $error_message = "Role not recognized.";
                }
                exit; // Stop further execution after redirect
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No user found with the given username.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Login</h1>

    <!-- Display error message -->
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="" autocomplete="off">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autocomplete="off">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required autocomplete="off">

        <button type="submit">Login</button>
    </form>
</body>

</html>