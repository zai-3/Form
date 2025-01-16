document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-step");
    const dots = document.querySelectorAll(".dot");
    const submitButton = document.getElementById("submit-button");
    const laptopSerialContainer = document.getElementById("laptop-serial-container");
    const otherInput = document.getElementById("other-item");
    const itemImages = document.querySelectorAll(".item-img");
    const successMessage = document.getElementById("success-message");
    let currentStep = 0;
    let selectedItem = null;

    // Initially hide the success message on page load
    if (localStorage.getItem("formSubmitted")) {
        localStorage.removeItem("formSubmitted");
        successMessage.style.display = "none"; // Ensure it's hidden on reload
    } else {
        successMessage.style.display = "none";
    }

    // Show or hide the form step
    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle("d-none", i !== index);
            dots[i].classList.toggle("active", i === index);
        });

        validateForm(); // Validate form on every step change
    }

    // Enable or disable the submit button based on validation
    function validateForm() {
        // Check if a valid item is selected and the necessary field (serial number or device name) is filled
        const isItemSelected = selectedItem !== null;
        let isFieldValid = false;

        if (selectedItem === "Laptop") {
            const serialInput = document.getElementById("serial");
            isFieldValid = serialInput && serialInput.value.trim() !== "";
        } else if (selectedItem === "Other") {
            const otherDeviceInput = document.getElementById("other-item");
            isFieldValid = otherDeviceInput && otherDeviceInput.value.trim() !== "";
        } else {
            isFieldValid = true; // No additional field required for PC or Phone
        }

        const section3Dropdown1 = document.getElementById("issue-type");
        const section3Dropdown2 = document.getElementById("purchase-type");
        const areDropdownsFilled = section3Dropdown1 && section3Dropdown2 && section3Dropdown1.value.trim() !== "" && section3Dropdown2.value.trim() !== "";

        // Submit button should be enabled if an item is selected and its corresponding field is valid
        submitButton.disabled = !(isItemSelected && isFieldValid && areDropdownsFilled);

        // Update button styles dynamically
        if (submitButton.disabled) {
            submitButton.style.backgroundColor = "#cccccc";
            submitButton.style.cursor = "not-allowed";
            submitButton.style.boxShadow = "none";
        } else {
            submitButton.style.backgroundColor = "#007bff";
            submitButton.style.cursor = "pointer";
            submitButton.style.boxShadow = "0 6px #0056b3";
        }
    }

    itemImages.forEach((img) => {
        img.addEventListener("click", function () {
            selectedItem = this.dataset.item;
    
            // Remove the selected class from all images
            itemImages.forEach((img) => img.classList.remove("selected"));
            this.classList.add("selected");
    
            // Show/hide serial number or other device name input based on selection
            if (selectedItem === "Laptop") {
                laptopSerialContainer.classList.remove("d-none");
                laptopSerialContainer.querySelector("input").setAttribute("required", "required");
    
                // Hide and reset the "Other" field container
                const otherItemContainer = document.getElementById("other-item-container");
                otherItemContainer.classList.add("d-none");
                otherItemContainer.querySelector("input").removeAttribute("required");
                otherItemContainer.querySelector("input").value = ""; 
            } else if (selectedItem === "Other") {
                // Show the "Other" field container
                const otherItemContainer = document.getElementById("other-item-container");
                otherItemContainer.classList.remove("d-none");
                otherItemContainer.querySelector("input").setAttribute("required", "required");
    
                // Hide and reset the "Laptop Serial Number" field container
                laptopSerialContainer.classList.add("d-none");
                laptopSerialContainer.querySelector("input").removeAttribute("required");
                laptopSerialContainer.querySelector("input").value = "";
            } else {
                // Hide and reset both field containers
                laptopSerialContainer.classList.add("d-none");
                laptopSerialContainer.querySelector("input").removeAttribute("required");
                laptopSerialContainer.querySelector("input").value = "";
    
                const otherItemContainer = document.getElementById("other-item-container");
                otherItemContainer.classList.add("d-none");
                otherItemContainer.querySelector("input").removeAttribute("required");
                otherItemContainer.querySelector("input").value = "";
            }
    
            validateForm(); // Validate after selecting an item
        });
    });
    

    // Next button navigation
    nextButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const form = steps[currentStep]?.querySelector("form");
            if (form && !form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener("click", function () {
            currentStep = index;
            showStep(currentStep);
        });
    });

    // Validate form on every input change
    document.addEventListener("input", validateForm);

    // Submit button click handler
    submitButton.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent form submission

        if (!submitButton.disabled) {
            // Prepare form data
            let formData = new FormData(document.getElementById("multi-step-form"));

            // Send form data via AJAX (using Fetch API)
            fetch("multi_step_form.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show success message and hide after 5 seconds
                // const successMessage = document.getElementById("success-message");
                window.location.href = "success_page.html"; // Use a success page or reload the form page

            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    // Initial validation on page load
    validateForm();
});