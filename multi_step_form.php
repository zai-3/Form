<?php
// Include database connection
include 'config.php';

$message = ''; // Initialize a variable to store the success message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission logic here
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phoneNumber = $_POST['number'] ?? '';
    $datetime = $_POST['datetime'] ?? '';
    $itemType = $_POST['itemType'] ?? '';
    $serial = $_POST['serial'] ?? '';  // Laptop serial number
    $issueType = $_POST['issueType'] ?? '';
    $purchaseType = $_POST['purchaseType'] ?? '';
    $additionalInfo = $_POST['additionalInfo'] ?? '';

    // Insert data into the database
    try {
        $sql = "INSERT INTO requests (name, email, phone_number, datetime, item_type, serial_number, issue_type, purchase_type, additional_info)
                VALUES (:name, :email, :phone_number, :datetime, :item_type, :serial_number, :issue_type, :purchase_type, :additional_info)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':datetime', $datetime);
        $stmt->bindParam(':item_type', $itemType);
        $stmt->bindParam(':serial_number', $serial);
        $stmt->bindParam(':issue_type', $issueType);
        $stmt->bindParam(':purchase_type', $purchaseType);
        $stmt->bindParam(':additional_info', $additionalInfo);
        
        $stmt->execute();
        // $message = "Data successfully submitted!"; 
         header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
         exit;
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage(); // Set the error message
    }
}
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Data successfully submitted!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form</title>
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body class="bg-black text-white">
    <div class="container py-5">
        <div class="text-center mb-4">
            <img src="assets/logo.png" alt="Laptop Logo" class="mb-3" style="width: 100px;">
            <h2 class="text-white">Please Fill In</h2>
        </div>

 <!-- Success Message - Initially hidden -->
<?php if (isset($message) && $message == "Data successfully submitted!") : ?>
    <div id="success-message" style="color: green; font-weight: bold; font-size: 2rem; text-align: center; padding: 10px; background-color:rgb(183, 211, 183); border: 2px solid green; border-radius: 5px;">
    <?php echo $message; ?>
    </div>
<?php endif; ?>

<<<<<<< HEAD

        <!-- Single form tag for all steps -->
    <form method="POST" id="multi-step-form" class="needs-validation" action="">

    <div id="form-steps">
        <!-- Step 1: Customer Data -->
        <div class="form-step" id="section1">
            <h3 class="text-center">Customer Data</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
=======
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
                        <input type="text" class="form-control d-none mt-2" id="other-item" name="itemType"
                            placeholder="Enter item name">
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
                    <button type="submit" class="btn btn-primary w-100"
                        style="background-color: navy; color: white;">Submit</button>
                </form>
>>>>>>> 7b2e114a9fb341e4c10126450d30a745b30640c0
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="number" name="number" required>
            </div>
            <div class="mb-3">
                <label for="datetime" class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
            </div>
            <button type="button" class="btn btn-primary w-100 next-step">Next</button>
        </div>

        <!-- Step 2: Type Selection -->
        <div class="form-step d-none" id="section2">
            <h3 class="text-center">Type Selection</h3>
            <div class="row text-center">
                <div class="col">
                    <img src="assets/laptop-logo.jfif" alt="Laptop" class="item-img" data-item="Laptop">
                    <p>Laptop</p>
                    <div id="laptop-serial-container" class="d-none">
                        <label for="serial">Serial Number</label>
                        <input type="text" id="serial" name="serial">
                    </div>
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
                    <div id="other-item-container" class="d-none">
                        <label for="other-item">Enter Device Name</label>
                        <input type="text" id="other-item" name="other-item" placeholder="Enter item name">
                    </div>
                </div>
            </div>
            <input type="hidden" id="itemType" name="itemType" value="">
            <button type="button" class="btn btn-primary w-100 next-step mt-3">Next</button>
        </div>

        <!-- Step 3: Issue Type -->
        <div class="form-step d-none" id="section3">
            <h3 class="text-center">Issue Type</h3>
            <div class="mb-3">
                <label for="issueType" class="form-label">Issue Type</label>
                <select class="form-select" id="issueType" name="issueType" required>
                    <option value="">Select an option</option>
                    <option value="software">Software Issue</option>
                    <option value="battery">Battery Issue</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="purchaseType" class="form-label">Purchase Type</label>
                <select class="form-select" id="purchaseType" name="purchaseType" required>
                    <option value="">Select an option</option>
                    <option value="store">From Our Store</option>
                    <option value="other">Some Other Store</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="additionalInfo" class="form-label">Any Additional Info or Questions</label>
                <textarea class="form-control" id="additionalInfo" name="additionalInfo" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Submit</button>
        </div>
    </div>

    <!-- Page Indicators -->
    <div class="d-flex justify-content-center mt-4">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

</form>

    </div>
<!-- Add the JavaScript at the bottom -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nextButtons = document.querySelectorAll(".next-step");
        const formSteps = document.querySelectorAll(".form-step");
        const dots = document.querySelectorAll(".dot");
        let currentStep = 0;

        // Function to show a specific step
        function showStep(stepIndex) {
            formSteps.forEach((step, index) => {
                step.classList.toggle("d-none", index !== stepIndex);
                dots[index].classList.toggle("active", index === stepIndex);
            });
            currentStep = stepIndex; // Update the current step
        }

        // Function to show the next step
        function showNextStep() {
            if (currentStep < formSteps.length - 1) {
                showStep(currentStep + 1);
            }
        }

        // Add click event listener for all next buttons
        nextButtons.forEach(button => {
            button.addEventListener("click", showNextStep);
        });

        // Add click event listener for all dots
        dots.forEach((dot, index) => {
            dot.addEventListener("click", function () {
                showStep(index);
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message");

    // Show the success message if it's displayed
    if (successMessage) {
        successMessage.style.display = "block";

        // Hide the message after 5 seconds
        setTimeout(() => {
            successMessage.style.display = "none";
        }, 5000);
    }
});
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const itemImages = document.querySelectorAll(".item-img");
    const itemTypeInput = document.getElementById("itemType");
    const otherItemInput = document.getElementById("other-item");
    const otherItemContainer = document.getElementById("other-item-container");

    itemImages.forEach(image => {
        image.addEventListener("click", function () {
            const selectedItem = this.getAttribute("data-item");

            // If "Other" is selected, show the input box
            if (selectedItem === "Other") {
                otherItemContainer.classList.remove("d-none"); // Show the input box for entering the device name
                itemTypeInput.value = ""; // Reset the hidden input value
            } else {
                otherItemContainer.classList.add("d-none"); // Hide the input box for entering the device name
                itemTypeInput.value = selectedItem; // Set the hidden input value to the selected item
            }
        });
    });

    // When user types in the "Other" input field, set the value of the hidden input
    otherItemInput.addEventListener("input", function () {
        itemTypeInput.value = otherItemInput.value.trim(); // Update the hidden input with the entered value
    });
});

</script>

<script src="script.js" defer></script>
</body>

</html>