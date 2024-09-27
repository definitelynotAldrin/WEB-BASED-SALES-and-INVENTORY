
    document.addEventListener("DOMContentLoaded", function () {
    let selectedKgValue = null;
    let selectedItem = null;

    // Select all the menu cards
    const menuCards = document.querySelectorAll(".menu-item-card");

    // Popup for kilograms
    const kgPopup = document.getElementById("kilograms-popup");
    const customKgInput = document.getElementById("custom_kg");

    const overlay = document.querySelector(".popup-overlay");

    // Predefined kilogram options
    const kgOptions = document.querySelectorAll(".kilograms-quantity .card-boxes.menu-item-quantity");

    // Popup for pieces
    const piecesPopup = document.getElementById("pieces-popup");

    // Handling predefined kg selection
    kgOptions.forEach(option => {
        option.addEventListener("click", function () {
            // Remove selection from other options
            kgOptions.forEach(opt => opt.classList.remove("selected"));

            // Add selected class to the clicked option
            this.classList.add("selected");

            // Set the selected kg value
            selectedKgValue = this.getAttribute("data-value");

            // Clear the custom input if a predefined value is selected
            customKgInput.value = '';
        });
    });

    // Handling custom kg input
    customKgInput.addEventListener("input", function () {
        // Clear the predefined selection if custom input is used
        kgOptions.forEach(opt => opt.classList.remove("selected"));
        selectedKgValue = this.value;
    });

    // Add click event to each menu card to open the popup and set values
    menuCards.forEach(card => {
        card.addEventListener("click", function () {
            const category = card.getAttribute("data-category");
            const menuId = card.getAttribute("data-item-id");
            const menuName = card.querySelector(".menu-name").textContent;
            const itemPrice = parseFloat(card.querySelector("input[name='hidden_price']").value); // Get the price

            selectedItem = {
                id: menuId,
                name: menuName,
                price: itemPrice
            };

            // Open the correct popup based on category
            if (category === "main course") {
                kgPopup.querySelector("h1 span").textContent = menuName;
                kgPopup.style.display = "block";
                overlay.style.display = "flex";
            } else {
                piecesPopup.querySelector("h1 span").textContent = menuName;
                piecesPopup.style.display = "block";
                overlay.style.display = "flex";
            }
        });
    });

    // Handling form submission for kilogram popup
    kgPopup.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();

        if (!selectedKgValue || selectedKgValue === "") {
            window.location.href = '../public/order_entry.php?error=missing input';
            return;
        }

        // Add selected item to the summary table
        addToSummary(selectedItem.name, selectedKgValue + " Kilo(s)", selectedItem.price, selectedKgValue);

        // Close the popup
        kgPopup.style.display = "none";
        overlay.style.display = "none";
    });

    // Handling form submission for pieces popup
    piecesPopup.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();

        const piecesValue = piecesPopup.querySelector("input[type='number']").value;
        if (!piecesValue || piecesValue < 1) {
            window.location.href = '../public/order_entry.php?error=missing input';
            return;
        }

        // Add selected item to the summary table
        addToSummary(selectedItem.name, piecesValue + " Pieces", selectedItem.price, piecesValue);

        // Close the popup
        piecesPopup.style.display = "none";
        overlay.style.display = "none";
    });

    let runningTotal = 0;  // Global variable to store the total price

    // Function to update the total price display
    function updateTotalDisplay() {
        const totalField = document.querySelector(".total-field span");
        totalField.textContent = `₱ ${runningTotal.toFixed(2)}`;  // Update the total price in the DOM
    }

    function addToSummary(itemName, quantity, pricePerUnit, quantityValue) {
        const summaryTable = document.querySelector(".order-summary-section tbody");

        // Convert quantityValue to a number for calculations
        const newQuantityValue = parseFloat(quantityValue);

        // Check if the item already exists in the summary
        let existingRow = null;
        summaryTable.querySelectorAll("tr").forEach(row => {
            const existingItemName = row.querySelector("td:first-child").textContent;
            if (existingItemName === itemName) {
                existingRow = row;
            }
        });

        if (existingRow) {
            // If the item already exists, update the quantity and subtotal
            const existingQuantityCell = existingRow.querySelector("td:nth-child(2)");
            const existingSubtotalCell = existingRow.querySelector("td:nth-child(3)");

            // Extract current quantity and update it
            let currentQuantity = parseFloat(existingQuantityCell.textContent);
            const updatedQuantity = currentQuantity + newQuantityValue;
            existingQuantityCell.textContent = updatedQuantity + (quantity.includes("Kilo") ? " Kilo(s)" : " Pieces");

            // Update subtotal based on the new quantity
            const updatedSubtotal = (pricePerUnit * updatedQuantity).toFixed(2);
            existingSubtotalCell.innerHTML = `&#8369;${updatedSubtotal}`;

            // Update running total (adding only the newly added quantity)
            runningTotal += pricePerUnit * newQuantityValue;
            updateTotalDisplay();  // Update the total price display

        } else {
            // If the item doesn't exist, create a new row
            const subTotal = (pricePerUnit * newQuantityValue).toFixed(2);

            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td style='display:none;'>${itemName}</td>
                <td>${itemName}</td>
                <td>${quantity}</td>
                <td>&#8369;${subTotal}</td>
                <td class="btn-remove"><i class="fa-regular fa-trash-can"></i></td>
            `;

            summaryTable.appendChild(newRow);

            // Add the item's subtotal to the running total
            runningTotal += parseFloat(subTotal);
            updateTotalDisplay();  // Update the total price display

            // Add remove functionality to the delete button
            newRow.querySelector(".btn-remove").addEventListener("click", function () {
                // Subtract the item's subtotal from the running total when removed
                runningTotal -= parseFloat(subTotal);
                updateTotalDisplay();  // Update the total price display after removal
                newRow.remove();
            });
        }
    }


    // Close buttons for both popups
    document.querySelectorAll(".btn-cancel").forEach(btn => {
        btn.addEventListener("click", function () {
            kgPopup.style.display = "none";
            piecesPopup.style.display = "none";
            overlay.style.display = "none";
        });
    });
});




// ------------------------------------------------


document.getElementById("submitOrderBtn").addEventListener("click", function() {
    const customerName = document.getElementById("customerName").value;
    const customerNote = document.getElementById("customerNote").value;

    const summaryTableRows = document.querySelectorAll(".order-summary-section tbody tr");
    let orderDetails = [];
    let totalAmount = 0;

    // Extract each row's data from the summary table
    summaryTableRows.forEach(row => {
        const itemName = row.querySelector("td:nth-child(1)").textContent;
        const quantity = row.querySelector("td:nth-child(2)").textContent;
        const subtotal = parseFloat(row.querySelector("td:nth-child(3)").textContent.replace('₱', ''));

        // Add each item's details to the orderDetails array
        orderDetails.push({
            itemName: itemName,
            quantity: quantity,
            subtotal: subtotal
        });

        // Sum the total amount for the order
        totalAmount += subtotal;
    });

    // Send data via AJAX
    fetch("../public/save_order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            customerName: customerName,
            customerNote: customerNote,
            totalAmount: totalAmount,
            orderDetails: orderDetails
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Order saved successfully!");
            document.querySelector(".order-summary-section tbody").innerHTML = "";
        } else {
            alert("Failed to save the order.");
        }
    })
    .catch(error => console.error("Error saving order:", error));
});
