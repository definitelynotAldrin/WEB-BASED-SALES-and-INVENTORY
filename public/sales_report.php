<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];
$username = $_SESSION['account_username'];

if(!isset($account_id)){
   header('location: ../public/login_panel.php');
}

if ($user_role !== 'user_admin') {
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
        var allowedNavs = ['kitchen', 'settlement'];

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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../assets/Sea Sede (200 x 200 px).png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.min.css">
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
                            <a href="../public/index" class="active">
                                <i class="fa-solid fa-border-all"></i>
                                <span class="link-text">dashboard</span>
                            </a>
                        </li>
                        <li id="menu_entry" class="navbar-item">
                            <a href="../public/menu_entry">
                                <i class="fa-solid fa-shrimp"></i>
                                <span class="link-text">Menu data entry</span>
                            </a>
                        </li>
                        <li id="stocks_entry" class="navbar-item">
                            <a href="../public/stocks_entry">
                                <i class="fa-solid fa-cubes"></i>
                                <span class="link-text">stocks data entry</span>
                            </a>
                        </li>
                        <li id="order_entry" class="navbar-item">
                            <a href="../public/order_entry">
                                <i class="fa-solid fa-rectangle-list"></i>
                                <span class="link-text">order data entry</span>
                            </a>
                        </li>
                        <li id="order_log" class="navbar-item">
                            <a href="../public/order_log">
                                <i class="fa-solid fa-box-archive"></i>
                                <span class="link-text">order log</span>
                            </a>
                        </li>
                        <li id="kitchen" class="navbar-item">
                            <a href="../public/kitchen_dashboard">
                                <i class="fa-solid fa-kitchen-set"></i>
                                <span class="link-text">kitchen dashboard</span>
                            </a>
                        </li>
                        <li id="settlement" class="navbar-item">
                            <a href="../public/settlement_panel">
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
            <div class="content-header">
                <div class="header-text">
                    <h1>Sales Report<span></span></h1>
                    <h4>Let's check sales performances & analytics.</h4>
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
                    <div class="message-icon-container">
                        <i class="fa-solid fa-message message-button">
                            <i class="fa-solid fa-circle notification-alert-icon" style="display: none;"></i>
                        </i>

                        <div class="notification-container message-container sales-report-notif">
                            <div class="notification-main-wrapper message-wrapper">
                                <div class="notification-header">
                                    <h1>Kan-anan by the Sea Group Chat</h1>
                                </div>
                                <div class="notification-message-wrapper">
                                    <!-- <div class="notification-group replier-group left-box">
                                        <div class="notification-details left-box">
                                            <span class="notification-username">The brightest</span>
                                            <span class="notification-time">2024-11-03 05:24:02</span> 
                                        </div>
                                        <div class="notification-box message-box">
                                            <p class="notification-message">Sorry, my brighterr..</p>
                                        </div>
                                    </div>
                                    <div class="notification-group sender-group right-box">
                                        <div class="notification-details right-details">
                                            <span class="notification-time">2024-11-03 05:24:02</span>
                                            <span class="notification-username">Joel</span>
                                        </div>
                                        <div class="notification-box message-box">
                                            <p class="notification-message">:<</p>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="notification-bottom-box message-input-area">
                                    <input type="text" name="" id="message-input" placeholder="Type a message...">
                                    <button type="button" class="send-message-button">Send</button>
                                </div>
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

                        $(document).ready(function() {
                            // Function to load messages
                            sessionUserRole = "<?php echo $username; ?>";
                            function loadMessages() {
                                $.ajax({
                                    url: '../php/fetch_messages.php', // Separate PHP script to fetch messages if needed
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            // Clear the current messages
                                            $('.notification-message-wrapper').empty();
                                            response.messages.forEach(function(message) {
                                                $('.notification-message-wrapper').append(
                                                    `<div class="notification-group ${message.username === sessionUserRole ? 'sender-group right-box' : 'replier-group left-box'}">
                                                        <div class="notification-details ${message.username === sessionUserRole ? 'right-details' : 'left-box'}">
                                                            <span class="notification-username">${message.username}</span>
                                                            <span class="notification-time">${message.user_role}</span>
                                                            <span class="notification-time">${message.timestamp}</span>
                                                        </div>
                                                        <div class="notification-box message-box">
                                                            <p class="notification-message">${message.text_message}</p>
                                                        </div>
                                                    </div>`
                                                );
                                            });
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                            }

                            // Initial load of messages
                            loadMessages();

                            // Poll for new messages every 5 seconds
                            setInterval(loadMessages, 5000);

                            // Send message on button click
                            $(document).on('click', '.send-message-button', function() {
                                var username = "<?php echo $username; ?>"; // Assumes $user_role is set in PHP
                                var user_role = "<?php echo $user_role; ?>";
                                var textMessage = $('#message-input').val();

                                console.log(username, user_role)
                                if (textMessage.trim() === "") {
                                    displayErrorMessage("Please enter a message.");
                                    return;
                                }

                                $('.notification-message-wrapper').scrollTop($('.notification-message-wrapper')[0].scrollHeight);

                                $.ajax({
                                    url: '../php/send_message.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        user_role: user_role,
                                        username: username,
                                        text_message: textMessage
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // Display new messages without waiting for the interval
                                            loadMessages();
                                            $('#message-input').val(''); // Clear input after sending
                                        } else {
                                            displayErrorMessage("Failed to send message: " + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                            });
                        });

                        
                        $(document).on('click', '.message-button', function() {
                            $('.message-container').fadeToggle();
                            $('.notification-message-wrapper').scrollTop($('.notification-message-wrapper')[0].scrollHeight);
                        });

                        $(document).ready(function () {
                            const $salesReportsCheckbox = $('#sales-reports');
                            const $otherCheckboxes = $('#orders-reports, #menu-reports, #daily-sales-reports');

                            function toggleCheckboxes() {
                                if ($salesReportsCheckbox.is(':checked')) {
                                    $otherCheckboxes.prop('disabled', true).prop('checked', false);
                                } else {
                                    $otherCheckboxes.prop('disabled', false);
                                }

                                if ($otherCheckboxes.is(':checked')) {
                                    $salesReportsCheckbox.prop('disabled', true);
                                } else {
                                    $salesReportsCheckbox.prop('disabled', false);
                                }
                            }

                            // Trigger toggle function when checkboxes are clicked
                            $salesReportsCheckbox.on('change', toggleCheckboxes);
                            $otherCheckboxes.on('change', toggleCheckboxes);

                            // Automatically set date to today when any checkbox is selected
                            $('input[type="checkbox"]').on('change', function () {
                                const today = new Date();
                                today.setHours(today.getHours() + 8); // Adjust for Philippine Time Zone (UTC+8)
                                const localDate = today.toISOString().split('T')[0];
                                $('#start-date, #end-date').val(localDate);
                            });

                        });


                        function generateReport() {
                            const startDate = $('#start-date').val();
                            const endDate = $('#end-date').val();
                            const reportOptions = {
                                salesReports: $('#sales-reports').is(':checked'),
                                ordersReports: $('#orders-reports').is(':checked'),
                                menuReports: $('#menu-reports').is(':checked'),
                                dailySalesReports: $('#daily-sales-reports').is(':checked'),
                            };

                            $.ajax({
                                type: "POST",
                                url: "../reports/reports.php",
                                data: {
                                    start_date: startDate,
                                    end_date: endDate,
                                    reportOptions: JSON.stringify(reportOptions)
                                },
                                success: function () {
                                    window.location.href = `../reports/reports.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}&reportOptions=${encodeURIComponent(JSON.stringify(reportOptions))}`;
                                },
                                error: function () {
                                    alert("Failed to generate report. Please try again.");
                                }
                            });
                        }


                        function generateOrdersReport() {
                            const startDate = document.getElementById('orders-start-date').value;
                            const endDate = document.getElementById('orders-end-date').value;

                            // Send dates to the server using AJAX
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "../reports/orders_reports.php", true);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            // Define what to do when a response is received
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Assuming the PHP script returns a URL to redirect to
                                    window.location.href = `../reports/orders_reports.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                                } else {
                                    alert("Failed to generate report. Please try again.");
                                }
                            };

                            // Send start and end dates to the PHP file
                            xhr.send(`start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`);
                        }


                        function generateProductsReport() {
                            const startDate = document.getElementById('top-product-start-date').value;
                            const endDate = document.getElementById('top-product-end-date').value;

                            // Send dates to the server using AJAX
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "../reports/top_products.php", true);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            // Define what to do when a response is received
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Assuming the PHP script returns a URL to redirect to
                                    window.location.href = `../reports/top_products.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                                } else {
                                    alert("Failed to generate report. Please try again.");
                                }
                            };

                            // Send start and end dates to the PHP file
                            xhr.send(`start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`);
                        }

                        function generateDailyReport() {
                            const startDate = document.getElementById('daily-start-date').value;
                            const endDate = document.getElementById('daily-end-date').value;

                            // Send dates to the server using AJAX
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "../reports/daily_sales_reports.php", true);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            // Define what to do when a response is received
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Assuming the PHP script returns a URL to redirect to
                                    window.location.href = `../reports/daily_sales_reports.php?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                                } else {
                                    alert("Failed to generate report. Please try again.");
                                }
                            };

                            // Send start and end dates to the PHP file
                            xhr.send(`start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`);
                        }


                        
                    </script>
                    <div class="profile">
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
        
            <div class="header-cards-container">
                <div class="header-card entire-sales-report">
                    <div class="header-card-group">
                        <h3>Sales Report</h3>
                    </div>
                    <div class="checkbox-container">
                        <div class="checkbox-group">
                            <input type="checkbox" name="" id="sales-reports">
                            <label for="">Entire Sales Reports</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" name="" id="orders-reports">
                            <label for="">Orders Sales Report</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" name="" id="menu-reports">
                            <label for="">Top Menu</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" name="" id="daily-sales-reports">
                            <label for="">Daily Sales</label>
                        </div>
                    </div>
                    <div class="header-card-group">
                        <div class="header-date-group">
                            <label for="start">Start Date</label>
                            <input type="date" id="start-date">
                        </div>
                        <div class="header-date-group">
                            <label for="end">End Date</label>
                            <input type="date" id="end-date">
                        </div>
                    </div>
                    <div class="header-card-button">
                        <button type="button" class="button-button generate-sales" onclick="generateReport()">Generate</button>
                    </div>
                </div>
                <!-- <div class="header-card orders-sales-report">
                    <div class="header-card-group">
                        <h3>orders sales report</h3>
                    </div>
                    <div class="header-card-group">
                        <div class="header-date-group">
                            <label for="start">start date</label>
                            <input type="date" id="orders-start-date">
                        </div>
                        <div class="header-date-group">
                            <label for="end">end date</label>
                            <input type="date" id="orders-end-date">
                        </div>
                    </div>
                   <div class="header-card-button">
                        <button type="button" class="button-button btnGenerate" onclick="generateOrdersReport()">generate</button>
                   </div>
                </div> -->
            </div>
            <!-- <div class="header-cards-container reports-container">
                <div class="header-card entire-sales-report">
                    <div class="header-card-group">
                        <h3>Top Product Sales Report</h3>
                    </div>
                    <div class="header-card-group">
                        <div class="header-date-group">
                            <label for="start">Start Date</label>
                            <input type="date" id="top-product-start-date">
                        </div>
                        <div class="header-date-group">
                            <label for="end">End Date</label>
                            <input type="date" id="top-product-end-date">
                        </div>
                    </div>
                    <div class="header-card-button">
                        <button type="button" class="button-button generate-sales" onclick="generateProductsReport()">Generate</button>
                    </div>
                </div>
                <div class="header-card daily-sales-report">
                    <div class="header-card-group">
                        <h3>daily sales report</h3>
                    </div>
                    <div class="header-card-group">
                        <div class="header-date-group">
                            <label for="start">start date</label>
                            <input type="date" id="daily-start-date">
                        </div>
                        <div class="header-date-group">
                            <label for="end">end date</label>
                            <input type="date" id="daily-end-date">
                        </div>
                    </div>
                   <div class="header-card-button">
                        <button type="button" class="button-button btnGenerate" onclick="generateDailyReport()">generate</button>
                   </div>
                </div>
            </div> -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="../js/chartJS.js"></script>
<script src="../js/hyperlinks_nav.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
</body>

</html>