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
    header('Location: ../public/login_panel.php');
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
                            <a href="../public/index.php" class="active">
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
            <div class="alert error-message" id="error-container"></div>
            <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1>Good morning <span></span></h1>
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
                        <div class="notification-container message-container">
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

                                // console.log(username, user_role);
                                if (textMessage.trim() === "") {
                                    displayErrorMessage("Please enter a message.");
                                    return;
                                }

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


                        
                    </script>
                    <div class="profile">
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            
            <div class="header-cards-container">
                <div class="header-card sales-card-container">
                    <div class="header-card-group sales-card">
                        <h3>sales</h3>
                        <select name="sales_timeframe" id="sales_timeframe">
                            <option value="overall">Overall</option>
                            <option value="monthly">This Month</option>
                            <option value="weekly">This Week</option>
                            <option value="today">Today</option>
                        </select>
                    </div>
                    <h1 class="header-card-value">&#x20B1;<span id="total_sales">0.00</span></h1>
                    <i class="fa-solid fa-arrow-up-right-from-square sales-link"></i>
                </div>
                <div class="header-card collectibles-card-container">
                    <div class="header-card-group collectibles-card">
                        <h3>collectibles</h3>
                        <select name="collectibles_timeframe" id="collectibles_timeframe">
                            <option value="overall">overall</option>
                            <option value="monthly">this month</option>
                            <option value="weekly">this week</option>
                            <option value="today">Today</option>
                        </select>
                    </div>
                    <h1 class="header-card-value">&#x20B1;<span id="total_collectibles">0.00</span></h1>
                    <i class="fa-solid fa-arrow-up-right-from-square collectibles-link"></i>
                </div>
            </div>
            <div class="bottom-cards-container">
                <div class="bottom-card menu-hierarchy">
                   <div class="bottom-header">
                        <h1 class="bottom-cards-title">best seller</h1>
                        <div class="menu-category">
                            <select name="menu_categories" id="menu_categories">
                                <option value="all">All Categories</option>
                                <option value="Main Course">Main Course</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Beverages">Beverages</option>
                            </select>
                        </div>
                   </div>
                    <div class="bottom-card-content menu-seller-card">
                        
                    </div>
                </div>
                <div class="bottom-card customers-total-sales">
                    <h1 class="bottom-cards-title">Valued Customers</h1>
                    <div class="bottom-card-content customer-card-container">
                        <div class="bottom-cards customers-cards">
                            <div class="bottom-cards-group customer-details">
                                <h1 class="bottom-cards-customer customer-name">Loading...</h1>
                            </div>
                            <div class="bottom-cards-group settlement">
                                <h3>Lifetime Sales</h3>
                                <span class="settlement-value">&#x20B1; 0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <select name="analytics_type" id="analytics-type">
                        <option value="" hidden>--type of analytics--</option>
                        <option value="line">Line</option>
                        <option value="bar">Bar</option>
                    </select>
                    <select name="year" id="year_selection"></select>
                    <select name="sales" id="sales_selection">
                        <option value="annually">Annually</option>
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
                <canvas id="sales_chart"></canvas>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                // Initial chart setup
                let ctx = $('#sales_chart')[0].getContext('2d');
                let chart = new Chart(ctx, {
                    type: 'bar',  // Initial chart type
                    data: {
                        labels: [],
                        datasets: [
                            { label: 'Sales', data: [], borderColor: '#34701d', borderWidth: 1, fill: false },
                            { label: 'Collectibles', data: [], borderColor: '#C40C0C', borderWidth: 1, fill: false }
                        ]
                    },
                    options: {
                        scales: { y: { beginAtZero: true } },
                        plugins: {
                            legend: { display: true },
                            tooltip: { enabled: true }
                        }
                    }
                });

                // Update chart data and type
                // function updateChart() {
                //     const selectedYear = $('#year_selection').val();
                //     const selectedPeriod = $('#sales_selection').val();

                //     $.getJSON(`../php/chart_analytics.php?year=${selectedYear}&period=${selectedPeriod}`, function(data) {
                //         let labels = [];
                //         let salesData = [];
                //         let collectiblesData = [];

                //         if (selectedPeriod === 'annually') {
                //             labels.push(selectedYear);
                //             salesData.push(data[0]?.total_sales || 0);
                //             collectiblesData.push(data[0]?.total_collectibles || 0);
                //         } else if (selectedPeriod === 'monthly') {
                //             data.forEach(item => {
                //                 labels.push(item.month_name);  // Use month names directly
                //                 salesData.push(item.total_sales || 0);
                //                 collectiblesData.push(item.total_collectibles || 0);
                //             });
                //         } else if (selectedPeriod === 'weekly') {
                //             data.forEach(item => {
                //                 // Format label as "Month (Week X)"
                //                 labels.push(`${item.month_name} (Week ${item.week})`);
                //                 salesData.push(item.total_sales || 0);
                //                 collectiblesData.push(item.total_collectibles || 0);
                //             });
                //         }

                //         chart.data.labels = labels;
                //         chart.data.datasets[0].data = salesData;
                //         chart.data.datasets[1].data = collectiblesData;
                //         chart.update();
                //     }).fail(function(error) {
                //         console.error("Error fetching data:", error);
                //     });
                // }.

                function updateChart() {
                    const selectedYear = $('#year_selection').val();
                    const selectedPeriod = $('#sales_selection').val();

                    $.getJSON(`../php/chart_analytics.php?year=${selectedYear}&period=${selectedPeriod}`, function(data) {
                        let labels = [];
                        let salesData = [];
                        let collectiblesData = [];

                        if (selectedPeriod === 'annually') {
                            labels.push(selectedYear);
                            salesData.push(data[0]?.total_sales || 0);
                            collectiblesData.push(data[0]?.total_collectibles || 0);
                        } else if (selectedPeriod === 'monthly') {
                            data.forEach(item => {
                                labels.push(item.month_name);
                                salesData.push(item.total_sales || 0);
                                collectiblesData.push(item.total_collectibles || 0);
                            });
                        } else if (selectedPeriod === 'weekly') {
                            data.forEach(item => {
                                // Use week_label directly
                                labels.push(item.week_label);
                                salesData.push(item.total_sales || 0);
                                collectiblesData.push(item.total_collectibles || 0);
                            });
                        }

                        chart.data.labels = labels;
                        chart.data.datasets[0].data = salesData;
                        chart.data.datasets[1].data = collectiblesData;
                        chart.update();
                    }).fail(function(error) {
                        console.error("Error fetching data:", error);
                    });
                }



                // Change chart type without destroying
                $('#analytics-type').on('change', function() {
                    const newType = $(this).val();
                    
                    if (newType && chart.config.type !== newType) {
                        chart.config.type = newType;  // Update the chart type
                        chart.update();
                    }
                });

                // Set up year dropdown and load initial chart data
                const currentYear = new Date().getFullYear();
                const startYear = 2020;
                for (let year = currentYear; year >= startYear; year--) {
                    $('#year_selection').append(new Option(year, year));
                }
                $('#year_selection').val(currentYear);
                updateChart();

                // Trigger updates based on dropdown changes
                $('#sales_selection, #year_selection').on('change', updateChart);
            });

            function fetchBestSellers(category = 'all') {
                $.ajax({
                    url: '../php/get_best_seller_menu.php', // Adjust the path if needed
                    type: 'GET',
                    data: { category: category }, // Send selected category as data
                    dataType: 'json',
                    success: function(data) {
                        const bottomCardsContainer = $('.menu-seller-card');
                        bottomCardsContainer.empty(); // Clear existing content

                        if (data.length > 0) {
                            // Loop through the best seller items and create HTML
                            data.forEach(function(item) {
                                const card = `
                                    <div class="bottom-cards">
                                        <div class="bottom-card-img">
                                            <img src="../uploads/${item.item_image}" alt="${item.item_name}"> <!-- Change image source as necessary -->
                                        </div>
                                        <div class="bottom-cards-group menu-details">
                                            <h1 class="bottom-cards-menu-title">${item.item_name}</h1>
                                        </div>
                                    </div>`;
                                bottomCardsContainer.append(card);
                            });
                        } else {
                            bottomCardsContainer.html('<p>No best sellers available.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching best sellers:', error);
                    }
                });
            }

            function fetchValuedCustomers() {
                $.ajax({
                    url: '../php/get_valued_customer.php', // Adjust the path if needed
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const customerContainer = $('.customer-card-container');
                        customerContainer.empty(); // Clear existing content

                        if (data.length > 0) {
                            // Loop through each customer and create HTML
                            data.forEach(function(customer) {
                                const customerCard = `
                                    <div class="bottom-cards customers-cards">
                                        <div class="bottom-cards-group customer-details">
                                            <h1 class="bottom-cards-customer customer-name">${customer.customer_name}</h1>
                                        </div>
                                        <div class="bottom-cards-group settlement">
                                            <h3>Lifetime Sales</h3>
                                            <span class="settlement-value">&#x20B1; ${customer.total_amount_spent}</span>
                                        </div>
                                    </div>`;
                                customerContainer.append(customerCard);
                            });
                        } else {
                            customerContainer.html('<p>No valued customers available.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching valued customers:', error);
                    }
                });
            }

            $(document).ready(function() {
                function fetchSalesData(timeframe) {
                    $.ajax({
                        url: '../php/get_sales_data.php', // Adjust the path to your PHP script
                        type: 'GET',
                        data: { timeframe: timeframe },
                        dataType: 'json',
                        success: function(data) {
                            $('#total_sales').text(data.total_sales); // Update the total sales amount
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching sales data:', error);
                        }
                    });
                }

                // Fetch sales data when the page loads
                fetchSalesData('overall');

                // Fetch sales data based on selected timeframe
                $('#sales_timeframe').change(function() {
                    const selectedTimeFrame = $(this).val(); // Get the selected value
                    fetchSalesData(selectedTimeFrame); // Pass the selected timeframe to the function
                });
            });

            $(document).ready(function() {
                function fetchCollectiblesData(timeframe) {
                    $.ajax({
                        url: '../php/get_collectibles_data.php', // Adjust the path to your PHP script
                        type: 'GET',
                        data: { timeframe: timeframe },
                        dataType: 'json',
                        success: function(data) {
                            $('#total_collectibles').text(data.total_collectibles); // Update the total sales amount
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching sales data:', error);
                        }
                    });
                }

                // Fetch sales data when the page loads
                fetchCollectiblesData('overall');

                // Fetch sales data based on selected timeframe
                $('#collectibles_timeframe').change(function() {
                    const selectedTimeFrame = $(this).val(); // Get the selected value
                    fetchCollectiblesData(selectedTimeFrame); // Pass the selected timeframe to the function
                });
            });


            // Call the function on page load
            $(document).ready(function() {
                fetchBestSellers(); // Fetch all best sellers on page load
                fetchValuedCustomers();

                // Fetch best sellers based on selected category
                $('#menu_categories').change(function() {
                    const selectedCategory = $(this).val(); // Get the selected value
                    fetchBestSellers(selectedCategory); // Pass the selected category to the function
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
<!-- <script src="../js/chartJS.js"></script> -->
<script src="../js/hyperlinks_nav.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
</body>

</html>