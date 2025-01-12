document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-step");
    const dots = document.querySelectorAll(".dot");
    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle("d-none", i !== index);
            dots[i].classList.toggle("active", i === index);
        });
    }
 
    nextButtons.forEach((button, index) => {
        button.addEventListener("click", function () {
            // Perform validation (if required) for the current step
            const form = steps[currentStep].querySelector("form");
            if (form && !form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Proceed to the next step
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    // Show the first step by default
    showStep(currentStep);

    // Show/hide the serial number input for laptops
    const itemImages = document.querySelectorAll(".item-img");
    const laptopSerial = document.getElementById("laptop-serial");
    const otherInput = document.getElementById("other-item");

    itemImages.forEach((img) => {
        img.addEventListener("click", function () {
            const selectedItem = this.dataset.item;

            itemImages.forEach((img) => img.classList.remove("selected"));
            this.classList.add("selected");

            if (selectedItem === "Laptop") {
                laptopSerial.classList.remove("d-none");
                document.getElementById("serial").setAttribute("required", "required");
            } else {
                laptopSerial.classList.add("d-none");
                document.getElementById("serial").removeAttribute("required");
            }

            if (selectedItem === "Other") {
                otherInput.classList.remove("d-none");
            } else {
                otherInput.classList.add("d-none");
                otherInput.value = ""; // Reset value
            }
        });
    });
});
