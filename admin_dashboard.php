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
                $_POST['contact'], 
                $_POST['address'], 
                $_POST['item_type'], 
                $_POST['problem'], 
                $_POST['comments']
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
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f4;
        }
        form {
            display: inline-block;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background-color: #0056b3;
        }
        input, textarea {
            width: 100%;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Item Type</th>
                <th>Problem</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $index => $row): ?>
                <?php 
                $columns = explode(',', trim($row)); 
                if (count($columns) < 6) continue; // Ensure valid row
                ?>
                <tr>
                    <form method="POST" action="">
                        <input type="hidden" name="row_index" value="<?php echo $index; ?>">
                        <td><input type="text" name="name" value="<?php echo htmlspecialchars($columns[0]); ?>"></td>
                        <td><input type="text" name="contact" value="<?php echo htmlspecialchars($columns[1]); ?>"></td>
                        <td><textarea name="address"><?php echo htmlspecialchars($columns[2]); ?></textarea></td>
                        <td><input type="text" name="item_type" value="<?php echo htmlspecialchars($columns[3]); ?>"></td>
                        <td><input type="text" name="problem" value="<?php echo htmlspecialchars($columns[4]); ?>"></td>
                        <td><textarea name="comments"><?php echo htmlspecialchars($columns[5]); ?></textarea></td>
                        <td>
                            <button type="submit">Save</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>