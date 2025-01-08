<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission logic here
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $datetime = $_POST['datetime'] ?? '';
    $itemType = $_POST['itemType'] ?? '';
    $serial = $_POST['serial'] ?? '';
    $issue = $_POST['issue'] ?? '';
    $purchaseType = $_POST['purchaseType'] ?? '';
    $additionalInfo = $_POST['additionalInfo'] ?? '';

    // Process or store the data as needed
    // For example: save to a database or send an email
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-black text-white">
    <div class="container py-5">
        <div class="text-center mb-4">
            <img src="assets/laptop-logo.jfif" alt="Laptop Logo" class="mb-3" style="width: 100px;">
            <h2 class="text-white">Please Fill In</h2>
        </div>

        <div id="form-steps">
            <!-- Step 1: Customer Data -->
            <div class="form-step">
                <h3 class="text-center">Customer Data</h3>
                <form id="step1-form" class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">Date & Time</label>
                        <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
                    </div>
                    <button type="button" class="btn btn-primary w-100 next-step">Next</button>
                </form>
            </div>

            <!-- Step 2: Type Selection -->
            <div class="form-step d-none">
                <h3 class="text-center">Type Selection</h3>
                <div class="row text-center">
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="Laptop" class="item-img" data-item="Laptop">
                        <p>Laptop</p>
                    </div>
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="PC" class="item-img" data-item="PC">
                        <p>PC</p>
                    </div>
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="Phone" class="item-img" data-item="Phone">
                        <p>Phone</p>
                    </div>
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="Earphone" class="item-img" data-item="Earphone">
                        <p>Earphone</p>
                    </div>
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="Keyboard" class="item-img" data-item="Keyboard">
                        <p>Keyboard</p>
                    </div>
                    <div class="col">
                        <img src="assets/laptop-logo.jfif" alt="Other" class="item-img" data-item="Other">
                        <p>Other</p>
                        <input type="text" class="form-control d-none mt-2" id="other-item" name="itemType" placeholder="Enter item name">
                    </div>
                </div>
                <div id="laptop-serial" class="d-none mt-3">
                    <label for="serial" class="form-label">Serial Number</label>
                    <input type="text" class="form-control" id="serial" name="serial" required>
                </div>
                <button type="button" class="btn btn-primary w-100 next-step mt-3">Next</button>
            </div>

            <!-- Step 3: Issue Type -->
            <div class="form-step d-none">
                <h3 class="text-center">Issue Type</h3>
                <form id="step3-form" class="needs-validation" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="issue" class="form-label">Issue</label>
                        <input type="text" class="form-control" id="issue" name="issue" required>
                    </div>
                    <div class="mb-3">
                        <label for="purchase-type" class="form-label">Purchase Type</label>
                        <select class="form-select" id="purchase-type" name="purchaseType" required>
                            <option value="">Select an option</option>
                            <option value="store">From Our Store</option>
                            <option value="other">Some Other Store</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="additional-info" class="form-label">Any Additional Info or Questions</label>
                        <textarea class="form-control" id="additional-info" name="additionalInfo" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background-color: navy; color: white;">Submit</button>
                </form>
            </div>
        </div>

        <!-- Page Indicators -->
        <div class="d-flex justify-content-center mt-4">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
