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
    <link rel="stylesheet" href="../css/settlement_panel.css">
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
            <div class="content-header">
                <div class="header-text">
                    <h1>Let's seize the day! <span></span></h1>
                    <h4>Let's settle payments and make sales...</h4>
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
                    <div class="menu-header">
                        <h1 class="menu-header-title">unpaid</h1>
                    </div>
                    <div class="first-panel-cards-container order-cards-container">
                        <div class="card order-item-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons">
                                <button class="btn-settle">settle</button>
                                <button class="btn-credit">credit</button>
                            </div>
                        </div>
                        <div class="card order-item-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons">
                                <button class="btn-settle">settle</button>
                                <button class="btn-credit">credit</button>
                            </div>
                        </div>
                        <div class="card order-item-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons">
                                <button class="btn-settle">settle</button>
                                <button class="btn-credit">credit</button>
                            </div>
                        </div>
                        <div class="card order-item-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons">
                                <button class="btn-settle">settle</button>
                                <button class="btn-credit">credit</button>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="popup-card-container popup-settlement-paid">
                    <div class="popup-card-header">
                       <div class="popup-card-header-row">
                            <h1 class="popup-order-title">Checkout</h1>
                            <i class="fa-regular fa-circle-xmark btn-close"></i>
                       </div>
                       <div class="popup-card-header-col">
                            <h1 class="popup-order-number">Order # 0000</h1>
                            <h1 class="popup-order-name">Customer name: <span>John Doe</span></h1>
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
                                        <tr>
                                            <td>Bangus</td>
                                            <td>2 Kilo (s)</td>
                                            <td>700</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Shrimp</td>
                                            <td>2 Kilo (s)</td>
                                            <td>800</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
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
                                        <input type="number" step="1" min="0" disabled>
                                    </div>
                                </div>
                                <div class="popup-card-groups">
                                    <div class="popup-card-group">
                                        <label for="">cash tender</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0">
                                        </div>
                                    </div>
                                    <div class="popup-card-group">
                                        <label for="">change</label>
                                        <div class="popup-card-input-group">
                                            <span>&#x20B1;</span>
                                            <input type="number" step="1" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-card-button">
                                    <button>
                                        <span>pay & save</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-card-container popup-settlement-credit">
                    <div class="popup-card-header">
                       <div class="popup-card-header-row">
                            <h1 class="popup-order-title">credit process</h1>
                            <i class="fa-regular fa-circle-xmark btn-close"></i>
                       </div>
                       <div class="popup-card-header-col">
                            <h1 class="popup-order-number">Order # 0000</h1>
                            <h1 class="popup-order-name">Customer name: <span>John Doe</span></h1>
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
                                        <tr>
                                            <td>Bangus</td>
                                            <td>2 Kilo (s)</td>
                                            <td>700</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Shrimp</td>
                                            <td>2 Kilo (s)</td>
                                            <td>800</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
                                        <tr>
                                            <td>Rice</td>
                                            <td>2</td>
                                            <td>130</td>
                                        </tr>
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
                                        <input type="number" step="1" min="0">
                                    </div>
                                </div>
                                <div class="popup-card-group">
                                    <label for="">additional note</label>
                                    <textarea name="" id="" cols="20"></textarea>
                                </div>
                                <div class="popup-card-button">
                                    <button>
                                        <span>save credit</span>
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
                        <!-- <div class="dropdown-category menu-category">
                            <select name="menu_category" id="">
                                <option value="" hidden>select menu category</option>
                                <option value="Main Course">main course</option>
                                <option value="Dessert">Dessert</option>s
                                <option value="Beverages">beverages</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="second-panel-card-container order-serve-section">
                        <div class="card order-serve-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons text-indicator">
                                <h3 class="card-text paid">
                                    <i class="fa-regular fa-circle-check"></i>
                                    <span>paid</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card order-serve-card">
                            <div class="card-img-container">
                                <img src="../assets/fish haha.jpg" class="card-img order-img">
                            </div>
                            <div class="card-details order-card-details">
                                <span class="card-name order-number">Order # 0001</span>
                            </div>
                            <div class="card-buttons text-indicator">
                                <h3 class="card-text credit">
                                    <i class="fa-regular fa-circle-check"></i>
                                    <span>Saved as Credit</span>
                                </h3>
                            </div>
                        </div>                   
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
<script src="../js/settlement_panel.js"></script>
<script src="../js/logout.js"></script>
</body>
</html>