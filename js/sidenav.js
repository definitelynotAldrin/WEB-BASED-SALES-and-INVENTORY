// document.addEventListener('DOMContentLoaded', function() {
//     const navbar = document.querySelector('.nav-bar');
//     const sidenav = document.querySelector('.side-navigation-container');
//     const side_overlay = document.querySelector('.side-overlay');

//     // Function to check screen width and update overlay display
//     function checkScreenWidth() {
//         if (window.innerWidth >= 1065) {
//             side_overlay.style.display = "none"; // Hide overlay on larger screens
//         } else {
//             // Show the overlay if the sidenav is open
//             if (sidenav.style.display === "block") {
//                 side_overlay.style.display = "block";
//             }
//         }
//     }

//     // Initial check
//     checkScreenWidth();

//     // Listen for screen resize events
//     window.addEventListener('resize', checkScreenWidth);

//     // Navbar click event
//     navbar.addEventListener('click', function() {
//         if (sidenav.style.display === "block") {
//             sidenav.style.position = "absolute";
//             sidenav.style.display = "none";
//             side_overlay.style.display = "none";
//         } else {
//             sidenav.style.display = "block";
//             // Only show overlay if screen width is less than 1065px
//             if (window.innerWidth < 1065) {
//                 side_overlay.style.display = "block";
//             }
//         }
//     });
// });




// ----------------------- side navigations ------------------------ 

document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.nav-bar');
    const sidenav = document.querySelector('.side-navigation-container');
    const side_overlay = document.querySelector('.side-overlay');
    const closebtn = document.querySelector('.close-btn');

    function toggleSidenav() {
        if (sidenav.style.display === "block") {
            sidenav.style.display = "none";
            side_overlay.style.display = "none";
            document.body.style.overflow = "auto";
        } else {
            sidenav.style.display = "block";
            side_overlay.style.display = "block";
            document.body.style.overflow = "hidden";
        }
    }

    function closeSidenav() {
        side_overlay.style.display = "none";
        sidenav.style.display = "none";
        document.body.style.overflow = "auto";
    }

    function handleResize() {
        if (window.innerWidth >= 991) {
            sidenav.style.display = "flex";
            side_overlay.style.display = "none";
            document.body.style.overflow = "auto";
        } else {
            sidenav.style.display = "none";
            side_overlay.style.display = "none";
            document.body.style.overflow = "auto";
        }
    }

    navbar.addEventListener('click', toggleSidenav);
    closebtn.addEventListener('click', closeSidenav);
    window.addEventListener('resize', handleResize);

    // Initial call to handleResize to set the correct state on load
    handleResize();
});





// ---------------------------------NOTIFICATION SECTION---------------------------------------------

document.addEventListener('DOMContentLoaded', function() {
    const btn_bell = document.querySelector('.notification-bell');
    const notification = document.querySelector('.notification-content-container');

    function toggleNotification() {
        if(notification.style.display === 'block'){
            notification.style.display = 'none';
        }
        else{
            notification.style.display = 'block';
        }
    }

    btn_bell.addEventListener('click', toggleNotification);
});

