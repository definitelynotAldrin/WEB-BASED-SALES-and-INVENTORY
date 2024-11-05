<?php
session_start();


$account_id = $_SESSION['account_id'];
$user_role = $_SESSION['user_role'];

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
    <link rel="stylesheet" href="../css/stocks_history.css">
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
                            <a href="../public/stocks_entry.php" class="active">
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
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
                </div>
            <?php } ?>
            <?php if(isset($_GET['success'])){ ?>
                <div class="success alert-success" role="success">
                <?php echo $_GET['success']; ?>
                </div>
            <?php } ?>
            <div class="content-header">
                <div class="header-text">
                    <h1>Stock History <span></span></h1>
                    <h4>Yeah nah, let's not.</h4>
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
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="menu-section-container">
                <div class="first-panel-section">
                    <div class="first-panel-header search-area">
                        <form method="GET" action="" id="search-form">
                            <input type="date" name="search_item" id="search_date" placeholder="Search an item" onchange="document.getElementById('search-form').submit();">
                            <input type="text" id="date_display" value="<?php echo (isset($_GET['search_item'])) ? date("F j, Y", strtotime($_GET['search_item'])) : ''; ?>" placeholder="<?php echo date('F j, Y'); ?>"  disabled>
                        </form>
                        
                    </div>

                    <div class="table-container">
                        <?php
                        include_once "../includes/connection.php";
                        date_default_timezone_set('Asia/Manila');

                        // Get the selected date from the input field
                        $search_date = isset($_GET['search_item']) ? $_GET['search_item'] : '';

                        // Prepare the SQL query
                        if ($search_date) {
                            // If a specific date is selected, filter results by that date
                            $sql = "SELECT s.stock_name, sh.previous_quantity, sh.updated_quantity, sh.updated_at, sh.last_action_type 
                                    FROM stock_history sh
                                    JOIN stocks s ON sh.stock_id = s.stock_id
                                    WHERE DATE(sh.updated_at) = '$search_date'";
                        } else {
                            // If no date is selected, filter results by today's date
                            $sql = "SELECT s.stock_name, sh.previous_quantity, sh.updated_quantity, sh.updated_at, sh.last_action_type 
                                    FROM stock_history sh
                                    JOIN stocks s ON sh.stock_id = s.stock_id
                                    WHERE DATE(sh.updated_at) = CURDATE()";
                        }

                        $result = $conn->query($sql);
                        ?>

                        <table>
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th class="quantity">Previous Quantity</th>
                                    <th class="quantity">Added/Changed Quantity</th>
                                    <th>Updated Quantity</th>
                                    <th>action type</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['stock_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['previous_quantity']) . "</td>";
                                        
                                        // Check if the last action was 'insert' or 'update'
                                        if ($row['last_action_type'] === 'insert') {
                                            // For 'insert', display previous + updated quantities
                                            echo "<td>" . htmlspecialchars($row['updated_quantity']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['previous_quantity'] + $row['updated_quantity']) . "</td>"; // Updated stock = previous + added
                                            echo "<td>" . htmlspecialchars($row['last_action_type']) . "</td>";
                                        } elseif ($row['last_action_type'] === 'update') {
                                            // For 'update', just display the change in quantity and the updated total
                                            // $changeQuantity = $row['updated_quantity'] - $row['previous_quantity']; // Calculate change
                                            echo "<td>" . htmlspecialchars($row['updated_quantity']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['updated_quantity']) . "</td>"; // Updated stock = final quantity after update
                                            echo "<td>" . htmlspecialchars($row['last_action_type']) . "</td>";
                                        }
                                        
                                        echo "<td>" . htmlspecialchars(date('M d, Y h:i A', strtotime($row['updated_at']))) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // If no data is found for the selected date or today
                                    echo "<tr><td colspan='5' style='text-align:center;'>No data found for the selected date or today.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        // Close connection
                        $conn->close();
                        ?>
                    </div>

                </div>
            </div>

            <div class="delete-confirmation-overlay"></div>
            <div class="delete-confirmation-container">
                <div class="delete-confirmation-content">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <h1>Are you sure?</h1>
                    <p>Setting this item as an inactive will cause inactivity of the product on the menu.</p>
                    <div class="form-groups button-group confirmation-button">
                        <button class="confirm-delete">set as inactive</button>
                        <button class="confirm-cancel">cancel</button>
                    </div>
                </div>
            </div>
            <div class="pop-up-overlay return-confirmation-overlay"></div>
            <div class="pop-up-container return-confirmation-container">
                <div class="pop-up-content return-confirmation-content">
                    <i class="fa-solid fa-question"></i>
                    <h1>Are you sure?</h1>
                    <p>Do you wish to set this item active again?</p>
                    <div class="pop-up-buttons return-buttons">
                        <a href="#" class="btn-first return-btn">yes</a>
                        <a href="#" class="btn-second return-cancel">no</a>
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
<script src="../js/menu_entry_panel.js"></script>
<script src="../js/popup_forms.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
<script src="../js/hyperlinks_nav.js"></script>
</body>

</html>