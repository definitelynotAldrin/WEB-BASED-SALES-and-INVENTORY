<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];

if(!isset($account_id)){
   header('location: ../public/login_panel.php');
}

// if ($user_role !== 'user_admin' &&  $user_role !== 'user_service') {
//     // Redirect to login or error page if user does not have the right role
//     header('Location: ../public/login_panel');
//     exit();
// }

?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var userRole = "<?php echo $user_role; ?>";

    if (userRole === 'user_admin') {
        // If the user is an admin, all navigation items are accessible
        var allNavItems = document.querySelectorAll('.navbar-item');
        allNavItems.forEach(function(navItem) {
            navItem.classList.remove('disabled-nav'); // Remove disabled class if it exists
            navItem.style.opacity = '1'; 
            navItem.style.pointerEvents = 'auto';
            navItem.style.cursor = 'pointer';
        });
    } 
    else if (userRole === 'user_service') {
        // Disable all navigation except order entry and order log
        var allNavItems = document.querySelectorAll('.navbar-item');
        var allowedNavs = ['order_entry', 'order_log'];

        allNavItems.forEach(function(navItem) {
            var navId = navItem.id; // Assuming each nav item has a unique ID

            if (!allowedNavs.includes(navId)) {
                navItem.classList.add('disabled-nav');
            } else {
                navItem.classList.remove('disabled-nav');
            }
        });
    }
    else if (userRole === 'user_kitchen') {
        // Disable all navigation except order entry and order log
        var allNavItems = document.querySelectorAll('.navbar-item');
        var allowedNavs = ['kitchen', 'settlement', 'order_log'];

        allNavItems.forEach(function(navItem) {
            var navId = navItem.id; // Assuming each nav item has a unique ID

            if (!allowedNavs.includes(navId)) {
                navItem.classList.add('disabled-nav');
            } else {
                navItem.classList.remove('disabled-nav');
            }
        });
    }
    // You can add more conditions for other roles as needed
});
</script>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kan-anan by the Sea</title>
    <link rel="stylesheet" href="../css/order_log.css">
    <link rel="shortcut icon" href="../assets/Sea Sede (200 x 200 px).png" type="image/x-icon">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/39d1af4576.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../libs/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="main-container">
        <div class="side-overlay"></div>
        <div class="side-navigation-container">
            <i class="fa-solid fa-x close-btn"></i>
            <div class="side-navigation-logo">
                <img src="../assets/Sea Sede (200 x 200 px).png" alt="" class="logo-img">
                <h1 class="logo-title">Kan-anan by the Sea</h1>
            </div>
            <nav class="side-navigation">
                <div class="menu">
                    <ul class="nav-lists">
                        <li id="dashboard" class="navbar-item">
                            <a href="../public/index.php">
                                <i class="fa-solid fa-border-all"></i>
                                <span class="link-text">dashboard</span>
                            </a>
                        </li>
                        <li id="menu_entry" class="navbar-item">
                            <a href="../public/menu_entry.php" >
                                <i class="fa-solid fa-shrimp"></i>
                                <span class="link-text">Menu data entry</span>
                            </a>
                        </li>
                        <li id="stocks_entry" class="navbar-item">
                            <a href="../public/stocks_entry.php">
                                <i class="fa-solid fa-cubes"></i>
                                <span class="link-text">stocks data entry</span>
                            </a>
                        </li>
                        <li id="order_entry" class="navbar-item">
                            <a href="../public/order_entry.php">
                                <i class="fa-solid fa-rectangle-list"></i>
                                <span class="link-text">order data entry</span>
                            </a>
                        </li>
                        <li id="order_log" class="navbar-item">
                            <a href="../public/order_log.php" class="active">
                                <i class="fa-solid fa-box-archive"></i>
                                <span class="link-text">order log</span>
                            </a>
                        </li>
                        <li id="kitchen" class="navbar-item">
                            <a href="../public/kitchen_dashboard.php">
                                <i class="fa-solid fa-kitchen-set"></i>
                                <span class="link-text">kitchen dashboard</span>
                            </a>
                        </li>
                        <li id="settlement" class="navbar-item">
                            <a href="../public/settlement_panel.php">
                                <i class="fa-solid fa-credit-card"></i>
                                <span class="link-text">settlement</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="bottom-menu">
                    <ul class="nav-lists">
                        <li>
                            <a href="#" class="btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="link-text">logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="content-container">
            <div class="content-header">
                <div class="header-text">
                    <h1>Order History<span></span></h1>
                    <h4>Search order history or customers order status</h4>
                </div>
                <div class="header-profile">
                <div class="notification">
                        <i class="fa-solid fa-bell notification-bell">
                            <i class="fa-solid fa-circle notification-alert-icon" style="display: none;"></i>
                        </i>

                        <div class="notification-content-container">
                            <h1 class="notification-title">Notifications</h1>
                            <div class="notification-card-container" id="low-stock-notifications">
                                <p>No low stock items currently.</p>
                            </div>
                        </div>
                    </div>
                    <script>
                        function fetchLowStockItems() {
                            $.ajax({
                                url: '../php/get_low_stock_items.php', // Adjust the path if needed
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    const notificationContainer = $('#low-stock-notifications');
                                    const notificationBell = $('.notification-alert-icon');
                                    
                                    notificationContainer.empty(); // Clear the current content

                                    if (data.length > 0) {
                                        notificationBell.show(); // Show the notification alert icon
                                        
                                        // Loop through the low stock items and add to notification container
                                        data.forEach(function(item) {
                                            const notification = `
                                                <div class="notification-content">
                                                    <div class="notification-img">
                                                        <img src="../assets/mark.png">
                                                    </div>
                                                    <div class="notification-details">
                                                        <h1 class="notification-details-title">${item.stock_name}</h1>
                                                        <p><span>Stock Alert:</span> This item is running low. <br>Only <span>${item.stock_quantity} ${item.stock_unit}</span> available.</p>
                                                    </div>
                                                </div>`;
                                            notificationContainer.append(notification);
                                        });
                                    } else {
                                        notificationBell.hide(); // Hide the notification alert icon if no low stock items
                                        notificationContainer.html('<p>No low stock items currently.</p>');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching low stock items:', error);
                                }
                            });
                        }

                        // Fetch low stock items when the page loads
                        $(document).ready(function() {
                            fetchLowStockItems();

                            // Optional: Set interval to refresh the notifications periodically
                            setInterval(fetchLowStockItems, 3000); // Refresh every 30 seconds
                        });

                        
                    </script>
                    <div class="profile">
                        <img src="../assets/me.jpg">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="menu-section-container order-log-section">
                <div class="first-panel-section order-log-content">
                    <div class="first-panel-header">
                        <input type="text" placeholder="Search customer" id="search_customer" name="search_customer">
                        <input type="date" name="search_date" id="search_date">
                    </div>
                    <div class="bottom-card-content customer-card-container">
                        <!-- Orders will be dynamically inserted here -->
                    </div>
                </div>

                <div class="second-panel-section order-log-content">
                    <div class="second-panel-header">
                        <h1 class="header-title customer-name"></h1>
                        <h1 class="header-title customer-order-datetime">
                            order date & time:
                            <span class="order-date"></span>
                            <span class="order-time"></span>
                        </h1>
                    </div>
                    <div class="second-panel-card-container order-summary-section">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="order-header">order</th>
                                        <th class="quantity-header">qty</th>
                                        <th>order status</th>
                                        <th class="subtotal-header">sub-total</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-bottom-container total-section">
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group total-field">
                                    <h3>order status</h3>
                                    <span></span>
                                </div>
                                <div class="card-bottom-group total-field">
                                    <h3>total</h3>
                                    <span></span>
                                </div>
                            </div>
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group note-field">
                                    <h3>note</h3>
                                    <textarea name="" id="customer_note" disabled></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    function fetchOrdersHistory() {
                        const searchCustomer = $('#search_customer').val();
                        const searchDate = $('#search_date').val();

                        $.ajax({
                            url: '../php/fetch_orders_log.php', // Your PHP script
                            type: 'GET',
                            data: {
                                search_customer: searchCustomer,
                                search_date: searchDate
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('.customer-card-container').empty(); // Clear previous results
                                if (data.success && data.orders.length > 0) {
                                    $.each(data.orders, function(index, order) {
                                        $('.customer-card-container').append(`
                                            <div class="bottom-cards customers-cards" data-order-id="${order.order_id}">
                                                <div class="bottom-cards-group customer-details">
                                                    <h1 class="bottom-cards-customer">${order.customer_name}</h1>
                                                </div>
                                                <div class="bottom-cards-group settlement">
                                                    <h3>Order Date & Time</h3>
                                                    <span class="date-time">${order.order_date} ${order.order_time}</span>
                                                </div>
                                            </div>
                                        `);
                                    });
                                } else {
                                    $('.customer-card-container').append('<p>No orders found.</p>');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log("Error fetching orders: " + textStatus, errorThrown);
                            }
                        });
                    }

                    // Trigger fetchOrdersHistory on input
                    $('#search_customer, #search_date').on('input', fetchOrdersHistory);

                    $(document).ready(function () {
                        fetchOrdersHistory();

                        setInterval(fetchOrdersHistory, 1000)
                    });
                });


                $(document).on('click', '.customers-cards', function() {
                    var orderId = $(this).data('order-id'); // Get the order ID from the clicked card
                    console.log(orderId); 
                    // AJAX request to fetch the order details
                    $.ajax({
                        url: '../php/fetch_order_log_details.php', // PHP script to handle fetching order details
                        type: 'GET',
                        data: { order_id: orderId }, // Send the order ID
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update customer name and order date/time
                                $('.customer-name').text(response.customer_name);
                                $('.order-date').text(response.order_date);
                                $('.order-time').text(response.order_time);

                                // Clear the existing table data
                                $('.table-body').empty();

                                // Populate the table with the order details
                                $.each(response.order_details, function(index, detail) {
                                    $('.table-body').append(`
                                        <tr>
                                            <td>${detail.item_name}</td>
                                            <td>${detail.quantity}</td>
                                            <td>${detail.order_item_status}</td>
                                            <td>&#8369; ${detail.sub_total}</td>
                                        </tr>
                                    `);
                                });

                                // Update total, order status, and note
                                $('.total-section .total-field span').html(`&#8369; ${response.total_amount}`);
                                $('.total-section .total-field:first-of-type span').text(response.order_status);
                                $('#customer_note').val(response.customer_note);
                            } else {
                                console.log("Error fetching order details.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: " + status + error);
                        }
                    });
                });



            </script>
            <div class="popup-overlay"></div>
            <div class="delete-confirmation-overlay"></div>
            <div class="delete-confirmation-container">
            <div class="delete-confirmation-content">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <h1>Are you sure you want?</h1>
                <p>Removing this item in the inventory will cause inactivity of the product on the menu.</p>
                <div class="form-groups button-group confirmation-button">
                    <button class="confirm-delete">remove</button>
                    <button class="confirm-cancel">cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="pop-up-overlay logout-confirmation-overlay"></div>
    <div class="pop-up-container logout-confirmation-container">
        <div class="pop-up-content logout-confirmation-content">
            <i class="fa-solid fa-question"></i>
            <h1>Are you sure you want log out?</h1>
            <div class="pop-up-buttons logout-buttons">
                <a href="../public/logout.php" class="btn-first btn-yes">yes</a>
                <a href="#" class="btn-second btn-no">no</a>
            </div>
        </div>
    </div>
</div>
<script src="../js/sidenav.js"></script>
<!-- <script src="../js/menu_entry_panel.js"></script>
<script src="../js/popup_forms.js"></script>
<script src="../js/order_entry_panel.js"></script> -->
<script src="../js/logout.js"></script>
</body>
</html>