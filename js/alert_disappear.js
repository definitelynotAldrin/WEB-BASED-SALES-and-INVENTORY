
document.addEventListener('DOMContentLoaded', function() {
    // Select the alert elements
    const alertDanger = document.querySelector('.alert-danger');
    const alertSuccess = document.querySelector('.alert-success');

    // Set a timeout to hide the alerts after 5 seconds (5000 milliseconds)
    if (alertDanger) {
        setTimeout(function() {
            alertDanger.style.opacity = '0';
        }, 5000);
    }

    if (alertSuccess) {
        setTimeout(function() {
            alertSuccess.style.opacity = '0';
        }, 4000);
    }
});
