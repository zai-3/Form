<?php
include 'db_config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    $role = trim($_POST['role']);
    $technician_type = $_POST['technician_type'] ?? null;

    $error_message = '';

    // Password validation
    if ($password !== $repassword) {
        $error_message = "Passwords do not match!";
    } else {
        // Determine role and assign role_id
        if ($role === 'admin') {
            $role_id = 'ADM';
            $role_name = 'admin'; // Admin Role
        } elseif ($role === 'technician' && $technician_type === 'hardware') {
            $role_id = 'HT1';
            $role_name = 'hardware_technician'; // Hardware Technician
        } elseif ($role === 'technician' && $technician_type === 'software') {
            $role_id = 'ST1';
            $role_name = 'software_technician'; // Software Technician
        } else {
            $error_message = "Invalid role or technician type.";
        }

        // If no errors, insert into the database
        if (empty($error_message)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare SQL statement
            $sql = "INSERT INTO users (role_id, username, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssss", $role_id, $username, $hashed_password, $role_name);

                if ($stmt->execute()) {
                    // Set session variables for the user
                    session_start();
                    $_SESSION['role'] = $role_name;
                    $_SESSION['technician_type'] = $technician_type; // Only set this for technicians

                    // Redirect to respective dashboard based on role
                    if ($role_name === 'admin') {
                        header("Location: admin_dashboard.php");
                    } elseif ($role_name === 'hardware_technician' || $role_name === 'software_technician') {
                        header("Location: technician_dashboard.php");
                    }
                    exit; // Ensure no further code runs
                } else {
                    $error_message = "Database error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $error_message = "Database error: " . $conn->error;
            }
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->

</head>

<body>
    <div class="cont">
        <div class="form sign-up">
            <h1>Sign Up</h1>
            <!-- Display error or success messages -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?= $error_message; ?></div>
            <?php elseif (!empty($success_message)): ?>
                <div class="success-message"><?= $success_message; ?></div>
            <?php endif; ?>

            <!-- Signup Form -->
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" pattern="^[a-zA-Z-'\\s]{1,40}$" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{7,}$"
                    required>

                <label for="repassword">Retype Password:</label>
                <input type="password" id="repassword" name="repassword" required>

                <label for="role">Role:</label>
                <select id="role" name="role" required onchange="toggleTechie()">
                    <option value="">Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="technician">Technician</option>
                </select>

                <!-- Technician type dropdown (hidden by default) -->
                <div id="technician_type_field" class="hidden">
                    <label for="technician_type">Technician Type:</label>
                    <select id="technician_type" name="technician_type">
                        <option value="">Select type</option>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                    </select>
                </div>

                <button type="submit">Sign Up</button>
            </form>

            <script>
                // Function to show/hide technician type dropdown based on role selection
                function toggleTechie() {
                    const role = document.getElementById('role').value;
                    const techieField = document.getElementById('technician_type_field');
                    if (role === 'technician') {
                        techieField.classList.remove('hidden'); // Show technician type
                    } else {
                        techieField.classList.add('hidden'); // Hide technician type
                    }
                }
            </script>
        </div>

        <br><br><br>

        <!-- Additional Information -->
        <div class="sub-cont">
            <p>Create an account to get started with our platform.</p>
        </div>
    </div>

    <script>
        // Function to toggle the technician type field
        function toggleTechie() {
            const role = document.getElementById('role').value;
            const techieField = document.getElementById('technician_type_field');
            if (role === 'technician') {
                techieField.classList.remove('hidden'); // Show technician type options
            } else {
                techieField.classList.add('hidden'); // Hide technician type options
            }
        }
    </script>
</body>

</html>