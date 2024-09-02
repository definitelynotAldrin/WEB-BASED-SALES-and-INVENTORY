
// document.addEventListener('DOMContentLoaded', function() {
//     const pop_up = document.querySelector('.inserting-confirmation-container');
//     const overlay = document.querySelector('.inserting-confirmation-overlay')
//     const btnSave = document.querySelector('.btn-save');
//     // const btnYes = document.querySelector('.btn-yes');
//     const btnCancel = document.querySelector('.btnCancel');

//     btnSave.addEventListener('click', function() {
//         pop_up.style.display = "block";
//         overlay.style.display = "block";
//         document.body.style.overflow = "hidden";
//     });

//     btnCancel.addEventListener('click', function() {
//         pop_up.style.display = "none";
//         overlay.style.display = "none";
//         document.body.style.overflow = "auto";
//     });

// });


document.addEventListener('DOMContentLoaded', function() {
    const pop_up = document.querySelector('.inserting-confirmation-container');
    const overlay = document.querySelector('.inserting-confirmation-overlay');
    const btnSave = document.querySelector('.btn-save');
    const btnCancel = document.querySelector('.btnCancel');

    btnSave.addEventListener('click', function(event) {
        // Get the form inputs (you can adjust selectors as needed)
        const itemName = document.querySelector('input[name="item_name"]');
        const itemPrice = document.querySelector('input[name="item_price"]');
        const itemCategory = document.querySelector('select[name="item_categories"]');

        // Check if any required input is empty
        if (itemName.value.trim() === '' || itemPrice.value.trim() === '' || itemCategory.value.trim() === '') {
            // Prevent default action (i.e., prevent the pop-up from showing)
            

            // You could display an error message or handle this scenario as you see fit
            // alert('Please fill in all required fields.');
        } else {
            // If all inputs are filled, show the pop-up
            pop_up.style.display = "block";
            overlay.style.display = "block";
            document.body.style.overflow = "hidden";
        }
    });

    btnCancel.addEventListener('click', function() {
        pop_up.style.display = "none";
        overlay.style.display = "none";
        document.body.style.overflow = "auto";
    });
});
