
// ----------------------- side navigations ------------------------ 

document.addEventListener('DOMContentLoaded', function() {
    const sideheader = document.querySelector('.side-header');
    const sidenav = document.querySelector('.side-nav');

    sideheader.addEventListener('click', function() {
        if (sidenav.style.display === "block") {
            sidenav.style.display = "none";
        }else{
            sidenav.style.display = "block";
        }
    });
});
