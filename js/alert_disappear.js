
document.addEventListener('DOMContentLoaded', function() {
    // Select the alert elements
    const alertDanger = document.querySelector('.alert-danger');
    const alertSuccess = document.querySelector('.alert-success');

    // Set a timeout to hide the alerts after 5 seconds (5000 milliseconds)
    if (alertDanger) {
        setTimeout(function() {
            alertDanger.style.display = 'none';
        }, 3000);
    }

    if (alertSuccess) {
        setTimeout(function() {
            alertSuccess.style.display = 'none';
        }, 3000);
    }
});
