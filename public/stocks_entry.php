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
    <link rel="stylesheet" href="../css/stocks_entry.css">
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
            <div class="content-header">
                <div class="header-text">
                    <h1>Wanna add some stocks <span></span></h1>
                    <h4>Let's add item stocks and make sales...</h4>
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
                <div class="inserting-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">add new stocks</h1>
                    </div>
                    <div class="inserting-form-container">
                        <form action="../php/stocks_entry.php" class="inserting-dish-form" method="POST" enctype="multipart/form-data">
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
                            <input type="hidden" name="submission_time" value="<?php echo date('Y-m-d H:i:s'); ?>">
                            <div class="form-groups">
                                <div class="form-group">
                                    <label for="">item name</label>
                                    <input type="text" name="stock_name" value="<?php echo (isset($_GET['stock_name']))?$_GET['stock_name']:"" ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">stocks quantity</label>
                                    <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?php echo (isset($_GET['stock_quantity']))?$_GET['stock_quantity']:"" ?>">
                                </div>
                            </div>
                            <div class="form-group">
                            <select name="stock_units" id="stock_units">
                                <option value="" hidden>Select stock unit</option> <!-- Default option -->
                                <option value="KG" <?php echo (isset($_GET['stock_units']) && $_GET['stock_units'] == 'KG') ? 'selected' : ''; ?>>KG</option>
                                <option value="Pieces" <?php echo (isset($_GET['stock_units']) && $_GET['stock_units'] == 'Pieces') ? 'selected' : ''; ?>>Pieces</option>
                            </select>

                            </div>
                            <div class="form-groups button-group">
                                <button class="btn-cancel" type="reset">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <span>reset field</span>
                                </button>
                                <button class="btn-save" type="submit">
                                    <i class="fa-regular fa-floppy-disk"></i>
                                    <span>save item</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="registered-menu-section">
                    <div class="registered-menu-container">
                        <div class="menu-header">
                            <h1 class="menu-header-title">Registered Items</h1>
                            <div class="menu-category">
                                <select name="stock_categories" id="stock_categories">
                                    <option value="all">All Items</option>
                                    <option value="KG">Kilogram Items</option>
                                    <option value="Pieces">Pieces Items</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="menu-card-content">
                            <?php
                            include_once "../includes/connection.php";
                            // Fetch all registered stocks
                            $sql = "SELECT * FROM stocks";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $stockStatus = $row['stock_status']; // Fetch stock status from the database
                                    ?>
                                    <div class="menu-cards" data-category="<?php echo $row['stock_unit']; ?>" data-status="<?php echo $row['stock_status']; ?>">
                                        <div class="menu-cards-group menu-details">
                                            <h1 class="menu-cards-menu-title"><?php echo $row['stock_name']; ?></h1>
                                            <p class="menu-cards-menu-stock">Stocks: <span><?php echo $row['stock_quantity']; ?></span> <?php echo $row['stock_unit']; ?></p>
                                        </div>
                                        <div class="menu-cards-button">
                                            <!-- Edit button (disable if inactive) -->
                                            <i class="fa-regular fa-pen-to-square btn-edit" 
                                            data-product-id="<?php echo $row['stock_id']; ?>" 
                                            style="<?php echo ($row['stock_status'] === 'inactive') ? 'pointer-events: none; opacity: 0.5;' : ''; ?>"></i>

                                            <!-- Delete button (only show if active) -->
                                            <i class="fa-regular fa-trash-can btn-delete" 
                                            data-product-id="<?php echo $row['stock_id']; ?>" 
                                            style="<?php echo ($row['stock_status'] === 'inactive') ? 'display: none;' : ''; ?>"></i>

                                            <!-- Return button (only show if inactive) -->
                                            <i class="fa-solid fa-rotate-left btn-return" 
                                            data-product-id="<?php echo $row['stock_id']; ?>" 
                                            style="<?php echo ($row['stock_status'] === 'active') ? 'display: none;' : ''; ?>"></i>
                                        </div>
                                    </div>

                                    <?php
                                }
                            } else {
                                echo "<p>No stock items found.</p>";
                            }
                            $conn->close();
                            ?>
                        </div>
                        <div class="stock-history">
                            <a href="../public/stocks_history.php" class="btn-history">view history</a>
                        </div>
                    </div>
                    
            <!-- ------------------------------------stock dropdown------------------------------- -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const categorySelect = document.getElementById('stock_categories');
                            const stockItems = document.querySelectorAll('.menu-cards');

                            categorySelect.addEventListener('change', function() {
                                const selectedCategory = this.value;

                                stockItems.forEach(function(item) {
                                    const itemCategory = item.getAttribute('data-category');
                                    const itemStatus = item.getAttribute('data-status');

                                    // Logic for filtering based on category and status
                                    if (selectedCategory === 'all') {
                                        // Show all items
                                        item.style.display = 'flex';
                                    } else if (selectedCategory === 'active' || selectedCategory === 'inactive') {
                                        // Show items based on their status (active or inactive)
                                        if (itemStatus === selectedCategory) {
                                            item.style.display = 'flex';
                                        } else {
                                            item.style.display = 'none';
                                        }
                                    } else {
                                        // Show items based on their category (KG, Pieces)
                                        if (itemCategory === selectedCategory) {
                                            item.style.display = 'flex';
                                        } else {
                                            item.style.display = 'none';
                                        }
                                    }
                                });
                            });
                        });

                    </script>

                    <!-- ------------------Fetching Data Using AJAx----------------------- -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get all the edit buttons
                        const editButtons = document.querySelectorAll('.btn-edit');

                        // Add click event listeners to each edit button
                        editButtons.forEach(function(button) {
                            button.addEventListener('click', function() {
                                const stockID = this.getAttribute('data-product-id');

                                // Perform AJAX request to fetch data
                                fetch(`../php/get_stock.php?stock_id=${stockID}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Populate the form with the fetched data
                                            document.getElementById('item_id').value = data.stock_id;
                                            document.getElementById('item_name').value = data.stock_name;
                                            document.getElementById('item_quantity').value = data.stock_quantity;
                                            document.getElementById('stock_unit').value = data.stock_unit;

                                            // Open the popup (you may need to adjust this depending on how your popup works)
                                            document.querySelector('.popup-form-container').style.display = 'block';
                                            document.querySelector('.popup-overlay').style.display = 'block';
                                        } else {
                                            alert('Failed to retrieve data. Please try again.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching stock details:', error);
                                        alert('An error occurred. Please try again later.');
                                    });
                            });
                        });

                        // Close the popup when the close button or outside of the popup is clicked
                        // document.querySelector('.popup-form-container').addEventListener('click', function(event) {
                        //     if (event.target.classList.contains('popup-form-container')) {
                        //         this.style.display = 'none';
                        //     }
                        // });
                    });
                </script>

        <!-- --------------------------Set Status for stock------------------------ -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const deleteButtons = document.querySelectorAll('.btn-delete');
                        const returnButtons = document.querySelectorAll('.btn-return');
                        const confirmationOverlay = document.querySelector('.delete-confirmation-overlay');
                        const confirmationContainer = document.querySelector('.delete-confirmation-container');
                        const confirmDeleteButton = document.querySelector('.confirm-delete');
                        const confirmCancelButton = document.querySelector('.confirm-cancel');
                        
                        // For return confirmation
                        const returnOverlay = document.querySelector('.return-confirmation-overlay');
                        const returnContainer = document.querySelector('.return-confirmation-container');
                        const confirmReturnButton = document.querySelector('.return-btn');
                        const cancelReturnButton = document.querySelector('.return-cancel');

                        let selectedProductId = null; // To store the product ID for the selected item

                        // Show confirmation popup when delete button is clicked
                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                selectedProductId = this.getAttribute('data-product-id');
                                confirmationOverlay.style.display = 'block';
                                confirmationContainer.style.display = 'block';
                            });
                        });

                        // Cancel button in confirmation popup for delete
                        confirmCancelButton.addEventListener('click', function() {
                            confirmationOverlay.style.display = 'none';
                            confirmationContainer.style.display = 'none';
                            selectedProductId = null; // Reset the product ID
                        });

                        // Confirm delete (set as inactive)
                        confirmDeleteButton.addEventListener('click', function() {
                            if (selectedProductId) {
                                // Send AJAX request to set the item as inactive
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', '../php/set_stock_inactive.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // Update the UI to reflect the inactive status
                                        const menuCard = document.querySelector(`[data-product-id="${selectedProductId}"]`).closest('.menu-cards');
                                        const deleteButton = menuCard.querySelector('.btn-delete');
                                        const returnButton = menuCard.querySelector('.btn-return');
                                        const editButton = menuCard.querySelector('.btn-edit');

                                        // Hide delete button and show return button
                                        deleteButton.style.display = 'none';
                                        returnButton.style.display = 'inline-block';

                                        // Disable the edit button
                                        editButton.style.pointerEvents = 'none';
                                        editButton.style.opacity = '0.5';

                                        // Hide confirmation popup
                                        confirmationOverlay.style.display = 'none';
                                        confirmationContainer.style.display = 'none';
                                        selectedProductId = null;

                                        window.location.href = '../public/stocks_entry.php?success=Stocks item set as inactive';
                                    }
                                };
                                xhr.send(`product_id=${selectedProductId}`);
                            }
                        });

                        // Show confirmation popup when return button is clicked
                        returnButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                selectedProductId = this.getAttribute('data-product-id');
                                returnOverlay.style.display = 'block';
                                returnContainer.style.display = 'block';
                            });
                        });

                        // Cancel button in confirmation popup for return
                        cancelReturnButton.addEventListener('click', function() {
                            returnOverlay.style.display = 'none';
                            returnContainer.style.display = 'none';
                            selectedProductId = null; // Reset the product ID
                        });

                        // Confirm return (set as active)
                        confirmReturnButton.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            if (selectedProductId) {
                                // Send AJAX request to set the item as active
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', '../php/set_stock_active.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // Update the UI to reflect the active status
                                        const menuCard = document.querySelector(`[data-product-id="${selectedProductId}"]`).closest('.menu-cards');
                                        const deleteButton = menuCard.querySelector('.btn-delete');
                                        const returnButton = menuCard.querySelector('.btn-return');
                                        const editButton = menuCard.querySelector('.btn-edit');

                                        // Show delete button and hide return button
                                        deleteButton.style.display = 'inline-block';
                                        returnButton.style.display = 'none';

                                        // Enable the edit button
                                        editButton.style.pointerEvents = 'auto';
                                        editButton.style.opacity = '1';

                                        // Hide return confirmation popup
                                        returnOverlay.style.display = 'none';
                                        returnContainer.style.display = 'none';
                                        selectedProductId = null;

                                        window.location.href = '../public/stocks_entry.php?success=Stock item set as active';
                                    }
                                };
                                xhr.send(`product_id=${selectedProductId}`);
                                
                            }
                        });
                    });
                    </script>
                </div>
            </div>

            <div class="popup-overlay"></div>
            <div class="popup-form-container">
                <div class="popup-form-header">
                    <h1>update item / add new stock</h1>
                    <i class="fa-regular fa-circle-xmark btn-close"></i>
                </div>
                <div class="popup-content">
                    <form action="../php/stocks_update.php" class="popup-form" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="item_id" id="item_id">
                        <input type="hidden" name="submission_time" value="<?php date_default_timezone_set('Asia/Manila'); echo date('Y-m-d H:i:s'); ?>">
                        <div class="form-groups popup-form-groups">
                            <div class="form-group">
                                <label for="">item name</label>
                                <input type="text" id="item_name" name="item_name">
                            </div>
                            <div class="form-group">
                                <label for="">stocks quantity</label>
                                <input type="number" id="item_quantity" name="item_quantity" min="0">
                            </div>
                        </div>
                        <div class="menu-category item-category">
                            <select name="stock_unit" id="stock_unit">
                                <option value="KG">KG</option>
                                <option value="Pieces">Pieces</option>
                            </select>
                        </div>
                        <div class="form-groups button-group">
                            <button class="btn-save" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <span>Update Item</span>
                            </button>
                        </div>
                    </form> 
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
</body>

</html>