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
            <div class="content-header">
                <div class="header-text">
                    <h1>Let's seize the day! <span></span></h1>
                    <h4>Let's take some orders and make sales...</h4>
                </div>
                <div class="header-profile">
                    <div class="notification">
                        <i class="fa-solid fa-bell notification-bell">
                            <i class="fa-solid fa-circle"></i>
                        </i>
                        <div class="notification-content-container">
                            <h1 class="notification-title">Notifications</h1>
                           <div class="notification-card-container">
                                <div class="notification-content">
                                    <div class="notification-img">
                                        <img src="../assets/mark.png" alt="">
                                    </div>
                                    <div class="notification-details">
                                        <h1 class="notification-details-title">coke</h1>
                                        <p><span>Stock Alert:</span> This item is running low. <br>Only <span>20</span> available.</p>
                                    </div>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-img">
                                        <img src="../assets/mark.png" alt="">
                                    </div>
                                    <div class="notification-details">
                                        <h1 class="notification-details-title">shrimp</h1>
                                        <p><span>Stock Alert:</span> This item is running low. <br>Only <span>20</span> kg available.</p>
                                    </div>
                                </div>
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
                        <h1 class="menu-header-title">Order Menu</h1>
                        <div class="dropdown-category menu-category">
                            <select name="menu_insert_category" class="menu-insert-category" id="menu_insert_category">
                                <option value="main-course">main course</option>
                                <option value="dessert">Dessert</option>
                                <option value="beverages">beverages</option>
                            </select>
                        </div>
                    </div>
                    <div class="first-panel-cards-container menu-cards-container">
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>               
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                        <div class="card menu-item-card">
                            <img src="../assets/fish haha.jpg" class="card-img menu-img">
                            <div class="card-details menu-card-details">
                                <span class="card-name menu-name">humba</span>
                            </div>
                        </div>
                    </div>
                  
                    <div class="popup_order_quantity maincourse-quantity">
                        <div class="popup-header">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <h1>Input how many kilo (s) does the order require.</h1>
                        </div>
                        <form action="">
                            <div class="card-group">
                                <!-- HIDDEN INPUTS FOR STORING DATA FROM THE MENU -->
                                <input type="hidden" name="product_id" id="product_id">
                                <input type="hidden" name="product_name" id="product_name">
                                <div class="card-boxes menu-item-quantity">
                                    <h3>1/4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>1/2</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>3/4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>1</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>2</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>3</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>4</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes menu-item-quantity">
                                    <h3>5</h3>
                                    <span>Kilo(s)</span>
                                </div>
                                <div class="card-boxes card-input-field">
                                    <input type="number" min="1">
                                    <span>Kilo(s)</span>
                                </div>
                            </div>
                            <div class="card-button-group">
                                <button class="btn-cancel" type="button">
                                    <span>cancel</span>
                                </button>
                                <button class="btn-proceed" type="submit">
                                    <span>proceed</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="second-panel-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">order summary</h1>
                        <!-- <div class="dropdown-category menu-category">
                            <select name="menu_category" id="">
                                <option value="" hidden>select menu category</option>
                                <option value="Main Course">main course</option>
                                <option value="Dessert">Dessert</option>s
                                <option value="Beverages">beverages</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="second-panel-card-container order-summary-section">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="order-header">order</th>
                                        <th class="quantity-header">quantity</th>
                                        <th class="subtotal-header">sub-total</th>
                                        <th class="action-header"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lambing</td>
                                        <td>5 Kilo (s)</td>
                                        <td>&#8369;800.00</td>
                                        <td class="btn-remove">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-bottom-container total-section">
                            <div class="card-bottom-group total-field">
                                <h3>total</h3>
                                <span>&#8369; 1000.00</span>
                            </div>
                            <div class="card-bottom-group note-field">
                                    <h3>note</h3>
                                    <input type="text" placeholder="Optional" name="customer_note">
                                </div>
                            <div class="card-bottom-groups">
                                <div class="card-bottom-group customer-field">
                                    <h3>customer name</h3>
                                    <input type="text" name="customer_name">
                                </div>
                                <div class="card-bottom-group note-field">
                                    <h3>customer location</h3>
                                    <input type="text" name="customer_location">
                                </div>
                            </div>
                        </div>
                        <div class="button-section">
                            <button type="submit">
                                <span>proceed to kitchen</span>
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-overlay"></div>

            <!-- <div class="popup-overlay"></div>
            <div class="popup-form-container">
                <div class="popup-form-header">
                    <h1>update item / add new stock</h1>
                    <i class="fa-regular fa-circle-xmark btn-close"></i>
                </div>
                <div class="popup-content">
                    <form action="" class="popup-form">
                        <div class="form-groups popup-form-groups">
                            <div class="form-group">
                                <label for="">item name</label>
                                <input type="text" id="item_name" name="item_name">
                            </div>
                            <div class="form-group">
                                <label for="">stocks quantity</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" step="1" min="0">
                            </div>
                        </div>
                        <div class="menu-category item-category">
                            <select name="item_category" id="">
                                <option value="" hidden>select menu category</option>
                                <option value="Main Course">main course</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Beverages">beverages</option>
                            </select>
                        </div>
                        <div class="form-groups button-group">
                            <button class="btn-save">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <span>save menu</span>
                            </button>
                        </div>
                    </form> 
                </div>
            </div> -->
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
<script src="../js/menu_entry_panel.js"></script>
<!-- <script src="../js/popup_forms.js"></script> -->
<script src="../js/order_entry_panel.js"></script>
<script src="../js/logout.js"></script>
</body>
</html>