<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];

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
            <div class="content-header">
                <div class="header-text">
                    <h1>Let's seize the day! <span></span></h1>
                    <h4>Let's take some orders and make sales...</h4>
                </div>
                <div class="header-profile">
                <div class="notification">
                        <?php 
                            include_once "../includes/connection.php";

                            $sql = "SELECT * FROM stocks";
                            $result = $conn->query($sql);

                            $low_stock_found = false; // Flag to track if any stock is low
                        ?>
                        <i class="fa-solid fa-bell notification-bell">
                            <?php if ($result->num_rows > 0) { ?>
                                <?php 
                                    $low_stock_threshold = 10; // Define your low stock threshold here
                                    while($row = $result->fetch_assoc()) {
                                        $stock_quantity = $row['stock_quantity'];
                                        $stock_name = $row['stock_name']; // Assuming stock name is stored in 'stock_name' column

                                        // Check if stock is low
                                        if ($stock_quantity < $low_stock_threshold) {
                                            $low_stock_found = true; // Set flag if there's a low stock
                                        }
                                    }
                                ?>
                                <?php if ($low_stock_found) { ?>
                                    <!-- Display fa-circle only if there's a low stock -->
                                    <i class="fa-solid fa-circle"></i>
                                <?php } ?>
                            <?php } ?>
                        </i>

                        <div class="notification-content-container">
                            <h1 class="notification-title">Notifications</h1>
                            <div class="notification-card-container">
                                <?php
                                    if ($result->num_rows > 0) {
                                        // Reset the result pointer for another loop
                                        $result->data_seek(0); // Important to reset the result pointer for another loop

                                        while($row = $result->fetch_assoc()) {
                                            $stock_quantity = $row['stock_quantity'];
                                            $stock_name = $row['stock_name']; // Assuming stock name is stored in 'stock_name' column

                                            // Check if stock is low
                                            if ($stock_quantity < $low_stock_threshold) {
                                                // Display low stock notification
                                ?>
                                <div class="notification-content">
                                    <div class="notification-img">
                                        <img src="../assets/mark.png">
                                    </div>
                                    <div class="notification-details">
                                        <h1 class="notification-details-title"><?php echo htmlspecialchars($stock_name); ?></h1>
                                        <p><span>Stock Alert:</span> This item is running low. <br>Only <span><?php echo $stock_quantity; ?></span> available.</p>
                                    </div>
                                </div>
                                <?php
                                            }
                                        }
                                    } else {
                                        echo "<p>Items are in stock!</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="profile">
                        <img src="../assets/me.jpg">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="menu-section-container">
                <div class="first-panel-section">
                    <?php
                    include_once "../includes/connection.php";

                    // Fetch all unique menu items and their associated stock data, including inactive stocks
                    $sql = "
                        SELECT mi.*, 
                            GROUP_CONCAT(s.stock_name) AS ingredients, 
                            MAX(CASE WHEN s.stock_status = 1 THEN 0 ELSE 1 END) AS has_inactive_stock
                        FROM menu_items mi
                        LEFT JOIN menu_item_stocks mis ON mi.item_id = mis.menu_item_id
                        LEFT JOIN stocks s ON mis.stock_id = s.stock_id
                        GROUP BY mi.item_id";  // Group by item_id to avoid duplicates
                    $result = $conn->query($sql);
                    ?>

                    <div class="menu-header">
                        <h1 class="menu-header-title">Order Menu</h1>
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

                    <div class="first-panel-cards-container menu-cards-container">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // $itemCategory = strtolower($row['item_category']); // Convert category to lowercase to match filter
                                $inactiveClass = ($row['has_inactive_stock'] == 1) ? 'inactive-card' : '';

                                ?>
                                <div class="card menu-item-card <?php echo $inactiveClass; ?>"
                                    data-category="<?php echo $row['item_category']; ?>"
                                    data-item-id="<?php echo $row['item_id']; ?>"
                                    data-item-name="<?php echo $row['item_name']; ?>"
                                    data-item-price="<?php echo $row['item_price']; ?>">
                                    <img src="../uploads/<?php echo $row['item_image']; ?>" class="card-img menu-img" alt="<?php echo $row['item_name']; ?>">
                                    <div class="card-details menu-card-details">
                                        <span class="card-name menu-name"><?php echo $row['item_name']; ?></span>
                                    </div>
                                    <!-- <input type="text" name="" id="" value="<?php echo $row['item_id']; ?>" style="position:absolute; z-index: 3; top: 30%;">
                                    <input type="text" name="" id="" value="<?php echo $row['item_name']; ?>" style="position:absolute; z-index: 3;">
                                    <input type="text" name="" id="" value="<?php echo $row['item_category']; ?>" style="position:absolute; z-index: 3; top: 40%;""> -->
                                </div>

                                <?php
                            }
                        } else {
                            echo "<p>No menu items available.</p>";
                        }
                        ?>
                    </div>
                   

                    <script>
                        document.getElementById('menu_order_category').addEventListener('change', function() {
                            var selectedCategory = this.value.toLowerCase();
                            var items = document.querySelectorAll('.menu-item-card');

                            items.forEach(function(item) {
                                var itemCategory = item.getAttribute('data-category').toLowerCase();
                                
                                // Show or hide based on the selected category
                                if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                                    item.style.display = 'flex';
                                } else {
                                    item.style.display = 'none';
                                }
                            });
                        });
                    </script>

                    <div class="popup_order_quantity kilograms-quantity" id="kilograms-popup">
                        <div class="popup-header">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h1>Input how many kilo(s) <span id="kg-dish-name">dish name</span> required.</h1>
                        </div>
                        <div class="popup-card-container">
                            <!-- HIDDEN INPUTS FOR STORING DATA FROM THE MENU -->
                            <input type="hidden" name="menu_id" id="menu_id_kg">
                            <input type="hidden" name="menu_name" id="menu_name_kg">
                            <input type="hidden" name="menu_price" id="menu_price_kg">        
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
                                <button class="btn-cancel" type="button">cancel</button>
                                <button class="btn-proceed" type="button" id="proceed-kg">proceed</button>
                            </div>
                        </div>
                    </div>

                    <div class="popup_order_quantity pieces-quantity" id="pieces-popup">
                        <div class="popup-header">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h1>Input how many quantity(s) of <span id="pieces-dish-name">name</span> required.</h1>
                        </div>
                        <div class="popup-card-container">
                            <!-- HIDDEN INPUTS FOR STORING DATA FROM THE MENU -->
                            <input type="hidden" name="menu_id" id="menu_id_pieces">
                            <input type="hidden" name="menu_name" id="menu_name_pieces">
                            <input type="hidden" name="menu_price" id="menu_price_pieces">
                            <div class="card-group">
                                <div class="card-boxes card-input-field">
                                    <input type="number" min="1" id="quantity_pieces">
                                    <span>Quantity</span>
                                </div>
                            </div>
                            <div class="card-button-group">
                                <button class="btn-cancel" type="button">cancel</button>
                                <button class="btn-proceed" type="button" id="proceed-pieces">proceed</button>
                            </div>
                        </div>
                    </div>

                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Variables to store the current selected menu item data
                        let selectedMenuId = null;
                        let selectedMenuName = null;
                        let selectedMenuPrice = null;

                        // Handle menu item card click
                        $('.menu-item-card').on('click', function() {
                            // Get menu item data from the clicked card
                            selectedMenuId = $(this).data('item-id');
                            selectedMenuName = $(this).data('item-name');
                            selectedMenuPrice = $(this).data('item-price');
                            const itemCategory = $(this).data('category'); // Get item category

                            // Open appropriate popup based on category
                            if (itemCategory === 'Main Course') {
                                // Set values for kilograms popup
                                $('#menu_id_kg').val(selectedMenuId);
                                $('#menu_name_kg').val(selectedMenuName);
                                $('#menu_price_kg').val(selectedMenuPrice); // Ensure you set price here if needed
                                $('#kilograms-popup').show(); // Show kilograms popup
                            } else if (itemCategory === 'Beverages' || itemCategory === 'Dessert') {
                                // Set values for pieces popup
                                $('#menu_id_pieces').val(selectedMenuId);
                                $('#menu_name_pieces').val(selectedMenuName);
                                $('#menu_price_pieces').val(selectedMenuPrice); // Ensure you set price here if needed
                                $('#pieces-popup').show(); // Show pieces popup
                            }
                        });

                        // Handle cancel button click in popups
                        $('.btn-cancel').on('click', function() {
                            $('.popup_order_quantity').hide(); // Hide all popups
                        });

                        // Handle proceed button click in kilograms popup
                        $(document).ready(function() {
                            // Variable to store the selected quantity
                            let selectedQuantity = null;

                            // Handle click on predefined quantity boxes
                            $('.menu-item-quantity').on('click', function() {
                                if ($(this).hasClass('active')) {
                                    // If clicked box is already active, remove active class and reset selectedQuantity
                                    $(this).removeClass('active');
                                    selectedQuantity = null;

                                    // Enable custom input field
                                    $('#custom_kg').val('').prop('disabled', false);
                                } else {
                                    // Remove active class from all quantity boxes
                                    $('.menu-item-quantity').removeClass('active');

                                    // Add active class to the clicked box
                                    $(this).addClass('active');

                                    // Set the selected quantity to the data-value of the clicked box
                                    selectedQuantity = $(this).data('value');

                                    // Clear custom input value and disable it
                                    $('#custom_kg').val('').prop('disabled', true);
                                }
                            });

                            // Enable custom input field when clicked
                            $('#custom_kg').on('click', function() {
                                // Remove active class from predefined quantity boxes
                                $('.menu-item-quantity').removeClass('active');

                                // Enable the custom input field and clear the selected quantity
                                $(this).prop('disabled', false);
                                selectedQuantity = null;
                            });

                            // Handle custom input value change
                            $('#custom_kg').on('input', function() {
                                // Set the selected quantity to the custom input value
                                selectedQuantity = parseFloat($(this).val());
                            });

                            // Handle proceed button click in kilograms popup
                            $('#kilograms-popup .btn-proceed').on('click', function() {
                                // Get selected quantity or custom input value
                                const quantity = selectedQuantity || parseFloat($('#custom_kg').val());
                                
                                // Check if quantity and menu item data are available
                                if (quantity && selectedMenuId && selectedMenuName) {
                                    // Prepare data for AJAX
                                    const orderData = {
                                        menu_id: selectedMenuId,
                                        menu_name: selectedMenuName,
                                        quantity: quantity,
                                        menu_price: selectedMenuPrice,
                                    };

                                    // Send AJAX request to add the order
                                    $.ajax({
                                        url: '../php/add_order_detail.php', // Adjust path as needed
                                        type: 'POST',
                                        data: orderData,
                                        success: function(response) {
                                            // Handle success (e.g., update order summary table)
                                            updateOrderSummary();
                                            $('#kilograms-popup').hide(); // Close the popup
                                        },
                                        error: function(xhr, status, error) {
                                            alert('Error adding order: ' + error);
                                        }
                                    });
                                } else {
                                    // alert('Please select a quantity before proceeding.');
                                }
                            });
                        });


                        // Handle proceed button click in pieces popup
                        $('#pieces-popup .btn-proceed').on('click', function() {
                            // Get input value from the popup
                            const quantity = $('#quantity_pieces').val();

                            // Check if quantity and menu item data are available
                            if (quantity && selectedMenuId && selectedMenuName) {
                                // Prepare data for AJAX
                                const orderData = {
                                    menu_id: selectedMenuId,
                                    menu_name: selectedMenuName,
                                    quantity: quantity,
                                    menu_price: selectedMenuPrice,
                                };

                                // Send AJAX request to add the order
                                $.ajax({
                                    url: '../php/add_order_detail.php', // Adjust path as needed
                                    type: 'POST',
                                    data: orderData,
                                    success: function(response) {
                                        // Handle success (e.g., update order summary table)
                                        updateOrderSummary();
                                        $('#pieces-popup').hide(); // Close the popup
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Error adding order: ' + error);
                                    }
                                });
                            }
                        });

                        // Update order summary (example function)
                        function updateOrderSummary() {
                    // Make an AJAX request to get the latest order summary data
                    $.ajax({
                        url: '../php/get_order_summary.php', // Adjust path as needed
                        type: 'GET',
                        success: function(response) {
                            $('tbody').html(response); // Update the order summary table body with new data

                            // Extract total amount from the response or calculate it manually if needed
                            let totalAmount = 0;
                            $('tbody tr').each(function() {
                                let subTotal = parseFloat($(this).find('td:nth-child(5)').text());
                                if (!isNaN(subTotal)) {
                                    totalAmount += subTotal;
                                }
                            });

                            bindRemoveButtonEvents();

                            // Update the total amount field
                            $('#total-amount').text(totalAmount.toFixed(2));
                        },
                        error: function(xhr, status, error) {
                            alert('Error fetching order summary: ' + error);
                        }
                    });
                }


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
                                        updateOrderSummary(); // Refresh the order summary after deletion
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Error deleting order: ' + error);
                                    }
                                });
                            });
                        }

                        // Initially call the function to load the order summary
                        updateOrderSummary();

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
                                        <th class="quantity-header">Quantity</th>
                                        <th class="price-header">price</th>
                                        <th class="subtotal-header">Sub-total</th>
                                        <th class="action-header">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="card-bottom-container total-section">
                            <div class="card-bottom-group total-field">
                                <h3>total</h3>
                                <span>&#8369; <span id="total-amount"> 0.00</span></span>
                            </div>
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group customer-field">
                                    <h3>customer name</h3>
                                    <input type="text" name="customerName" id="customerName">
                                </div>
                                <div class="card-bottom-group note-field">
                                    <h3>note</h3>
                                    <input type="text" placeholder="Optional" name="customerNote" id="customerNote">
                                </div>
                            </div>
                            <div class="card-bottom-groups order-number-field">
                                <div class="card-bottom-group order-number-field">
                                    <select name="customerTable" id="customerTable">
                                        <option value="" hidden>select table number</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">3</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <button class="btnTable">Update tables</button>
                            </div>
                                <!-- <div class="card-bottom-group order-number-field">
                                    <select name="customerTable" id="customerTable">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                      
                                    </select>
                                </div> -->
                            <div class="button-section">
                                <button type="submit" id="submitOrderBtn">
                                    <span>proceed to kitchen</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </button>
                                <button type="submit" id="standByOrder">
                                    <span>stand by order</span>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </button>
                            </div>
                        </div>
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
<!-- <script src="../js/menu_entry_panel.js"></script> -->
<!-- <script src="../js/popup_forms.js"></script> -->
<script src="../js/order_entry_panel.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
<!-- <script src="../js/order_processing.js"></script> -->
</body>
</html>