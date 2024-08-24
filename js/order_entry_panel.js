
// -----------------------------quantity order taking popup------------------------

document.addEventListener('DOMContentLoaded', function() {
    const kgBoxes = document.querySelectorAll('.menu-item-quantity');
    const inputField = document.querySelector('.card-input-field input');

    kgBoxes.forEach(box => {
        box.addEventListener('click', function() {
            // Check if the clicked box is already active
            const isActive = this.classList.contains('active');

            // Remove 'active' class from all boxes and reset their background color
            kgBoxes.forEach(b => b.classList.remove('active'));

            if (isActive) {
                // If the clicked box was active, enable the input field
                inputField.disabled = false;
                inputField.value = ''; // Clear the input field
            } else {
                // If the clicked box was not active, make it active and disable the input field
                this.classList.add('active');
                inputField.disabled = true;
                inputField.value = ''; // Clear the input field
            }

            // Log the selected value or state change to the console
            // if (this.classList.contains('active')) {
            //     console.log(`Selected kilogram: ${this.querySelector('h3').textContent}`);
            // } else {
            //     console.log('Input field enabled');
            // }
        });
    });

    inputField.addEventListener('input', function() {
        // Log the input value to the console
        console.log(`Input field value: ${this.value}`);
    });
});




// POPUP QUANTITY


document.addEventListener('DOMContentLoaded', function () {
    const menu_items = document.querySelectorAll('.menu-item-card');
    const maincourse_quantity = document.querySelector('.maincourse-quantity');
    const btnProceeds = document.querySelector('.btn-proceed');
    const popupOverlay = document.querySelector('.popup-overlay')

    menu_items.forEach(function(menu_item){
        menu_item.addEventListener('click', function(){
            maincourse_quantity.style.display = "block";
            popupOverlay.style.display = "block";
        });
    });

    btnProceeds.forEach(function(btnProceed){
        btnProceed.addEventListener('click', function(){
            maincourse_quantity.style.display = "none";
            popupOverlay.style.display = "none";
        });
    });
});