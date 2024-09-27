// -------------------------------pop up stocks edit----------------------------------


document.addEventListener('DOMContentLoaded', function() {
    
    const closeBtns = document.querySelectorAll('.btn-close');
    const popupForm = document.querySelectorAll('.popup-form-container');
    const popupOverlay = document.querySelector('.popup-overlay');

    // editbtns.forEach(function(editBtn) {
    //     editBtn.addEventListener('click', function () {
    //         // Show the popup form and overlay
    //         popupForm.style.display = "block";
    //         popupOverlay.style.display = "block";
    //     });
    // });

    closeBtns.forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function () {
            // Hide the popup form and overlay
            popupOverlay.style.display = "none";

            popupForm.forEach(function(forms) {
                forms.style.display = "none";
            });
        });
    });

    popupOverlay.addEventListener('click', function() {
        // Hide the popup form and overlay when clicking outside the form
        popupForm.forEach(function(forms) {
            forms.style.display = "none";
        });
        popupOverlay.style.display = "none";
    });
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