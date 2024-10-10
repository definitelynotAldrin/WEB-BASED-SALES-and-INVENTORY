// -------------------------------pop up stocks edit----------------------------------


document.addEventListener('DOMContentLoaded', function() {
    const menuCards = document.querySelectorAll('.menu-item-card');
    const popupOverlay = document.querySelector('.popup-overlay');
    const popup = document.querySelector('.popup_order_quantity');
    
    
    menuCards.forEach(function(cards) {
        cards.addEventListener('click', function () {
            popupOverlay.style.display = "block";
            popup.style.display = "block";
        });
    });


    // Close the popups and overlay when clicking the close button or outside the popup
    const closeBtns = document.querySelectorAll('.btn-cancel');

    closeBtns.forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function () {
            popupOverlay.style.display = "none";
            popup.style.display = "none";
        });
    });

    // popupOverlay.addEventListener('click', function() {
    //     popupOverlay.style.display = "none";
    //     popup.style.display = "none";
    // });
});


// -------------------------------delete confirmation-------------------------------------


document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.btn-delete');
    const cancelBtns = document.querySelectorAll('.confirm-cancel');
    const popupConfirmation = document.querySelector('.delete-confirmation-container');
    const confirmationOverlay = document.querySelector('.delete-confirmation-overlay');

    deleteBtns.forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            // Show the popup form and overlay
            popupConfirmation.style.display = "block";
            confirmationOverlay.style.display = "block";
        });
    });

    cancelBtns.forEach(function(cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            // Hide the popup form and overlay
            popupConfirmation.style.display = "none";
            confirmationOverlay.style.display = "none";
        });
    });

    confirmationOverlay.addEventListener('click', function() {
        // Hide the popup form and overlay when clicking outside the form
        popupConfirmation.style.display = "none";
            confirmationOverlay.style.display = "none";
    });
});