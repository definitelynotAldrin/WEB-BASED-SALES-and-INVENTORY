<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];

if(!isset($account_id)){
   header('location: ../public/login_panel.php');
}

if ($user_role !== 'user_admin' &&  $user_role !== 'user_kitchen') {
    // Redirect to login or error page if user does not have the right role
    header('Location: ../public/login_panel');
    exit();
}


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

        // var allButtons = document.querySelectorAll('.button-disable');
        // allButtons.forEach(function(disButtons){
        //     disButtons.style.display = 'none';
        //     disButtons.style.pointerEvents = 'none';
        // });
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
    <link rel="stylesheet" href="../css/kitchen_dashboard.css">
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
                            <a href="../public/menu_entry.php">
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
                            <a href="../public/order_log.php">
                                <i class="fa-solid fa-box-archive"></i>
                                <span class="link-text">order log</span>
                            </a>
                        </li>
                        <li id="kitchen" class="navbar-item">
                            <a href="../public/kitchen_dashboard.php" class="active">
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
            <?php if(isset($_GET['success'])){ ?>
                <div class="success alert-success" role="success">
                <?php echo $_GET['success']; ?>
                </div>
            <?php } ?>
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
                </div>
            <?php } ?>
            <div class="alert error-message" id="error-container"></div>
            <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1>Let's seize the day! <span></span></h1>
                    <h4>Let's cook orders and make sales...</h4>
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
                                                        <p><span>Stock Alert:</span> This item is running low. <br>Only <span>${item.stock_quantity}</span> available.</p>
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
            <script>
                function fetchPrepareOrders() {
                    $.ajax({
                        url: '../php/fetch_prepare_status.php', // PHP script to get today's orders
                        type: 'GET',
                        dataType: 'json',
                        success: function(orders) {
                            $('#prepare-card-container').empty(); // Clear existing orders
                            if (orders.length > 0) {
                                $.each(orders, function(index, order) {
                                    $('#prepare-card-container').append(`
                                        <div class="card order-item-card">
                                            <div class="card-img-container">
                                                <img src="../assets/Profile (1).png" class="card-img order-img">
                                            </div>
                                            <div class="card-details order-card-details">
                                                <span class="card-name order-number">Table No. ${order.customer_table}</span>
                                            </div>
                                            <div class="card-buttons button-disable">
                                                <button class="btn-cancel" id="cancel-order-button" data-order-id="${order.order_id}">Cancel</button>
                                                <button class="btn-view view-prepare-orders" data-order-id="${order.order_id}">View Order</button>
                                                <button class="btn-confirm" data-order-id="${order.order_id}">Confirm</button>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('#prepare-card-container').append("<p>No orders available for today.</p>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error fetching orders: " + textStatus, errorThrown);
                        }
                    });
                }

                function fetchProcessOrders() {
                    $.ajax({
                        url: '../php/fetch_process_status.php', // PHP script to get today's orders
                        type: 'GET',
                        dataType: 'json',
                        success: function(orders) {
                            $('#process-card-container').empty(); // Clear existing orders
                            if (orders.length > 0) {
                                $.each(orders, function(index, order) {
                                    $('#process-card-container').append(`
                                        <div class="card order-item-card">
                                            <div class="card-img-container">
                                                <img src="../assets/me2.jpg" class="card-img order-img">
                                            </div>
                                            <div class="card-details order-card-details">
                                                <span class="card-name order-number">Table No. ${order.customer_table}</span>
                                            </div>
                                            <div class="card-buttons button-disable">
                                                <button class="btn-cancel" id="cancel-process-order" data-order-id="${order.order_id}">Cancel</button>
                                                <button class="btn-view view-process-orders" data-order-id="${order.order_id}">View Order</button>
                                                <button class="btn-serve" data-order-id="${order.order_id}">serve</button>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('#process-card-container').append("<p>No orders available for today.</p>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error fetching orders: " + textStatus, errorThrown);
                        }
                    });
                }
                function fetchServedOrders() {
                    $.ajax({
                        url: '../php/fetch_served_status.php', // PHP script to get today's orders
                        type: 'GET',
                        dataType: 'json',
                        success: function(orders) {
                            $('#served-card-container').empty(); // Clear existing orders
                            if (orders.length > 0) {
                                $.each(orders, function(index, order) {
                                    $('#served-card-container').append(`
                                        <div class="card order-item-card">
                                            <div class="card-img-container">
                                                <img src="../assets/me2.jpg" class="card-img order-img">
                                            </div>
                                            <div class="card-details order-card-details">
                                                <span class="card-name order-number">Table No. ${order.customer_table}</span>
                                            </div>
                                            <div class="card-buttons button-disable">
                                                <button class="btn-view view-served-orders" data-order-id="${order.order_id}">View Order</button>
                                                <span class="serve-text" data-order-id="${order.order_id}">served</span>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('#served-card-container').append("<p>No orders available for today.</p>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error fetching orders: " + textStatus, errorThrown);
                        }
                    });
                }

                $(document).ready(function() {
                    fetchPrepareOrders();
                    fetchProcessOrders();
                    fetchServedOrders();

                    setInterval(fetchPrepareOrders, 1000);
                    setInterval(fetchProcessOrders, 1000);
                    setInterval(fetchServedOrders, 1000);
                });


                $(document).ready(function() {
                    // Function to fetch order details and show them in the popup
                    function fetchPrepareOrderDetails(orderId) {
                        $.ajax({
                            url: '../php/fetch_order_detail_prepare.php',  // Adjust this PHP script path as needed
                            type: 'GET',
                            data: { order_id: orderId },
                            dataType: 'json',
                            success: function(order) {
                                // Check if there was an error
                                if (order.error) {
                                    alert(order.error); // Show error message if there's an issue
                                    return;
                                }

                                // Populate the order info in the popup
                                $('#popup-order-id').text(order.order_id);
                                $('#popup-customer-name').val(order.customer_name);
                                $('#popup-customer-note').val(order.customer_note);

                                // Populate order items in the table
                                const orderItemsContainer = $('#popup-order-items');
                                orderItemsContainer.empty(); // Clear previous items

                                $.each(order.items, function(index, item) {
                                    orderItemsContainer.append(`
                                        <tr>
                                            <td>${item.item_name}</td>
                                            <td>${item.quantity}</td>
                                        </tr>
                                    `);
                                });

                                // Show the popup
                                $('.popup-card-container.popup-order-view').fadeIn();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error fetching order details: ' + textStatus, errorThrown);
                            }
                        });
                    }

                    function fetchProcessOrderDetails(orderId) {
                        $.ajax({
                            url: '../php/fetch_order_detail_process.php',  // Adjust this PHP script path as needed
                            type: 'GET',
                            data: { order_id: orderId },
                            dataType: 'json',
                            success: function(order) {
                                // Check if there was an error
                                if (order.error) {
                                    alert(order.error); // Show error message if there's an issue
                                    return;
                                }

                                // Populate the order info in the popup
                                $('#popup-order-id').text(order.order_id);
                                $('#popup-customer-name').val(order.customer_name);
                                $('#popup-customer-note').val(order.customer_note);

                                // Populate order items in the table
                                const orderItemsContainer = $('#popup-order-items');
                                orderItemsContainer.empty(); // Clear previous items

                                $.each(order.items, function(index, item) {
                                    orderItemsContainer.append(`
                                        <tr>
                                            <td>${item.item_name}</td>
                                            <td>${item.quantity}</td>
                                        </tr>
                                    `);
                                });

                                // Show the popup
                                $('.popup-card-container.popup-order-view').fadeIn();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error fetching order details: ' + textStatus, errorThrown);
                            }
                        });
                    }

                    function fetchServedOrderDetails(orderId) {
                        $.ajax({
                            url: '../php/fetch_order_detail_served.php',  // Adjust this PHP script path as needed
                            type: 'GET',
                            data: { order_id: orderId },
                            dataType: 'json',
                            success: function(order) {
                                // Check if there was an error
                                if (order.error) {
                                    alert(order.error); // Show error message if there's an issue
                                    return;
                                }

                                // Populate the order info in the popup
                                $('#popup-order-id').text(order.order_id);
                                $('#popup-customer-name').val(order.customer_name);
                                $('#popup-customer-note').val(order.customer_note);

                                // Populate order items in the table
                                const orderItemsContainer = $('#popup-order-items');
                                orderItemsContainer.empty(); // Clear previous items

                                $.each(order.items, function(index, item) {
                                    orderItemsContainer.append(`
                                        <tr>
                                            <td>${item.item_name}</td>
                                            <td>${item.quantity}</td>
                                        </tr>
                                    `);
                                });

                                // Show the popup
                                $('.popup-card-container.popup-order-view').fadeIn();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error fetching order details: ' + textStatus, errorThrown);
                            }
                        });
                    }

                    // Bind click event to the btn-view
                    $(document).on('click', '.view-prepare-orders', function() {
                        const orderId = $(this).data('order-id');
                        fetchPrepareOrderDetails(orderId); // Call the function to fetch and display order details
                        $('.popup-overlay').fadeIn();
                    });

                    $(document).on('click', '.view-process-orders', function() {
                        const orderId = $(this).data('order-id');
                        fetchProcessOrderDetails(orderId); // Call the function to fetch and display order details
                        $('.popup-overlay').fadeIn();
                    });

                    $(document).on('click', '.view-served-orders', function() {
                        const orderId = $(this).data('order-id');
                        fetchServedOrderDetails(orderId);
                        $('.popup-overlay').fadeIn(); // Call the function to fetch and display order details
                    });


                    // Close the popup when the close button is clicked
                    $(document).on('click', '.btn-close', function() {
                        $('.popup-card-container.popup-order-view').hide(); // Hide the popup
                        $('.popup-overlay').fadeOut();
                    });

                    $(document).on('click', '.popup-overlay', function() {
                        $('.popup-card-container.popup-order-view').hide(); // Hide the popup
                        $('.popup-overlay').fadeOut();
                        $('.popup-confirmation-container').fadeOut();
                    });
                });


                // Assuming jQuery is being used for the AJAX call
                $(document).on('click', '#cancel-order-button', function() {
                    var orderId = $(this).data('order-id');
                    $('#question').text('Are you sure you want to cancel this order?');
                    $('.popup-confirmation-container').fadeIn(); // Show the popup
                    $('.popup-overlay').fadeIn();

                    $('.btnConfirm').off('click').on('click', function(e) {
                        e.preventDefault(); // Prevent default link behavior

                        // Send AJAX request to update order status
                        $.ajax({
                            url: '../php/cancel_order.php', // Ensure this path is correct
                            type: 'POST',
                            data: { order_id: orderId },
                            success: function(response) {
                                // Parse JSON response
                                var res = JSON.parse(response);

                                if (res.success) {
                                    // Handle success: You can display a message or reload the page
                                    displaySuccessMessage('Order canceled successfully.');
                                    fetchPrepareOrders();
                                } else {
                                    // Handle error
                                    alert('Error: ' + res.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle AJAX error
                                console.error('AJAX Error: ' + status + ' - ' + error);
                                alert('Failed to cancel the order.');
                            }
                        });

                        // Hide the popup after confirming
                        $('.popup-confirmation-container').fadeOut();
                        $('.popup-overlay').fadeOut();
                    });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });

                });





                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '.btn-confirm', function() {
                        var orderId = $(this).data('order-id'); // Get the order ID from the button

                        // Show the custom confirmation popup
                        $('.popup-confirmation-container').fadeIn(); // Show the popup
                        $('.popup-overlay').fadeIn();

                        // Handle confirmation (yes button)
                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior

                            // Send AJAX request to update order status
                            $.ajax({
                                url: '../php/confirm_order.php',  // Path to your PHP script
                                type: 'POST',
                                data: { order_id: orderId },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        displaySuccessMessage('Order confirmed successfully.');
                                        // You can refresh the page or update the UI as needed
                                        fetchPrepareOrders();
                                        fetchProcessOrders();
                                        fetchServedOrders();
                                    } else {
                                        alert('Failed to confirm order: ' + response.error);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error confirming order: ' + textStatus, errorThrown);
                                }
                            });

                            // Hide the popup after confirming
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });
                    });
                });

                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '#cancel-process-order', function() {
                        var orderId = $(this).data('order-id'); // Get the order ID from the button

                        // Show the custom confirmation popup
                        $('#question').text('Are you sure you want to cancel processing this order?');
                        $('.popup-confirmation-container').fadeIn(); // Show the popup
                        $('.popup-overlay').fadeIn();

                        // Handle confirmation (yes button)
                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior

                            // Send AJAX request to update order status
                            $.ajax({
                                url: '../php/cancel_process_order.php',  // Path to your PHP script
                                type: 'POST',
                                data: { order_id: orderId },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        displaySuccessMessage('Process order cancelled!.');
                                        // You can refresh the page or update the UI as needed
                                        fetchPrepareOrders();
                                        fetchProcessOrders();
                                        fetchServedOrders();
                                    } else {
                                        alert('Failed to confirm order: ' + response.error);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error confirming order: ' + textStatus, errorThrown);
                                }
                            });

                            // Hide the popup after confirming
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });
                    });
                });


                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '.btn-serve', function() {
                        var orderId = $(this).data('order-id'); // Get the order ID from the button

                        $('#question').text('Are you sure you want to serve this order?');
                        // Show the custom confirmation popup
                        $('.popup-confirmation-container').fadeIn(); // Show the popup
                        $('.popup-overlay').fadeIn();

                        // Handle confirmation (yes button)
                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior

                            // Send AJAX request to update order status
                            $.ajax({
                                url: '../php/served_order.php',  // Path to your PHP script
                                type: 'POST',
                                data: { order_id: orderId },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        displaySuccessMessage('Order served successfully.');
                                        // You can refresh the page or update the UI as needed
                                        fetchPrepareOrders();
                                        fetchProcessOrders();
                                        fetchServedOrders();
                                    } else {
                                        alert('Failed to confirm order: ' + response.error);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error confirming order: ' + textStatus, errorThrown);
                                }
                            });

                            // Hide the popup after confirming
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                        });
                    });
                });
                    function displaySuccessMessage(message1) {
                        // Create a div to hold the success message
                        const messageDiv = $('<div class="success-message"></div>').text(message1);
                        
                        // Append the message to a specific container in your HTML
                        $('#success-container').html(messageDiv);
                        $('#success-container').removeClass('fadeOut').addClass('fadeIn');

                        // Optionally, remove the message after a few seconds
                        setTimeout(() => {
                            $('#success-container').removeClass('fadeIn').addClass('fadeOut'); // Fade out the message
                        }, 3000); // Change the duration as needed
                    }

                    function displayErrorMessage(message2) {
                        // Create a div to hold the success message
                        const messageDiv = $('<div class="error-message"></div>').text(message2);
                        
                        // Append the message to a specific container in your HTML
                        $('#error-container').html(messageDiv);
                        $('#error-container').removeClass('fadeOut').addClass('fadeIn');

                        // Optionally, remove the message after a few seconds
                        setTimeout(() => {
                            $('#error-container').removeClass('fadeIn').addClass('fadeOut'); // Fade out the message
                        }, 3000); // Change the duration as needed
                    }

            </script>
            <div class="menu-section-container">
                <div class="orders-panel first-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">to prepare</h1>
                        <div class="order-tabs">
                            <button class="button-tabs buttonPrepare">to prepare</button>
                            <button class="button-tabs buttonProcess">to process</button>
                            <button class="button-tabs buttonServed">served</button>
                        </div>
                    </div>
                    <div class="first-panel-cards-container order-cards-container" id="prepare-card-container">
                        
                    </div> 
                </div>

    <!-- -------------------------Process Section---------------------------- -->

                <div class="orders-panel second-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">to process</h1>
                        <div class="order-tabs">
                            <button class="button-tabs buttonPrepare">to prepare</button>
                            <button class="button-tabs buttonProcess">to process</button>
                            <button class="button-tabs buttonServed">served</button>
                        </div>
                    </div>
                    <div class="first-panel-cards-container order-cards-container" id="process-card-container">
                        
                    </div> 
                </div>

    <!-- -------------------------Serve Section---------------------------- -->

                <div class="orders-panel third-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">served</h1>
                        <div class="order-tabs">
                            <button class="button-tabs buttonPrepare">to prepare</button>
                            <button class="button-tabs buttonProcess">to process</button>
                            <button class="button-tabs buttonServed">served</button>
                        </div>
                    </div>
                    <div class="third-panel-cards-container order-serve-section" id="served-card-container">
                        
                    </div>
                </div>

                <!-- --------------------Popup View-------------------- -->
                <div class="popup-card-container popup-order-view">
                    <div class="popup-card-header">
                        <!-- <h1 class="popup-order-title">Order # <span id="popup-order-id">0000</span></h1> -->
                        <i class="fa-regular fa-circle-xmark btn-close"></i>
                    </div>
                    <div class="popup-card-content">
                        <div class="popup-card-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="popup-order-items">
                                    <!-- Order items will be populated here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="popup-card-textarea">
                            <div class="card-textarea">
                                <h3>Customer name</h3>
                                <textarea class="customer-name" id="popup-customer-name" disabled></textarea>
                            </div>
                            <div class="card-textarea">
                                <h3>Note</h3>
                                <textarea id="popup-customer-note" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pop-up-container popup-confirmation-container">
                    <div class="pop-up-content popup-confirmation-content">
                        <i class="fa-solid fa-question"></i>
                        <h1 id="question">Are you want to process this order?</h1>
                        <div class="pop-up-buttons logout-buttons">
                            <a href="#" class="btn-second btnCancel">no</a>
                            <a href="#" class="btn-first btnConfirm">yes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-overlay"></div>
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
<!-- <script src="../js/kitchen_panel.js"></script> -->
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
<script src="../js/order_tabs.js"></script>
</body>
</html>