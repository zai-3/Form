<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Pragma: no-cache");

// Include the database connection
include 'config.php';

// Fetch all submissions to show in a grid
$sql = "SELECT * FROM requests ORDER BY datetime DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$submissions = $stmt->fetchAll();

// Check if an edit request has been made
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];

    // Fetch the submission details for the specific edit_id
    $sql = "SELECT * FROM requests WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $editId);
    $stmt->execute();
    $submission = $stmt->fetch();

    // If no data is found for the given edit_id, show an error (optional)
    if (!$submission) {
        echo "No submission found with the given ID.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Forms</title>
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center">Manage Form Submissions</h2>

    <!-- Show all submissions in a grid -->
    <div class="row">
        <?php foreach ($submissions as $submission): ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($submission['name']); ?></h5>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($submission['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($submission['phone_number']); ?></p>
                    <p><strong>Item Type:</strong> <?php echo htmlspecialchars($submission['item_type']); ?></p>
                    <p><strong>Issue Type:</strong> <?php echo htmlspecialchars($submission['issue_type']); ?></p>
                    <a href="?edit_id=<?php echo $submission['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="?send_id=<?php echo $submission['id']; ?>" class="btn btn-success mt-2">Send</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Edit Form - Display when editing a submission -->
    <?php if (isset($submission)): ?>
    <div class="card mt-5">
        <div class="card-body">
            <h3 class="text-center">Edit Submission</h3>
            <form method="POST" action="edit_submission.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($submission['id']); ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($submission['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($submission['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($submission['phone_number']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="datetime" class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($submission['datetime'])); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="item_type" class="form-label">Item Type</label>
                    <input type="text" class="form-control" id="item_type" name="item_type" value="<?php echo htmlspecialchars($submission['item_type']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo htmlspecialchars($submission['serial_number']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="issue_type" class="form-label">Issue Type</label>
                    <input type="text" class="form-control" id="issue_type" name="issue_type" value="<?php echo htmlspecialchars($submission['issue_type']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="purchase_type" class="form-label">Purchase Type</label>
                    <input type="text" class="form-control" id="purchase_type" name="purchase_type" value="<?php echo htmlspecialchars($submission['purchase_type']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="additional_info" class="form-label">Additional Info</label>
                    <textarea class="form-control" id="additional_info" name="additional_info" rows="4"><?php echo htmlspecialchars($submission['additional_info']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Changes</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
