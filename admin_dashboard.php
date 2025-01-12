<?php
// Handle form submission for editing data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read existing data
    $rows = file_exists('submissions.txt') ? file('submissions.txt') : [];
    $updatedData = [];

    // Update the corresponding row
    foreach ($rows as $index => $row) {
        if ($index == $_POST['row_index']) {
            $updatedRow = implode(',', [
                $_POST['name'],
                $_POST['email'],
                $_POST['datetime'],
                $_POST['item_type'],
                $_POST['serial_number'],
                $_POST['issue_description'],
                $_POST['purchase_type'],
                $_POST['additional_info']
            ]) . "\n";
            $updatedData[] = $updatedRow;
        } else {
            $updatedData[] = $row;
        }
    }

    // Save back to file
    file_put_contents('submissions.txt', $updatedData);
    echo "<script>alert('Data updated successfully!');</script>";
}

// Fetch data for display
$rows = file_exists('submissions.txt') ? file('submissions.txt') : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Toggle edit mode for a row
        function toggleEditMode(rowId) {
            const row = document.getElementById(rowId);
            const isEditable = row.classList.contains("editable");

            // Toggle editable state
            row.classList.toggle("editable");

            // Update buttons
            const updateBtn = row.querySelector(".update-btn");
            updateBtn.style.display = isEditable ? "inline-block" : "none";

            const saveBtn = row.querySelector(".save-btn");
            saveBtn.style.display = isEditable ? "none" : "inline-block";
        }
    </script>
</head>

<body>
    <a href="?logout=true" class="logout-btn">Logout</a>
    <!-- <header class="dashboard-header">
        <h1>Admin Dashboard</h1>
    </header> -->

    <section class="dashboard-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date & Time</th>
                    <th>Item Type</th>
                    <th>Serial Number</th>
                    <th>Issue Description</th>
                    <th>Purchase Type</th>
                    <th>Additional Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $index => $row): ?>
                        <?php
                        $columns = explode(',', trim($row));
                        if (count($columns) < 8) {
                            continue; // Ensure valid row
                        }
                        ?>
                        <tr id="row-<?php echo $index; ?>">
                            <form method="POST" action="">
                                <input type="hidden" name="row_index" value="<?php echo $index; ?>">
                                <td><input type="text" name="name" value="<?php echo htmlspecialchars($columns[0]); ?>"></td>
                                <td><input type="email" name="email" value="<?php echo htmlspecialchars($columns[1]); ?>"></td>
                                <td><input type="datetime-local" name="datetime"
                                        value="<?php echo htmlspecialchars($columns[2]); ?>"></td>
                                <td><input type="text" name="item_type" value="<?php echo htmlspecialchars($columns[3]); ?>">
                                </td>
                                <td><input type="text" name="serial_number"
                                        value="<?php echo htmlspecialchars($columns[4]); ?>"></td>
                                <td><textarea name="issue_description"><?php echo htmlspecialchars($columns[5]); ?></textarea>
                                </td>
                                <td><input type="text" name="purchase_type"
                                        value="<?php echo htmlspecialchars($columns[6]); ?>"></td>
                                <td><textarea name="additional_info"><?php echo htmlspecialchars($columns[7]); ?></textarea>
                                </td>
                                <td>
                                    <button type="button" class="update-btn"
                                        onclick="toggleEditMode('row-<?php echo $index; ?>')">Update</button>
                                    <button type="submit" class="save-btn" style="display: none;">Save</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">No data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>

</html>