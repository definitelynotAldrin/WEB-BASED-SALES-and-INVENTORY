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
    <link rel="stylesheet" href="../css/settlement_panel.css">
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
                            <a href="../public/kitchen_dashboard.php">
                                <i class="fa-solid fa-kitchen-set"></i>
                                <span class="link-text">kitchen dashboard</span>
                            </a>
                        </li>
                        <li id="settlement" class="navbar-item">
                            <a href="../public/settlement_panel.php" class="active">
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
        <div class="alert error-message" id="error-container"></div>
        <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1>Let's seize the day! <span></span></h1>
                    <h4>Let's settle payments and make sales...</h4>
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
                            setInterval(fetchLowStockItems, 10000); // Refresh every 30 seconds
                        });

                        
                    </script>
                    <div class="profile">
                        <img src="../assets/me.jpg">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <script>
                function fetchOrders() {
                    $.ajax({
                        url: '../php/fetch_settlement_order.php', // PHP script to get today's orders
                        type: 'GET',
                        dataType: 'json',
                        success: function(orders) {
                            $('#orders-settlement').empty();
                            if (orders.length > 0) {
                                $.each(orders, function(index, order) {
                                    $('#orders-settlement').append(`
                                        <div class="card order-item-card">
                                            <div class="card-img-container">
                                                <img src="../assets/Profile (1).png" class="card-img order-img">
                                            </div>
                                            <div class="card-details order-card-details">
                                                <span class="card-name order-number">Table No. ${order.customer_table}</span>
                                            </div>
                                            <div class="card-buttons button-disable">
                                                <button class="btn-settle" data-order-id="${order.order_id}">settle</button>
                                                <button class="btn-credit" data-order-id="${order.order_id}">credit</button>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('#orders-settlement').append("<p>No orders available for today.</p>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error fetching orders: " + textStatus, errorThrown);
                        }
                    });
                }
                $(document).ready(function() {
                    fetchOrders();

                    setInterval(fetchOrders, 500);
                });
                



                $(document).ready(function() {
                    // Handle "Settle" button click
                    $(document).on('click', '.btn-settle', function() {
                        const orderId = $(this).data('order-id'); // Get the order ID from the button

                        // Send AJAX request to fetch the specific order details
                        $.ajax({
                            url: '../php/fetch_settlement_order_details.php', // Your PHP file for fetching order details
                            type: 'GET',
                            data: { order_id: orderId }, // Pass the order ID
                            dataType: 'json',
                            success: function(response) {
                                console.log(JSON.stringify(response)); // Debugging log
                            

                                if (response.success) {

                                    $('#order-id').val(orderId); // Set the value of the hidden input

                                    console.log(orderId);
                                    // Show the popup
                                    $('.popup-settlement-paid').fadeIn();
                                    $('.popup-overlay').fadeIn();

                                    // Populate the popup with the order data
                                    $('.popup-order-name span').text(response.customer_name);
                                    $('.popup-table-number').text(`Table No. ${response.table_number}`);


                                    // Empty the order summary table body before adding new data
                                    const tbody = $('.popup-card-table tbody');
                                    tbody.empty();

                                    // Loop through each order detail and append to the table
                                    response.order_details.forEach(function(orderDetail) {
                                        const row = `
                                            <tr>
                                                <td>${orderDetail.item_name}</td>
                                                <td>${orderDetail.quantity}</td>
                                                <td>&#x20B1;${orderDetail.sub_total}</td>
                                            </tr>
                                        `;
                                        tbody.append(row);
                                    });

                                    // Populate the total amount field
                                    let totalAmount = parseFloat(response.total_amount);
                                    $('#total-amount').val(totalAmount);
                                    $('#hidden-total-amount').val(totalAmount);
                                    

                                    // Handle discount checkbox
                                    $('#discount_box').on('change', function() {
                                        if ($(this).is(':checked')) {
                                            const discountedAmount = totalAmount * 0.80; // Apply 20% discount
                                            $('#total-amount').val(discountedAmount.toFixed(2));
                                            $('#discounted-amount').val(discountedAmount.toFixed(2));
                                        } else {
                                            $('#total-amount').val(totalAmount.toFixed(2)); // Reset to original total amount
                                            $('#discounted-amount').val('');
                                        }
                                    });

                                    // Calculate change on cash tendered input
                                    $('.popup-card-input-group input').on('input', function() {
                                        const cashTendered = parseFloat($(this).val()) || 0;
                                        const currentTotalAmount = parseFloat($('#total-amount').val());
                                        const change = (cashTendered - currentTotalAmount);
                                        $('#total-change').val(change > 0 ? change : 0);
                                    });

                                } else {
                                    alert('Failed to retrieve order details.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching order details:', error);
                            }
                        });
                    });

                    $(document).on('click', '.btn-credit', function() {
                        const orderId = $(this).data('order-id'); // Get the order ID from the button

                        // Send AJAX request to fetch the specific order details
                        $.ajax({
                            url: '../php/fetch_settlement_order_details.php', // Your PHP file for fetching order details
                            type: 'GET',
                            data: { order_id: orderId }, // Pass the order ID
                            dataType: 'json',
                            success: function(response) {
                                console.log(JSON.stringify(response)); // Debugging log
                            

                                if (response.success) {

                                    $('#credit-order-id').val(orderId); // Set the value of the hidden input

                                    console.log(orderId);
                                    // Show the popup
                                    $('.popup-settlement-credit').fadeIn();
                                    $('.popup-overlay').fadeIn();

                                    // Populate the popup with the order data
                                    $('.popup-order-name span').text(response.customer_name);
                                    $('.popup-table-number').text(`Table No. ${response.table_number}`);


                                    // Empty the order summary table body before adding new data
                                    const tbody = $('.popup-card-table tbody');
                                    tbody.empty();

                                    // Loop through each order detail and append to the table
                                    response.order_details.forEach(function(orderDetail) {
                                        const row = `
                                            <tr>
                                                <td>${orderDetail.item_name}</td>
                                                <td>${orderDetail.quantity}</td>
                                                <td>&#x20B1;${orderDetail.sub_total}</td>
                                            </tr>
                                        `;
                                        tbody.append(row);
                                    });

                                    // Populate the total amount field
                                    let totalAmount = parseFloat(response.total_amount);
                                    $('#credit-total-amount').val(totalAmount);

                                } else {
                                    alert('Failed to retrieve order details.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching order details:', error);
                            }
                        });
                    });

                    // Close the popup when overlay is clicked
                    $('.popup-overlay').on('click', function() {
                        $('.popup-settlement-paid').fadeOut();
                        $('.popup-settlement-credit').fadeOut();
                        $('.popup-view-settled-orders').fadeOut();
                        $('.popup-overlay').fadeOut();
                    });

                

                    $(document).on('click', '.button-pay', function() {
                        // Get the order_id from the hidden input field
                        const orderId = $('#order-id').val();
                        const totalAmount = $('#hidden-total-amount').val();
                        const discountedAmount = $('#discounted-amount').val(); // Retrieve already calculated discount
                        const cashTendered = $('#cash-tendered').val(); 
                        const changeDue = $('#total-change').val();
                        const paymentStatus = 'paid';

                        // Log the data to console for debugging
                        console.log("Order ID:", orderId);
                        console.log("Total Amount:", totalAmount);
                        console.log("Discounted Amount:", discountedAmount);
                        console.log("Cash Tendered:", cashTendered);
                        console.log("Change Due:", changeDue);

                        $('#question').text('Are you sure settling this order?');
                        $('.popup-confirmation-container').fadeIn(); // Show the popup
                        $('.popup-overlay').fadeIn();
                        $('.popup-overlay').css('pointer-events', 'none');

                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior

                            // Send the payment data via AJAX to save
                            $.ajax({
                                url: '../php/save_payment_as_paid.php',
                                type: 'POST',
                                dataType: 'json', // Specify that the response should be JSON
                                data: {
                                    order_id: orderId,
                                    hidden_total_amount: totalAmount,
                                    discounted_amount: discountedAmount,
                                    cash_tendered: cashTendered,
                                    change_due: changeDue,
                                    payment_status: paymentStatus
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        displaySuccessMessage('Payment successfully saved!');
                                        $('.popup-settlement-paid').fadeOut();
                                        $('.popup-confirmation-container').fadeOut();
                                        $('.popup-overlay').fadeOut();
                                        fetchOrders();
                                        fetchSettledOrders();
                                        $('#total-change').val('');
                                        $('#cash-tendered').val(''); 
                                        ('#discounted-amount').val('')
                                    } else {
                                        displayErrorMessage(response.message);
                                        $('.popup-confirmation-container').fadeOut();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // This will help debug any server errors
                                    console.log("AJAX Error:", error);
                                    displayErrorMessage('An unexpected error occurred.');
                                    $('.popup-confirmation-container').fadeOut();
                                }
                            });

                        });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').css('pointer-events', 'auto');
                        });

                    });

                    $(document).on('click', '.button-credit', function() {
                        // Get the order_id from the hidden input field
                        const orderId = $('#credit-order-id').val();
                        const totalAmount = $('#credit-total-amount').val();
                        const creditNote = $('#credit-note').val();
                        const paymentStatus = 'credit';

                        // Log the data to console for debugging
                        console.log("Order ID:", orderId);
                        

                        $('#question').text('Are you sure you want to save this order as credit?');
                        $('.popup-confirmation-container').fadeIn(); // Show the popup
                        $('.popup-overlay').fadeIn();
                        $('.popup-overlay').css('pointer-events', 'none');

                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior

                            // Send the payment data via AJAX to save
                            $.ajax({
                                url: '../php/save_payment_as_credit.php',
                                type: 'POST',
                                dataType: 'json', // Specify that the response should be JSON
                                data: {
                                    order_id: orderId,
                                    total_amount: totalAmount,
                                    credit_note: creditNote,
                                    payment_status: paymentStatus
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        displaySuccessMessage('Order successfully saved as credit!');
                                        $('.popup-settlement-credit').fadeOut();
                                        $('.popup-confirmation-container').fadeOut();
                                        $('.popup-overlay').fadeOut();
                                        fetchOrders();
                                        fetchSettledOrders();
                                    } else {
                                        displayErrorMessage(response.message);
                                        $('.popup-confirmation-container').fadeOut();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // This will help debug any server errors
                                    console.log("AJAX Error:", error);
                                    displayErrorMessage('An unexpected error occurred.');
                                    $('.popup-confirmation-container').fadeOut();
                                }
                            });

                        });

                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').css('pointer-events', 'auto');
                        });

                    });


                });

                


                function fetchSettledOrders() {
                    $.ajax({
                        url: '../php/fetch_settled_order.php', // PHP script to get today's orders
                        type: 'GET',
                        dataType: 'json',
                        success: function(orders) {
                            $('.settled-orders-container').empty(); // Clear existing orders
                            if (orders.length > 0) {
                                $.each(orders, function(index, order) {
                                    let indicatorText = ''; // Initialize indicator text

                                    // Determine which indicator to show
                                    if (order.payment_status === 'paid') {
                                        indicatorText = `
                                            <h3 class="card-text paid">
                                                <i class="fa-regular fa-circle-check"></i>
                                                <span>Paid</span>
                                            </h3>
                                        `;
                                    } else if (order.payment_status === 'credit') {
                                        indicatorText = `
                                            <h3 class="card-text credit">
                                                <i class="fa-regular fa-circle-check"></i>
                                                <span>Credit</span>
                                            </h3>
                                        `;
                                    }

                                    // Append the card with the relevant indicator text
                                    $('.settled-orders-container').append(`
                                        <div class="card order-serve-card">
                                            <div class="card-img-container">
                                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                                            </div>
                                            <div class="card-details order-card-details">
                                                <span class="card-name order-number">Table No. ${order.customer_table}</span>
                                            </div>
                                            <div class="card-buttons text-indicator">
                                                <button class="btn-view" data-order-id="${order.order_id}">View Orders</button>
                                                ${indicatorText} <!-- Insert the indicator here -->
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('.settled-orders-container').append("<p>No orders available for today.</p>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error fetching orders: " + textStatus, errorThrown);
                        }
                    });
                }

                $(document).ready(function() {
                    fetchSettledOrders();
                    
                });


                $(document).on('click', '.btn-view', function() {
                    const orderId = $(this).data('order-id');

                    $.ajax({
                        url: '../php/fetch_settled_order_details.php',
                        type: 'GET',
                        data: { order_id: orderId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#order-id').val(orderId);

                                $('.popup-view-settled-orders').fadeIn();
                                $('.popup-overlay').fadeIn();

                                $('.popup-order-name span').text(response.customer_name);
                                $('.popup-table-number').text(`Table No. ${response.table_number}`);

                                const tbody = $('.popup-card-table tbody');
                                tbody.empty();

                                response.order_details.forEach(function(orderDetail) {
                                    const row = `
                                        <tr>
                                            <td>${orderDetail.item_name}</td>
                                            <td>${orderDetail.quantity}</td>
                                            <td>&#x20B1;${orderDetail.sub_total}</td>
                                        </tr>
                                    `;
                                    tbody.append(row);
                                });

                                // Set the values in the payment fields
                                $('#display-total-amount').val(response.total_amount);
                                $('#display-total-discounted-amount').val(response.discounted_amount);
                                $('#display-cash-tendered').val(response.cash_tendered);
                                $('#display-total-change').val(response.change_due);
                                $('#display-credit-note').val(response.credit_note);

                                // Check payment status and toggle field visibility
                                if (response.payment_status === 'credit') {
                                    $('#display-cash-tendered').closest('.popup-card-group').hide();
                                    $('#display-total-change').closest('.popup-card-group').hide();
                                    $('#display-total-discounted-amount').closest('.popup-card-group').hide();
                                    $('#display-credit-note').closest('.popup-card-group').show();
                                } else if (response.payment_status === 'paid') {
                                    $('#display-cash-tendered').closest('.popup-card-group').show();
                                    $('#display-total-change').closest('.popup-card-group').show();
                                    $('#display-total-discounted-amount').closest('.popup-card-group').show();
                                    $('#display-credit-note').closest('.popup-card-group').hide();
                                }
                            } else {
                                displayErrorMessage('Failed to retrieve order details.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching order details:', error);
                        }
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
                <div class="first-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">unpaid</h1>
                    </div>
                    <div class="first-panel-cards-container orders-cards-container" id="orders-settlement">
                        
                    </div> 
                </div>
                <div class="popup-card-container popup-settlement-paid">
                    <div class="popup-card-header">
                       <div class="popup-card-header-row">
                            <h1 class="popup-order-title">Checkout</h1>
                       </div>
                       <div class="popup-card-header-col">
                            <h1 class="popup-table-number">table No.</h1>
                            <h1 class="popup-order-name">Customer name: <span></span></h1>
                            <input type="hidden" name="order_id" id="order-id" value="">
                            <input type="hidden" name="discounted_amount" id="discounted-amount">
                            <input type="hidden" name="hidden_total_amount" id="hidden-total-amount">
                       </div>
                    </div>
                    <div class="popup-card-content">
                        <div class="popup-card-table-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order name</th>
                                            <th>quantity</th>
                                            <th>sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="popup-card-payment-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-group-container">
                                <div class="popup-card-groups">
                                    <div class="popup-card-group">
                                        <div class="popup-card-label">
                                            <label>Total</label>
                                            <div class="popup-card-label-discount">
                                                <label>apply discount</label>
                                                <input type="checkbox" name="discount_box" id="discount_box">
                                            </div>
                                        </div>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" disabled id="total-amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-card-groups">
                                    <div class="popup-card-group">
                                        <label>Cash Tendered</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" id="cash-tendered">
                                        </div>
                                    </div>
                                    <div class="popup-card-group">
                                        <label>Change</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" disabled id="total-change">
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-card-button">
                                    <button class="button-pay">
                                        <span>pay & save</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- -------------------------credit settlement-------------------------------------- -->

                <div class="popup-card-container popup-settlement-credit">
                    <div class="popup-card-header">
                       <div class="popup-card-header-row">
                            <h1 class="popup-order-title">credit process</h1>
                       </div>
                       <div class="popup-card-header-col">
                            <h1 class="popup-table-number"></h1>
                            <h1 class="popup-order-name">Customer name: <span></span></h1>
                            <input type="hidden" name="order_id" id="credit-order-id">
                       </div>
                    </div>
                    <div class="popup-card-content">
                        <div class="popup-card-table-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order name</th>
                                            <th>quantity</th>
                                            <th>sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="popup-card-payment-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-group-container">
                                <div class="popup-card-group">
                                    <label for="">total</label>
                                    <div class="popup-card-input-group">
                                        <span>&#x20B1;</span>
                                        <input type="number" step="1" min="0" id="credit-total-amount">
                                    </div>
                                </div>
                                <div class="popup-card-group">
                                    <label for="">additional note</label>
                                    <textarea name="credit_note" id="credit-note" cols="20"></textarea>
                                </div>
                                <div class="popup-card-button">
                                    <button class="button-credit">
                                        <span>save as credit</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">paid / credit</h1>
                    </div>
                    <div class="second-panel-card-container settled-orders-container">
                                           
                    </div>
                </div>

                <div class="popup-card-container popup-view-settled-orders">
                    <div class="popup-card-header">
                       <div class="popup-card-header-row">
                            <h1 class="popup-order-title">Checkout</h1>
                       </div>
                       <div class="popup-card-header-col">
                            <h1 class="popup-table-number">table No.</h1>
                            <h1 class="popup-order-name">Customer name: <span></span></h1>
                       </div>
                    </div>
                    <div class="popup-card-content">
                        <div class="popup-card-table-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order name</th>
                                            <th>quantity</th>
                                            <th>sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="popup-card-payment-container">
                            <h1 class="popup-card-content-title">order summary</h1>
                            <div class="popup-card-group-container">
                                <div class="popup-card-groups">
                                    <div class="popup-card-group">
                                        <label>Total</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" disabled id="display-total-amount">
                                        </div>
                                    </div>
                                    <div class="popup-card-group">
                                        <label>Discounted Amount</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" disabled id="display-total-discounted-amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-card-groups">
                                    <div class="popup-card-group">
                                        <label>Cash Tendered</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" id="display-cash-tendered" disabled>
                                        </div>
                                    </div>
                                    <div class="popup-card-group">
                                        <label>Change</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0" disabled id="display-total-change">
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-card-group" style="display: none;">
                                    <label for="">additional note</label>
                                    <textarea name="credit_note" id="display-credit-note" cols="20"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pop-up-container popup-confirmation-container">
                    <div class="pop-up-content popup-confirmation-content">
                        <i class="fa-solid fa-question"></i>
                        <h1 id="question"></h1>
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
<!-- <script src="../js/settlement_panel.js"></script> -->
<script src="../js/logout.js"></script>
</body>
</html>