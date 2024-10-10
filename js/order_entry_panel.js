
// -----------------------------quantity order taking popup------------------------

// document.addEventListener('DOMContentLoaded', function() {
//     const kgBoxes = document.querySelectorAll('.menu-item-quantity');
//     const inputField = document.getElementById('custom_kg');

//     kgBoxes.forEach(box => {
//         box.addEventListener('click', function() {
//             // Check if the clicked box is already active
//             const isActive = this.classList.contains('active');

//             // Remove 'active' class from all boxes and reset their background color
//             kgBoxes.forEach(b => b.classList.remove('active'));

//             if (isActive) {
//                 // If the clicked box was active, enable the input field
//                 inputField.disabled = false;
//                 inputField.value = ''; // Clear the input field
//             } else {
//                 // If the clicked box was not active, make it active and disable the input field
//                 this.classList.add('active');
//                 inputField.disabled = true;
//                 inputField.value = ''; // Clear the input field
//             }

//             // Log the selected value or state change to the console
//             // if (this.classList.contains('active')) {
//             //     console.log(`Selected kilogram: ${this.querySelector('h3').textContent}`);
//             // } else {
//             //     console.log('Input field enabled');
//             // }
//         });
//     });

//     inputField.addEventListener('input', function() {
//         // Log the input value to the console
//         console.log(`Input field value: ${this.value}`);
//     });
// });




// POPUP QUANTITY


// document.addEventListener('DOMContentLoaded', function () {
//     const menu_items = document.querySelectorAll('.menu-item-card');
//     const maincourse_quantity = document.querySelector('.kilograms-quantity');
//     const btnCancel = document.querySelectorAll('.btn-cancel');
//     const popupOverlay = document.querySelector('.popup-overlay')

//     // menu_items.forEach(function(menu_item){
//     //     menu_item.addEventListener('click', function(){
//     //         maincourse_quantity.style.display = "block";
//     //         popupOverlay.style.display = "block";
//     //         document.body.style.overflow = "hidden";
//     //     });
//     // });

//     btnCancel.forEach(function(cancelBtn){
//         cancelBtn.addEventListener('click', function(){
//             maincourse_quantity.style.display = "none";
//             popupOverlay.style.display = "none";
//             document.body.style.overflow = "auto";
//         });
//     });

//     popupOverlay.addEventListener('click', function(){
//         maincourse_quantity.style.display = "none";
//         popupOverlay.style.display = "none";
//         document.body.style.overflow = "auto";
//     });
    
// });


// // Function to handle the popup display
// function showPopup(category, id, name) {
//     // Hide both popups initially
//     document.getElementById('kilograms-popup').style.display = 'none';
//     document.getElementById('pieces-popup').style.display = 'none';
//     document.getElementById('popup-overlay').style.display = 'none';
//     const btnCancel = document.querySelectorAll('.btn-cancel');
//     const overlay = document.querySelector('.popup-overlay');

//     if (category === 'main course') {
//         // Show the kilograms popup
//         document.getElementById('kilograms-popup').style.display = 'block';
//         document.getElementById('popup-overlay').style.display = 'block';
//         document.body.style.overflow = "hidden";
//         // Populate the hidden fields for kilograms popup
//         document.getElementById('dish_id_kg').value = id;
//         document.getElementById('dish_name_kg').value = name;
//     } else {
//         // Show the pieces popup for dessert and beverages
//         document.getElementById('pieces-popup').style.display = 'block';
//         document.getElementById('popup-overlay').style.display = 'block';
//         document.body.style.overflow = "hidden";
//         // Populate the hidden fields for pieces popup
//         document.getElementById('dish_id_pieces').value = id;
//         document.getElementById('dish_name_pieces').value = name;
//     }

//     btnCancel.forEach(function(cancelBtn){
//         cancelBtn.addEventListener('click', function(){
//             document.getElementById('kilograms-popup').style.display = 'none';
//             document.getElementById('pieces-popup').style.display = 'none';
//             document.getElementById('popup-overlay').style.display = 'none';
//             document.body.style.overflow = "auto";
//         });
//     });

//     overlay.addEventListener('click', function(){
//         document.getElementById('kilograms-popup').style.display = 'none';
//         document.getElementById('pieces-popup').style.display = 'none';
//         document.getElementById('popup-overlay').style.display = 'none';
//         document.body.style.overflow = "auto";
//     });

// }

// // Add click event listeners to menu cards
// document.querySelectorAll('.menu-item-card').forEach(card => {
//     card.addEventListener('click', function() {
//         const itemId = this.getAttribute('data-id');
//         const itemName = this.querySelector('.menu-name').innerText;
//         const itemCategory = this.getAttribute('data-category');

//         // Show corresponding popup based on category
//         showPopup(itemCategory, itemId, itemName);
//     });
// });




// -----------------------Search bar for order entry--------------------------

document.getElementById('search_menu').addEventListener('input', function() {
    // Get the value typed by the user in the search input
    let searchValue = this.value.toLowerCase();

    // Get all the menu item cards
    let menuItems = document.querySelectorAll('.menu-item-card');

    // Loop through the menu items
    menuItems.forEach(function(item) {
        // Get the menu item name text (convert to lowercase to make search case-insensitive)
        let itemName = item.querySelector('.menu-name').textContent.toLowerCase();

        // Check if the menu item name includes the typed search value
        if (itemName.includes(searchValue)) {
            // If it matches, display the item
            item.style.display = 'flex';
        } else {
            // If it doesn't match, hide the item
            item.style.display = 'none';
        }
    });
});


document.getElementById('combo-input').addEventListener('input', function(event) {
    const value = event.target.value;
    console.log("Selected or entered value:", value);
});