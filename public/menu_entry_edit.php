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



include_once "../includes/connection.php";

if (!isset($_GET['item_id'])) {
    $errorMsg = 'item does not exist!';
    header("Location: ../public/menu_entry.php?error=$errorMsg");
    exit();
}

$itemID = $_GET['item_id'];

// Fetch the menu item data
$sql = "SELECT * FROM menu_items WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $itemID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $errorMsg = 'Something went wrong!';
    header("Location: ../public/menu_entry.php?error=$errorMsg");
    exit();
}

$menuItem = $result->fetch_assoc();
$stmt->close();

// Fetch the associated stocks
$stockQuery = "SELECT s.stock_id, s.stock_name, mis.quantity_required
               FROM menu_item_stocks mis
               JOIN stocks s ON mis.stock_id = s.stock_id
               WHERE mis.menu_item_id = ?";
$stockStmt = $conn->prepare($stockQuery);
$stockStmt->bind_param("i", $itemID);
$stockStmt->execute();
$stocks = $stockStmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stockStmt->close();
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
    <link rel="stylesheet" href="../css/menu_entry.css">
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
                            <a href="../public/menu_entry.php" class="active">
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
        <div class="alert error-message" id="error-container"></div>
        <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1>Wanna add some menu? <span></span></h1>
                    <h4>Let's add delicious dishes and make sales...</h4>
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
                            sessionUserRole = "<?php echo $user_role; ?>";
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
                                                    `<div class="notification-group ${message.user_role === sessionUserRole ? 'sender-group right-box' : 'replier-group left-box'}">
                                                        <div class="notification-details ${message.user_role === sessionUserRole ? 'right-details' : 'left-box'}">
                                                            <span class="notification-username">${message.user_role}</span>
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
                                var userRole = "<?php echo $user_role; ?>"; // Assumes $user_role is set in PHP
                                var textMessage = $('#message-input').val();

                                if (textMessage.trim() === "") {
                                    displayErrorMessage("Please enter a message.");
                                    return;
                                }

                                $.ajax({
                                    url: '../php/send_message.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        user_role: userRole,
                                        text_message: textMessage
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // Display new messages without waiting for the interval
                                            loadMessages();
                                            $('#message-input').val(''); // Clear input after sending
                                            $('.notification-message-wrapper').scrollTop($('.notification-message-wrapper')[0].scrollHeight);
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
                    <div class="profile">
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="menu-section-container">
                <div class="inserting-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">Update Menu</h1>
                    </div>
                    <div class="inserting-form-container">
                        <form action="../php/edit_menu_entry.php" method="POST" class="inserting-dish-form" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo htmlspecialchars($itemID); ?>" name="item_id">

                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo htmlspecialchars($_GET['error']); ?>
                                </div>
                            <?php } ?>

                            <?php if (isset($_GET['success'])) { ?>
                                <div class="success alert-success" role="alert">
                                    <?php echo htmlspecialchars($_GET['success']); ?>
                                </div>
                            <?php } ?>

                            <div class="form-groups">
                                <div class="form-group">
                                    <label for="item_name">Item Name</label>
                                    <input type="text" name="item_name" value="<?php echo htmlspecialchars($menuItem['item_name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="item_price">Price</label>
                                    <input type="number" name="item_price" step="0.01" min="0" value="<?php echo htmlspecialchars($menuItem['item_price']); ?>">
                                </div>
                            </div>

                            <div class="form-groups">
                                <div class="form-group">
                                    <label for="item_categories">Category</label>
                                    <select name="item_categories" id="item_categories">
                                        <option value="" hidden>Select a category</option>
                                        <option value="Main Course" <?php echo ($menuItem['item_category'] == 'Main Course') ? 'selected' : ''; ?>>Main Course</option>
                                        <option value="Dessert" <?php echo ($menuItem['item_category'] == 'Dessert') ? 'selected' : ''; ?>>Dessert</option>
                                        <option value="Beverages" <?php echo ($menuItem['item_category'] == 'Beverages') ? 'selected' : ''; ?>>Beverages</option>
                                    </select>
                                </div>
                            </div>
                                <!-- Dynamic Stock Fields -->
                                <div id="stock_fields" class="form-group">
                                    <?php foreach ($stocks as $index => $stock) { ?>
                                        <div class="form-groups stock_entry" id="stock_entry_<?php echo $index + 1; ?>">
                                            <div class="form-group">
                                                <label for="stock_categories_<?php echo $index + 1; ?>">ingredients</label>
                                                <select id="stock_categories_<?php echo $index + 1; ?>" name="stock_id[]" required>
                                                    <option value="" hidden>Select Stock ingredients</option>
                                                    <?php
                                                    $stockQuery = "SELECT * FROM stocks ORDER BY stock_name ASC";
                                                    $stockResult = $conn->query($stockQuery);
                                                    while ($row = $stockResult->fetch_assoc()) {
                                                        $selected = ($row['stock_id'] == $stock['stock_id']) ? 'selected' : '';
                                                        echo "<option value='{$row['stock_id']}' $selected>{$row['stock_name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <input type="hidden" step="0.01" min="0" name="quantities[]" required value="1">
                                            <i class="fa-regular fa-circle-xmark remove-field" onclick="removeSpecificField(this)"></i>
                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- Add and Remove Stock Buttons -->
                                <div class="form-groups button-group">
                                    <button type="button" class="button-add" onclick="addStockField()">
                                        <span>Add Column</span>
                                    </button>
                                </div>

                                <div class="form-group image-form" id="image-form">
                                    <label for="">Menu Image</label>
                                    <div class="form-image-container" id="form_image_container">
                                        <?php
                                        if (!empty($menuItem['item_image'])) {
                                            echo "<img src='../uploads/" . htmlspecialchars($menuItem['item_image']) . "' id='item_image'>";
                                        } else {
                                            echo "<img src='../assets/thumbnail.webp' id='item_image'>";
                                        }
                                        ?>
                                    </div>
                                    <label for="input-image" class="input-image">Upload Image</label>
                                    <input type="file" id="input-image" name="item_photo" accept="image/*">
                                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($menuItem['item_image']); ?>">
                                </div>

                                <div class="form-groups button-group">
                                    <button class="btn-cancel" type="button">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>Cancel</span>
                                    </button>
                                    <button class="btn-save" type="submit">
                                        <i class="fa-regular fa-floppy-disk"></i>
                                        <span>Save Menu</span>
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
                     

            <!-- JavaScript for adding/removing stock fields -->
            <script>
                let stockCount = 1;

                // Function to add new stock fields
                function addStockField() {
                    stockCount++;
                    const container = document.getElementById('stock_fields');
                    const newField = document.createElement('div');
                    newField.className = 'form-groups stock_entry';
                    newField.id = `stock_entry_${stockCount}`;
                    newField.innerHTML = `
                        <div class="form-group">
                            <label for="stock_categories_${stockCount}">Ingredient</label>
                            <select id="stock_categories_${stockCount}" name="stock_id[]" required>
                                <option value="" hidden>Select Stock ingredient</option>
                                <?php
                                // PHP to populate stock options from the database
                                $query = "SELECT * FROM stocks";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['stock_id']}'>{$row['stock_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" step="0.01" min="0" name="quantities[]" required value="1">
                        <!-- Remove field icon -->
                        <i class="fa-regular fa-circle-xmark remove-field" onclick="removeSpecificField(this)"></i>
                    `;
                    container.appendChild(newField);
                }

                // Function to remove a specific stock field
                function removeSpecificField(element) {
                    const container = document.getElementById('stock_fields');
                    const stockFields = container.querySelectorAll('.stock_entry');  // Get all stock entry fields

                    // Ensure at least one stock field remains
                    if (stockFields.length > 1) {
                        const fieldToRemove = element.parentElement;  // Get the parent of the icon (the stock entry)
                        fieldToRemove.remove();
                    } else {
                        window.location.href = '../public/menu_entry.php?error=At least one stock field must remain.';
                    }
                }
            </script>

                <?php
                    include_once "../includes/connection.php";

                    // Fetch all registered menu items
                    $sql = "SELECT * FROM menu_items";
                    $result = $conn->query($sql);

                    ?>

                    <div class="registered-menu-section">
                        <div class="menu-header">
                            <h1 class="menu-header-title">registered menu</h1>
                            <div class="menu-category">
                                <select name="menu_categories" id="menu_categories">
                                    <option value="all">All Categories</option>
                                    <option value="Main Course">Main Course</option>
                                    <option value="Dessert">Dessert</option>
                                    <option value="Beverages">Beverages</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-card-content">
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <input type="hidden" name="hidden_id" value="<?php echo $row['item_id']; ?>">
                                    <div class="menu-cards menu-item" data-category="<?php echo $row['item_category']; ?>">
                                        <div class="menu-card-img">
                                            <img src="../uploads/<?php echo $row['item_image']; ?>" alt="<?php echo $row['item_name']; ?>">
                                        </div>
                                        <div class="menu-cards-group menu-details">
                                            <h1 class="menu-cards-menu-title"><?php echo $row['item_name']; ?></h1>
                                            <p class="menu-cards-menu-desc"><?php echo $row['item_category']; ?></p>
                                        </div>
                                        <div class="menu-cards-buttons">
                                            <a href="menu_entry_edit.php?item_id=<?php echo $row['item_id']; ?>&success=You're now in update section">
                                                <i class="fa-regular fa-pen-to-square btn-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p>No menu items found.</p>";
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    $conn->close();
                    ?>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const categorySelect = document.getElementById('menu_categories');
                        const menuItems = document.querySelectorAll('.menu-item');

                        categorySelect.addEventListener('change', function() {
                            const selectedCategory = this.value;

                            menuItems.forEach(function(item) {
                                if (selectedCategory === 'all' || item.getAttribute('data-category') === selectedCategory) {
                                    item.style.display = 'flex';
                                } else {
                                    item.style.display = 'none';
                                }
                            });
                        });
                    });


                    function capitalizeFirstLetter(str) {
                            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
                        }

                        const elements = document.querySelectorAll('.menu-cards-menu-title');
                        elements.forEach(el => {
                            el.textContent = capitalizeFirstLetter(el.textContent);
                        });

                    </script>

            </div>
            <div class="delete-confirmation-overlay"></div>
                <div class="delete-confirmation-container">
                    <div class="delete-confirmation-content">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <h1>Are you sure?</h1>
                        <p>Setting this item as an inactive will cause not showing in the order menu.</p>
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
<script>
    const imageProduct = document.getElementById("item_image");
    const inputImage = document.getElementById("input-image");

    inputImage.onchange = function(){
        imageProduct.src = URL.createObjectURL(inputImage.files[0]);
    }

</script>
<script src="../js/sidenav.js"></script>
<script src="../js/menu_entry_panel.js"></script>
<script src="../js/edit_tempFile.js"></script>
<script src="../js/popup_forms.js"></script>
<script src="../js/logout.js"></script>
<script src="../js/alert_disappear.js"></script>
<script src="../js/hyperlinks_nav.js"></script>
<!-- <script src="../js/popup_confirmations.js"></script> -->
</body>

</html>