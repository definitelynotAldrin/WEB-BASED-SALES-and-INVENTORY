<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];
$username = $_SESSION['account_username'];

if(!isset($account_id)){
   header('location: ../public/login_panel.php');
}

if ($user_role !== 'user_admin' &&  $user_role !== 'user_service') {
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
    <link rel="stylesheet" href="../css/order_entry.css">
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

<body id="html-body">
    <input type="hidden" id="account_username" name="account_username" value="<?php echo $username?>">
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
                            <a href="../public/order_entry.php" class="active">
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
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
                </div>
            <?php } ?>
            <div class="alert error-message" id="error-container"></div>
            <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1 class="main-header-title">Let's seize the day!</h1>
                    <h4>Let's take some orders and make sales...</h4>
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

                        <div class="notification-container message-container collectibles-notif">
                            <div class="notification-main-wrapper message-wrapper">
                                <div class="notification-header">
                                    <h1>Kan-anan by the Sea Group Chat</h1>
                                </div>
                                <div class="notification-message-wrapper">
                                    
                                </div>
                                <div class="notification-bottom-box message-input-area">
                                    <input type="text" name="" id="message-input" placeholder="Type a message...">
                                    <a href="" type="button" class="send-message-button">Send</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>

                        $(document).ready(function() {
                            var sessionUserRole = "<?php echo $user_role; ?>";

                            if (sessionUserRole === 'user_service') {
                                $('.main-header-title').text('Service Interface');
                            } else{
                                $('.main-header-title').text('Admin Interface');
                            }
                        });

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

                                // console.log(username, user_role)
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

                        
                    </script>

                    <div class="profile">
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="menu-section-container">
                <div class="first-panel-section">
                    <div class="menu-header">
                        <div class="menu-header-content">
                            <h1 class="menu-header-title">Order Menu</h1>
                        </div>
                        <div class="dropdown-category menu-category">
                            <select name="menu_order_category" id="menu_order_category">
                                <option value="all">All Categories</option>
                                <option value="main course">Main Course</option>
                                <option value="dessert">Dessert</option>
                                <option value="beverages">Beverages</option>
                            </select>
                            <input type="text" id="search_menu" placeholder="Search menu">
                        </div>
                    </div>

                    <div class="first-panel-cards-container menu-cards-container" id="menuCardsContainer">
                        <!-- Menu items will be appended here via AJAX -->
                    </div>
                   

                    <script>
                        // document.getElementById('menu_order_category').addEventListener('change', function() {
                        //     var selectedCategory = this.value.toLowerCase();
                        //     var items = document.querySelectorAll('.menu-item-card');

                        //     items.forEach(function(item) {
                        //         var itemCategory = item.getAttribute('data-category').toLowerCase();
                                
                        //         // Show or hide based on the selected category
                        //         if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        //             item.style.display = 'flex';
                        //         } else {
                        //             item.style.display = 'none';
                        //         }
                        //     });
                        // });

                        
                    </script>

                    <div class="popup_order_quantity kilograms-quantity" id="kilograms-popup">
                        <div class="popup-header">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h1>How many kilo(s) <span id="kg-dish-name">dish name</span> required.</h1>
                        </div>
                        <div class="popup-card-container">
                            <!-- HIDDEN INPUTS FOR STORING DATA FROM THE MENU -->
                            <input type="hidden" name="menu_id" id="menu_id_kg">
                            <input type="hidden" name="menu_name" id="menu_name_kg">
                            <input type="hidden" name="menu_price" id="menu_price_kg">
                            <input type="hidden" name="menu_category" id="menu_category_kg">       
                            <div class="card-group">
                                <div class="card-boxes menu-item-quantity" data-value="0.25">
                                    <h3>1/4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="0.5">
                                    <h3>1/2</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="0.75">
                                    <h3>3/4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="1">
                                    <h3>1</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="2">
                                    <h3>2</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="3">
                                    <h3>3</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="4">
                                    <h3>4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity" data-value="5">
                                    <h3>5</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes card-input-field">
                                    <input type="number" min="1" id="custom_kg">
                                    <span>Kilo(s)</span>
                                </div>
                            </div>
                            <div class="card-button-group">
                                <!-- <button class="btn-cancel" type="button">cancel</button> -->
                                <button class="btn-proceed" type="button" id="proceed-kg">proceed</button>
                            </div>
                        </div>
                    </div>

                    <div class="popup_order_quantity pieces-quantity" id="pieces-popup">
                        <div class="popup-header">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h1>How many quantity(s) of <span id="pieces-dish-name">name</span> required.</h1>
                        </div>
                        <div class="popup-card-container">
                            <!-- HIDDEN INPUTS FOR STORING DATA FROM THE MENU -->
                            <input type="hidden" name="menu_id" id="menu_id_pieces">
                            <input type="hidden" name="menu_name" id="menu_name_pieces">
                            <input type="hidden" name="menu_price" id="menu_price_pieces">
                            <input type="hidden" name="menu_category" id="menu_category">       
                            <div class="card-group">
                                <div class="card-boxes card-input-field">
                                    <input type="number" min="0" step="1" id="quantity_pieces">
                                    <span>Quantity</span>
                                </div>
                            </div>
                            <div class="card-button-group">
                                <!-- <button class="btn-cancel" type="button">cancel</button> -->
                                <button class="btn-proceed" type="button" id="proceed-pieces">proceed</button>
                            </div>
                        </div>
                    </div>

                </div>
                <script>
                    $(document).ready(function() {
                        // Variables to store the current selected menu item data
                        let selectedMenuId = null;
                        let selectedMenuName = null;
                        let selectedMenuPrice = null;
                        let ItemCategory = null;
                        let customer_id = null;

                        // Handle menu item card click
                        // Handle menu item card click using delegation
                        $('#menuCardsContainer').on('click', '.menu-item-card', function() {
                            // Get menu item data from the clicked card
                            selectedMenuId = $(this).data('item-id');
                            selectedMenuName = $(this).data('item-name');
                            selectedMenuPrice = $(this).data('item-price');
                            ItemCategory = $(this).data('category');
                            
                            // Open appropriate popup based on category
                            if (ItemCategory === 'Main Course') {
                                // Set values for kilograms popup
                                $('#menu_id_kg').val(selectedMenuId);
                                $('#menu_name_kg').val(selectedMenuName);
                                $('#menu_price_kg').val(selectedMenuPrice);
                                $('#menu_category_kg').val(ItemCategory);
                                $('#kg-dish-name').text(selectedMenuName);
                                $('#kilograms-popup').show(); // Show kilograms popup
                                $('#popup-overlay').show();
                            } else if (ItemCategory === 'Beverages' || ItemCategory === 'Dessert') {
                                // Set values for pieces popup
                                $('#menu_id_pieces').val(selectedMenuId);
                                $('#menu_name_pieces').val(selectedMenuName);
                                $('#menu_price_pieces').val(selectedMenuPrice);
                                $('#menu_category').val(ItemCategory);
                                $('#pieces-dish-name').text(selectedMenuName);
                                $('#pieces-popup').show(); // Show pieces popup
                                $('#popup-overlay').show();
                            }
                        });


                        // Handle cancel button click in popups
                        $('.btn-cancel').on('click', function() {
                            $('.popup_order_quantity').hide(); 
                            $('#popup-overlay').hide();
                            // $('body').css('overflow', 'auto');// Hide all popups
                        });

                        $('#popup-overlay').on('click', function() {
                            $('.popup_order_quantity').hide(); 
                            $('#popup-overlay').hide();
                            $('#pieces-popup').hide();
                            $('.popup-confirmation-container').hide();
                            // $('body').css('overflow', 'auto');// Hide all popups
                        });

                        // Handle proceed button click in kilograms popup
                        $(document).ready(function() {
                            let selectedQuantity = null;

                            $('.menu-item-quantity').on('click', function() {
                                if ($(this).hasClass('active')) {
                                    $(this).removeClass('active');
                                    selectedQuantity = null;
                                    $('#custom_kg').val('').prop('disabled', false);
                                } else {
                                    $('.menu-item-quantity').removeClass('active');
                                    $(this).addClass('active');
                                    selectedQuantity = $(this).data('value');
                                    $('#custom_kg').val('').prop('disabled', true);
                                }
                            });

                            $('#custom_kg').on('click', function() {
                                $('.menu-item-quantity').removeClass('active');
                                $(this).prop('disabled', false);
                                selectedQuantity = null;
                            });

                            $('#custom_kg').on('input', function() {
                                selectedQuantity = parseFloat($(this).val());
                            });

                            $('#kilograms-popup .btn-proceed').on('click', function() {
                                const quantity = selectedQuantity || parseFloat($('#custom_kg').val());
                                // console.log("Selected Quantity: ", quantity); // Check quantity
                                // console.log("Selected Menu ID: ", selectedMenuId); // Check menu ID
                                // console.log("Selected Menu Name: ", selectedMenuName); // Check menu name
                                // console.log("Selected Menu Price: ", selectedMenuPrice); // Check menu price

                                if (quantity && selectedMenuId && selectedMenuName && ItemCategory) {
                                    const orderData = {
                                        menu_id: selectedMenuId,
                                        menu_name: selectedMenuName,
                                        quantity: quantity,
                                        menu_price: selectedMenuPrice,
                                        menu_category: ItemCategory,
                                    };
                                    // console.log("Order Data: ", orderData); 

                                    $.ajax({
                                        url: '../php/add_order_detail.php',
                                        type: 'POST',
                                        data: orderData,
                                        success: function(response) {
                                            const result = JSON.parse(response);
                                            if (result.status === 'success') {
                                                fetchMenuItems(); 
                                                updateOrderSummary();
                                                $('#custom_kg').val('');
                                                $('#kilograms-popup').hide();
                                                $('#popup-overlay').hide();
                                                $('body').css('overflow', 'auto');
                                                // displaySuccessMessage(result.message);
                                            } else {
                                                displayErrorMessage(result.message);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            alert('Error adding order: ' + error + '\n' + xhr.responseText);
                                        }
                                    });
                                } else {
                                    displayErrorMessage('Select or Input quantity before proceeding!');
                                }
                            });
                        });


                        // Handle proceed button click in pieces popup
                        $('#pieces-popup .btn-proceed').on('click', function() {
                            // Get input value from the popup
                            const quantity = $('#quantity_pieces').val();

                            // Check if quantity and menu item data are available
                            if (quantity && selectedMenuId && selectedMenuName && ItemCategory) {
                                // Prepare data for AJAX
                                const orderData = {
                                    menu_id: selectedMenuId,
                                    menu_name: selectedMenuName,
                                    quantity: quantity,
                                    menu_price: selectedMenuPrice,
                                    menu_category: ItemCategory,
                                };

                                // Send AJAX request to add the order
                                $.ajax({
                                    url: '../php/add_order_detail.php', // Adjust path as needed
                                    type: 'POST',
                                    data: orderData,
                                    success: function(response) {
                                        const result = JSON.parse(response);
                                        if (result.status === 'success') {
                                            // Update order summary table
                                            fetchMenuItems();
                                            updateOrderSummary();
                                            $('#quantity_pieces').val('');
                                            $('#pieces-popup').hide();
                                            $('#popup-overlay').hide();
                                            $('body').css('overflow', 'auto'); // Close the popup
                                        } else {
                                            displayErrorMessage(result.message); // Handle error message
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Error adding order: ' + error);
                                    }
                                });
                            } else {
                                displayErrorMessage('Input quantity before proceeding!');
                            }
                        });


                            function fetchMenuItems() {
                                // Get selected category and search input
                                const selectedCategory = $('#menu_order_category').val();
                                const searchQuery = $('#search_menu').val();

                                $.ajax({
                                    url: '../php/fetch_menu.php', // Your PHP script
                                    type: 'GET',
                                    data: {
                                        category: selectedCategory,  // Send category as a parameter
                                        search: searchQuery          // Send search query as a parameter
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        $('#menuCardsContainer').empty(); // Clear existing items
                                        if (data.length > 0) {
                                            $.each(data, function(index, item) {
                                                $('#menuCardsContainer').append(`
                                                    <div class="card menu-item-card ${item.inactive_class}"
                                                        data-category="${item.item_category}" 
                                                        data-item-id="${item.item_id}" 
                                                        data-item-name="${item.item_name}" 
                                                        data-item-price="${item.item_price}">
                                                        <img src="../uploads/${item.item_image}" class="card-img menu-img" alt="${item.item_name}">
                                                        <div class="card-details menu-card-details">
                                                            <span class="card-name menu-name">${item.item_name}</span>
                                                        </div>
                                                    </div>
                                                `);
                                            });
                                        } else {
                                            $('#menuCardsContainer').append("<p>No menu items available.</p>");
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("Error fetching menu items: " + textStatus, errorThrown);
                                    }
                                });
                            }

                            // Call fetchMenuItems on page load
                            fetchMenuItems();

                            // Fetch menu items when the category changes
                            $('#menu_order_category').change(function() {
                                fetchMenuItems();
                            });

                            // Fetch menu items when the search input changes
                            $('#search_menu').on('input', function() {
                                fetchMenuItems();
                            });


                        $(document).ready(function() {
                                fetchMenuItems();

                            // Optional: Set interval to refresh the notifications periodically
                            setInterval(fetchMenuItems, 3000); // Refresh every 30 seconds
                        });

                    });

                    // Bind the remove button functionality
                    function bindRemoveButtonEvents() {
                        $('.btn-remove').on('click', function() {
                            const orderId = $(this).data('id');

                            // Make an AJAX request to delete the order
                            $.ajax({
                                url: '../php/delete_order_detail.php', // Adjust path as needed
                                type: 'POST',
                                data: { order_id: orderId },
                                success: function(response) {
                                    try {
                                        const jsonResponse = JSON.parse(response); // Parse the JSON response

                                        if (jsonResponse.status === 'success') {
                                            updateOrderSummary(); // Refresh the order summary after deletion
                                        } else {
                                            displayErrorMessage('Error: ' + jsonResponse.message); // Display error message if item not found
                                        }
                                    } catch (error) {
                                        console.error('Error parsing JSON:', error); // Log parsing error
                                        displayErrorMessage('Error processing the request.'); // User-friendly message
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error:', error); // Log the error
                                    displayErrorMessage('Error deleting order: ' + error); // Display error message
                                }
                            });
                        });
                    }
                     // Update order summary (example function)
                    function updateOrderSummary() {
                        $.ajax({
                            url: '../php/get_order_summary.php', // This PHP file retrieves order details from session
                            type: 'GET',
                            success: function(response) {
                                // Update the UI with the returned order summary
                                $('#order-summary-tbody').html(response);
                                bindRemoveButtonEvents();
                                // Calculate and update the total amount
                                let totalAmount = 0;

                                // Loop through each row in the returned summary and sum up the subtotals
                                $('#order-summary-tbody tr').each(function() {
                                    let subTotal = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^0-9.-]+/g, ""));
                                    if (!isNaN(subTotal)) {
                                        totalAmount += subTotal;
                                    }
                                });

                                // Update the total amount field with the calculated total
                                $('#total-amount').text(totalAmount.toFixed(2));
                            },
                            error: function(xhr, status, error) {
                                alert('Error retrieving order summary: ' + error);
                            }
                        });
                    }
                    

                    // Initially call the function to load the order summary
                    updateOrderSummary();

                    $(document).ready(function() {
                        // Handle place order button click
                        $('#place-order-button').on('click', function() {
                            // Show the confirmation popup
                            $('.popup-confirmation-container').fadeIn();
                            $('.popup-overlay').fadeIn();
                        });

                        // Attach the confirm button click handler only once
                        $('.btnConfirm').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent any default behavior of the button

                            // Gather customer data
                            const customerData = {
                                customer_name: $('#customer-name').val(),
                                customer_note: $('#customer-note').val(),
                                customer_table: $('#customer-table').val(),
                                hidden_order_id: $('#order-id').val(),
                                username: $('#account_username').val()
                            };

                            // console.log(customerData);

                            // Send AJAX request to save customer info
                            $.ajax({
                                url: '../php/add_orders.php', // Your PHP file
                                type: 'POST',
                                data: customerData,
                                success: function(response) {
                                    // Log the entire response object for debugging
                                    // console.log(JSON.stringify(response));

                                    // Check if response is successful
                                    if (response.status === 'success') {
                                        displaySuccessMessage(response.message);

                                        // Clear customer data fields
                                        $('#customer-name').val('');
                                        $('#customer-note').val('');
                                        $('#customer-table').val('');
                                        $('#order-id').val('');

                                        // Update the order summary or take any action for success here
                                        updateOrderSummary();
                                        updateTable();
                                    } else {
                                        // Handle error case
                                        displayErrorMessage(response.message);
                                    }

                                    // Hide the popup after order is confirmed
                                    $('.popup-confirmation-container').fadeOut();
                                    $('.popup-overlay').fadeOut();
                                },
                                error: function(xhr, status, error) {
                                    console.log('Error submitting customer info: ' + error); // Handle error
                                    // Hide the popup in case of an error as well
                                    $('.popup-confirmation-container').fadeOut();
                                    $('.popup-overlay').fadeOut();
                                }
                            });
                        });

                            // Handle cancel button in the popup
                        $('.btnCancel').on('click', function() {
                            $('.popup-confirmation-container').fadeOut();
                            $('.popup-overlay').fadeOut();
                            $('#customer-name, #customer-note, #customer-table').val('');
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


                    // ----------------------updating table-----------------------

                    $(document).ready(function() {
                        // Show the popup when the 'Update tables' button is clicked
                        $('.btnTable').on('click', function() {
                            // Display the popup
                            $('.popup-table-container').fadeIn();
                            $('#popup-overlay').fadeIn();

                            // Load active and inactive tables for today
                            loadTableStatus();
                        });

                        $('#popup-overlay').on('click', function() {
                            // Display the popup
                            $('.popup-table-container').hide();
                            $('#popup-overlay').hide();

                            // Load active and inactive tables for today
                            loadTableStatus();
                        });

                        // Switch between active and inactive panels
                        $('.activeBtn').on('click', function() {
                            $('.active-panel').show();
                            $('.inactive-panel').hide();
                        });

                        $('.inactiveBtn').on('click', function() {
                            $('.active-panel').hide();
                            $('.inactive-panel').show();
                        });

                        // Function to load active and inactive tables
                        function loadTableStatus() {
                            $.ajax({
                                url: '../php/get_today_table_status.php', // Your PHP script to get table statuses for today
                                type: 'GET',
                                success: function(response) {
                                    var data = JSON.parse(response);
                                    var activeTablesHtml = '';
                                    var inactiveTablesHtml = '';

                                    // Loop through the response data to populate active and inactive table rows
                                    data.forEach(function(item) {
                                        if (item.table_status == 1) { // Active table
                                            activeTablesHtml += `
                                                <tr>
                                                    <td>${item.customer_name}</td>
                                                    <td>${item.customer_table}</td>
                                                    <td>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" data-table-id="${item.customer_table}" data-order-id="${item.order_id}" checked>
                                                            <span class="text-status">Occupied</span>
                                                        </div>
                                                    </td>
                                                </tr>`;
                                        } else { // Inactive table
                                            inactiveTablesHtml += `
                                                <tr>
                                                    <td>${item.customer_name}</td>
                                                    <td>${item.customer_table}</td>
                                                    <td>
                                                        <div class="toggle-switch">
                                                            <span class="text-status">Unoccupied</span>
                                                            <i class="fa-solid fa-rotate-left btnReturn" data-table-id="${item.customer_table}" data-order-id="${item.order_id}"></i>
                                                        </div>
                                                    </td>
                                                </tr>`;
                                        }
                                    });

                                    // Update the HTML in the active and inactive table bodies
                                    $('.active-panel tbody').html(activeTablesHtml);
                                    $('.inactive-panel tbody').html(inactiveTablesHtml);

                                    // Bind event handlers after content is loaded
                                    bindTableActions();
                                    updateTable();
                                },
                                error: function(xhr, status, error) {
                                    alert('Error retrieving table status: ' + error);
                                }
                            });
                        }


                        $(document).ready(function() {
                            // Handle "View Orders" button click
                            $('.button-view-orders').on('click', function() {
                                // Send AJAX request to fetch unpaid orders
                                $('.table-orders-container').fadeIn();
                                $('#popup-overlay').fadeIn();
                                $.ajax({
                                    url: '../php/fetch_orders.php', // Your PHP file for fetching orders
                                    type: 'POST',
                                    dataType: 'json',
                                    success: function(response) {
                                        // console.log(JSON.stringify(response));

                                        if (response.status === 'success') {
                                            const tbody = $('.table-orders-container tbody');
                                            tbody.empty(); // Clear the table before adding new data

                                            // Loop through each order and append to the table
                                            response.orders.forEach(function(order) {
                                                const row = `
                                                    <tr>
                                                        <td>${order.customer_name}</td>
                                                        <td>${order.customer_table}</td>
                                                        <td class="btnAdditional">
                                                            <i class="fa-regular fa-square-plus" 
                                                            data-order-id="${order.order_id}" 
                                                            data-customer-name="${order.customer_name}" 
                                                            data-customer-table="${order.customer_table}">
                                                            </i>
                                                        </td>
                                                    </tr>
                                                `;
                                                tbody.append(row);
                                            });

                                            // Add event listener to each add button for placing additional orders
                                            $('.btnAdditional i').on('click', function() {
                                                const customerName = $(this).data('customer-name');
                                                const customerTable = $(this).data('customer-table');
                                                const orderId = $(this).data('order-id');

                                                $('.table-orders-container').fadeOut();
                                                $('#popup-overlay').fadeOut();

                                                // Populate the customer fields in the form
                                                $('#occupied_table').removeAttr('disabled').removeAttr('hidden');
                                                $('#customer-name').val(customerName);
                                                $('#customer-table').val($('#occupied_table').val());


                                                // Optionally store the order ID in a hidden input
                                                $('#order-id').val(orderId);
                                                
                                            });

                                        } else {
                                            displayErrorMessage('No orders found');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        displayErrorMessage('Error fetching unpaid orders: ' + error); // Handle error
                                    }
                                });
                            });

                            $('#popup-overlay').on('click', function() {
                                $('.table-orders-container').hide();
                                $('#popup-overlay').hide();
                            });

                            updateTable();
                        });


                        // Function to bind actions for the checkboxes and return buttons
                        function bindTableActions() {
                            // Handle unchecking in the active panel (set table to inactive)
                            $('.active-panel .toggle-switch input[type="checkbox"]').on('change', function() {
                                var tableId = $(this).data('table-id');
                                var orderId = $(this).data('order-id');
                                var status = $(this).is(':checked') ? 1 : 0;

                                // Update the table status in the database via AJAX
                                updateTableStatus(orderId, tableId, status);
                                updateTable();
                            });

                            // Handle the return button in the inactive panel (set table to active)
                            $('.inactive-panel .btnReturn').on('click', function() {
                                var tableId = $(this).data('table-id');
                                var orderId = $(this).data('order-id');

                                // Set the table as active (status = 1)
                                updateTableStatus(orderId, tableId, 1);
                                updateTable();
                            });
                        }

                        // Function to update table status via AJAX
                        function updateTableStatus(orderId, tableId, status) {
                            $.ajax({
                                url: '../php/update_table_status.php', // Your PHP script to update the table status
                                type: 'POST',
                                data: {
                                    order_id: orderId,
                                    table_id: tableId,
                                    status: status
                                },
                                success: function(response) {
                                    // Reload the table status after updating
                                    loadTableStatus();
                                    updateTable();
                                },
                                error: function(xhr, status, error) {
                                    displayErrorMessage('Error updating table status: ' + error);
                                }
                            });
                        }
                    });



                    function updateTable() {
                        $.ajax({
                            url: '../php/get_table_status.php', // PHP file that retrieves table status
                            type: 'GET',
                            dataType: 'json', // Expect JSON response from PHP
                            success: function(response) {
                                // Ensure the dropdown is reset before applying any disabled state
                                $('#customer-table option').removeAttr('disabled').removeClass('disabled-table');

                                // Check if the response has any occupied tables
                                if (response.occupied_tables && response.occupied_tables.length > 0) {
                                    var occupiedTables = response.occupied_tables; // Access the 'occupied_tables' array from the response
                                    occupiedTables.forEach(function(table) {
                                        $('#customer-table option[value="' + table + '"]').attr('disabled', 'disabled').addClass('disabled-table');
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                displayErrorMessage('Error retrieving table status: ' + error);
                            }
                        });
                    }

                    updateTable();

                    $(document).ready(function () {
                        // Fetch and Populate Table Numbers
                        function fetchTables() {
                            $.ajax({
                                url: "../php/get_table_numbers.php",
                                method: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $("#customer-table").empty();
                                    $("#customer-table").append('<option value="" hidden>Customer Table</option>');
                                    $("#customer-table").append('<option value="occupied_table" id="occupied_table" hidden>Already have a table!</option>');
                                    data.forEach(function (table) {
                                        $("#customer-table").append(`<option value="${table}">Table ${table}</option>`);
                                    });
                                }
                            });
                        }

                        // Initial Fetch
                        fetchTables();

                        // Add Table
                        $(".numberIncrease").click(function () {
                            $.ajax({
                                url: "../php/update_table_numbers.php",
                                method: "POST",
                                data: { action: "add" },
                                success: function (response) {
                                    displaySuccessMessage(response);
                                    fetchTables();
                                    updateTable();
                                }
                            });
                        });

                        // Remove Table
                        $(".numberDecrease").click(function () {
                            $.ajax({
                                url: "../php/update_table_numbers.php",
                                method: "POST",
                                data: { action: "remove" },
                                success: function (response) {
                                    displaySuccessMessage(response);
                                    fetchTables();
                                    updateTable();
                                }
                            });
                        });
                    });
                </script>
                <div class="second-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">order summary</h1>
                    </div>
                    <div class="second-panel-card-container order-summary-section">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="order-details-id" style="display:none;">ID</th>
                                        <th class="order-header">Order</th>
                                        <th class="quantity-header">Qty</th>
                                        <th class="price-header">Price</th>
                                        <th class="subtotal-header">Sub-total</th>
                                        <th class="action-header">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="order-summary-tbody"> <!-- Added ID here -->
                                    <!-- Order summary rows will be populated here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="card-bottom-container total-section">
                            <div class="card-bottom-group total-field">
                                <h3>total</h3>
                                <span>&#8369; <span id="total-amount"> 0.00</span></span>
                            </div>
                            <input type="hidden" name="hidden_order_id" id="order-id">
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group customer-field">
                                    <h3>customer name</h3>
                                    <input type="text" name="customer_name" id="customer-name">
                                </div>
                                <div class="card-bottom-group note-field">
                                    <h3>note</h3>
                                    <input type="text" placeholder="Optional" name="customer_note" id="customer-note">
                                </div>
                            </div>
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group table-number-field">
                                    <!-- <i class="fa-regular fa-square-minus numberDecrease"></i> -->
                                    <select name="customer_table" id="customer-table">
                                        <option value="" hidden>Customer Table</option>
                                        <option value="occupied_table" id="occupied_table" hidden>Already have a table!</option>
                                    </select>
                                    <!-- <i class="fa-regular fa-square-plus numberIncrease"></i> -->
                                </div>
                                <button class="btnTable">tables availability</button>
                            </div>
                            <button class="button-view-orders" id="button-view-orders">View orders</button>
                            <div class="button-section">
                                <button type="button" id="place-order-button">
                                    <span>proceed to kitchen</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- -------------------------------------View Orders for---------------------------------- -->

                    <div class="pop-up-container table-orders-container">
                        <div class="table-orders-header-container">
                            <h1 class="popup-table-title">orders</h1>
                        </div>
                        <div class="table-orders-second-container">
                            <table>
                                <thead>
                                    <th>Customer name</th>
                                    <th>Customer table</th>
                                    <th>action</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ---------------------------------table availability--------------------------------- -->
                    <div class="pop-up-container popup-table-container" style="display: none;">
                        <h1 class="popup-table-title">Tables Status</h1>
                        <div class="popup-table-header-container">
                            <h1 class="popup-table-header activeBtn">Active</h1>
                            <h1 class="popup-table-header inactiveBtn">Inactive</h1>
                        </div>
                        <!-- Active Panel -->
                        <div class="popup-table-content active-panel">
                            <!-- The content will be populated dynamically using AJAX -->
                            <table>
                                <thead>
                                    <th>Customer name</th>
                                    <th>Customer table</th>
                                    <th>availability</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                        <!-- Inactive Panel -->
                        <div class="popup-table-content inactive-panel" style="display:none;">
                            <!-- The content will be populated dynamically using AJAX -->
                            <table>
                                <thead>
                                    <th>Customer name</th>
                                    <th>Customer table</th>
                                    <th>availability</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            
<!-- -------------------Placing order Confirmation Popup------------------------ -->

            <div class="pop-up-container popup-confirmation-container">
                <div class="pop-up-content popup-confirmation-content">
                    <i class="fa-solid fa-question"></i>
                    <h1>Are you sure you want to place this order?</h1>
                    <div class="pop-up-buttons logout-buttons">
                        <a href="#" class="btn-second btnCancel">no</a>
                        <a href="#" class="btn-first btnConfirm">yes</a>
                    </div>
                </div>
            </div>

            <div id="popup-overlay" class="popup-overlay"></div>           
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
    </div>
<script src="../js/sidenav.js"></script>
<!-- <script src="../js/menu_entry_panel.js"></script>  -->
<!-- <script src="../js/popup_forms.js"></script> -->
<script src="../js/order_entry_panel.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/hyperlinks_nav.js"></script>
<script src="../js/alert_disappear.js"></script>
</body>
</html>

