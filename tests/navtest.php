<?php
// Assuming you've fetched the user's role from the database
$user_role = 'service'; // Example: this would be dynamically set based on the logged-in user
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var userRole = "<?php echo $user_role; ?>";

    if (userRole === 'service') {
        // Disable all navigation except order entry and order log
        var allNavItems = document.querySelectorAll('.navbar-item');
        var allowedNavs = ['order_entry', 'order_log'];

        allNavItems.forEach(function(navItem) {
            var navId = navItem.id; // Assuming each nav item has a unique ID

            if (!allowedNavs.includes(navId)) {
                navItem.style.opacity = '0.5'; // Hide the nav item
                navItem.style.cursor = 'no-drop';
            }
        });
    }
    // Similarly, you can add conditions for other roles
});
</script>

<!-- Example Navbar -->
<ul class="navbar">
    <li id="dashboard" class="navbar-item">Dashboard</li>
    <li id="menu" class="navbar-item">Menu</li>
    <li id="stocks" class="navbar-item">Stocks</li>
    <li id="order_entry" class="navbar-item">Order Entry</li>
    <li id="order_log" class="navbar-item">Order Log</li>
</ul>
