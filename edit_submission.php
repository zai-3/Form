<?php

session_start();
// Include the database connection
include 'config.php';

// Determine the ID based on the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form submission: Get 'id' from POST
    $id = $_POST['id'];
} elseif (isset($_GET['id'])) {
    // Edit page loading: Get 'id' from GET
    $id = $_GET['id'];
} else {
    echo "No ID parameter found!";
    exit;
}

// Fetch the form data from the database based on the 'id'
$sql = "SELECT * FROM requests WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$form_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$form_data) {
    echo "No data found for this ID!";
    exit;
}

// If the form is submitted, update the data in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $datetime = $_POST['datetime'];
    $item_type = $_POST['item_type'];
    $serial_number = $_POST['serial_number'] ?? null; // Default to NULL if empty
    $issue_type = $_POST['issue_type'];
    $purchase_type = $_POST['purchase_type'];
    $additional_info = $_POST['additional_info'];

    // Prepare the SQL query to update the submission
    $sql = "UPDATE requests SET name = :name, email = :email, phone_number = :phone_number, 
            datetime = :datetime, item_type = :item_type, serial_number = :serial_number, 
            issue_type = :issue_type, purchase_type = :purchase_type, additional_info = :additional_info 
            WHERE id = :id";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':datetime', $datetime);
    $stmt->bindParam(':item_type', $item_type);
    $stmt->bindParam(':serial_number', $serial_number, PDO::PARAM_STR);
    $stmt->bindParam(':issue_type', $issue_type);
    $stmt->bindParam(':purchase_type', $purchase_type);
    $stmt->bindParam(':additional_info', $additional_info);

    // Execute the statement
    if ($stmt->execute()) {

        $_SESSION['success_message'] = "{$name} submitted successfully!";

        // Redirect back to the form list page after successful update
        header('Location: manage_forms.php?success=1');
        exit;
    } else {
        echo "Error updating the submission. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Submission</title>
</head>
<body>
    <h1>Edit Submission</h1>

    <!-- Edit Form -->
    <form method="POST">
        <!-- Hidden field to pass the ID -->
        <input type="hidden" name="id" value="<?php echo $id; ?>" />

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($form_data['name']); ?>"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email']); ?>"><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($form_data['phone_number']); ?>"><br>

        <label for="datetime">Date & Time:</label>
        <input type="datetime-local" id="datetime" name="datetime" value="<?php echo htmlspecialchars($form_data['datetime']); ?>"><br>

        <label for="item_type">Item Type:</label>
        <input type="text" id="item_type" name="item_type" value="<?php echo htmlspecialchars($form_data['item_type']); ?>"><br>

        <label for="serial_number">Serial Number:</label>
        <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo htmlspecialchars($form_data['serial_number']); ?>"><br>

        <label for="issue_type">Issue Type:</label>
        <input type="text" id="issue_type" name="issue_type" value="<?php echo htmlspecialchars($form_data['issue_type']); ?>"><br>

        <label for="purchase_type">Purchase Type:</label>
        <input type="text" id="purchase_type" name="purchase_type" value="<?php echo htmlspecialchars($form_data['purchase_type']); ?>"><br>

        <label for="additional_info">Additional Info:</label>
        <textarea id="additional_info" name="additional_info"><?php echo htmlspecialchars($form_data['additional_info']); ?></textarea><br>

        <button type="submit">Submit changes</button>
    </form>
</body>
</html>
