<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $item_type = $_POST['item_type'];
    $serial_number = isset($_POST['serial_number']) ? $_POST['serial_number'] : 'N/A';
    $problem = $_POST['problem'];
    $comments = $_POST['comments'];

    // Save the data into a file
    $data = "$name, $contact, $address, $item_type, $serial_number, $problem, $comments\n";
    file_put_contents('submissions.txt', $data, FILE_APPEND);
    echo "<script>alert('Your submission was successful!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Repair Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Customer Repair Submission Form</h1>
    <form method="POST" action="">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        
        <label for="contact">Contact</label>
        <input type="text" id="contact" name="contact" required>
        
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3"></textarea>
        
        <label for="item_type">Item Type</label>
        <select id="item_type" name="item_type" required onchange="toggleSerialNumber()">
            <option value="">Select an item</option>
            <option value="Laptop">Laptop</option>
            <option value="Printer">Printer</option>
            <option value="Other Hardware">Other Hardware</option>
        </select>
        
        <!-- Serial Number Field (hidden by default) -->
        <div id="serial_number_field" class="hidden">
            <label for="serial_number">Serial Number</label>
            <input type="text" id="serial_number" name="serial_number" placeholder="Enter serial number">
        </div>
        
        <label for="problem">Problem Type</label>
        <select id="problem" name="problem" required>
            <option value="Screen Issue">Screen Issue</option>
            <option value="Battery Problem">Battery Problem</option>
            <option value="Software Error">Software Error</option>
        </select>
        
        <label for="comments">Additional Comments</label>
        <textarea id="comments" name="comments" rows="3"></textarea>
        
        <button type="submit">Submit</button>
    </form>

    <script>
        // Function to show/hide serial number field based on item type
        function toggleSerialNumber() {
            const itemType = document.getElementById('item_type').value;
            const serialNumberField = document.getElementById('serial_number_field');
            if (itemType === 'Laptop') {
                serialNumberField.classList.remove('hidden');
            } else {
                serialNumberField.classList.add('hidden');
            }
        }
    </script>
</body>
</html>