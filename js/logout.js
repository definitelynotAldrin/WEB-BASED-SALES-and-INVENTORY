
document.addEventListener('DOMContentLoaded', function() {
    const pop_up = document.querySelector('.logout-confirmation-container');
    const overlay = document.querySelector('.logout-confirmation-overlay')
    const btnLogout = document.querySelector('.btn-logout');
    // const btnYes = document.querySelector('.btn-yes');
    const btnNo = document.querySelector('.btn-no');

    btnLogout.addEventListener('click', function() {
        pop_up.style.display = "block";
        overlay.style.display = "block";
        document.body.style.overflow = "hidden";
    });

    btnNo.addEventListener('click', function() {
        pop_up.style.display = "none";
        overlay.style.display = "none";
        document.body.style.overflow = "auto";
    });

});