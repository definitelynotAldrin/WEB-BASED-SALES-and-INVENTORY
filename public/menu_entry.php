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
    <link rel="stylesheet" href="../css/menu_entry.css">
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
            <div class="content-header">
                <div class="header-text">
                    <h1>Wanna add some menu? <span></span></h1>
                    <h4>Let's add delicious dishes and make sales...</h4>
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
                <div class="inserting-section">
                    <div class="menu-header">
                        <h1 class="menu-header-title">add new menu</h1>
                        <!-- <div class="menu-category">
                            <select name="menu_insert_category" class="menu-insert-category" id="menu_insert_category">
                                <option value="main-course">main course</option>
                                <option value="dessert">Dessert</option>
                                <option value="beverages">beverages</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="inserting-form-container">
                        <form action="../php/menu_entry.php" class="inserting-dish-form" method="POST" enctype="multipart/form-data">
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
                            <div class="form-groups">
                                <div class="form-group">
                                    <label for="">item name</label>
                                    <input type="text" name="item_name" value="<?php echo (isset($_GET['item_name']))?$_GET['item_name']:"" ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">price</label>
                                    <input type="number" step="1" min="0" name="item_price" value="<?php echo (isset($_GET['item_price']))?$_GET['item_price']:"" ?>">
                                </div>
                            </div>
                            <div class="form-groups">
                            <div class="form-group">
                                <label for="item_categories">select category</label>
                                <select name="item_categories" id="item_categories">
                                    <!-- <option value="" hidden>select category</option> -->
                                    <option value="Main Course" <?php echo (isset($_GET['item_categories']) && $_GET['item_categories'] == 'Main Course') ? 'selected' : ''; ?>>main course</option>
                                    <option value="Dessert" <?php echo (isset($_GET['item_categories']) && $_GET['item_categories'] == 'Dessert') ? 'selected' : ''; ?>>Dessert</option>
                                    <option value="Beverages" <?php echo (isset($_GET['item_categories']) && $_GET['item_categories'] == 'Beverages') ? 'selected' : ''; ?>>beverages</option>
                                </select>
                            </div>
                                <div class="form-group">
                                    <label for="stock_categories">Ingredient(Main Course)</label>
                                    <select id="stock_categories" name="stock_categories">
                                        <option value="" hidden>none</option>
                                    <?php
                                        include_once "../includes/connection.php";

                                        // Fetch data from the 'representative' table
                                        $query = "SELECT * FROM stocks ORDER BY stock_id DESC";
                                        $result = mysqli_query($conn, $query);

                                        // Loop through the result and create options for the select
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['stock_name']}' " . 
                                            ((isset($_GET['stock_categories']) && $_GET['stock_categories'] == $row['stock_name']) ? 'selected' : '') . 
                                            ">{$row['stock_name']}</option>";
                                        
                                        }

                                        // Close the database connection
                                        
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group image-form" id="image-form">
                                <label for="">Menu Image</label>
                                <div class="form-image-container" id="form_image_container">
                                    <img src="../assets/thumbnail.webp" id="item_image">
                                </div>
                                <label for="input-image" class="input-image">upload image</label>
                                <input type="file" id="input-image" name="item_photo" accept="image/*" value="<?php echo (isset($_GET['item_photo']))?$_GET['item_photo']:"" ?>">
                            </div> 
                            <div class="form-groups button-group">
                                <button class="btn-cancel" type="reset">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    <span>reset field</span>
                                </button>
                                <button class="btn-save" type="submit">
                                    <i class="fa-regular fa-floppy-disk"></i>
                                    <span>save menu</span>
                                </button>
                            </div>
                            <!-- <div class="pop-up-overlay inserting-confirmation-overlay"></div>
                            <div class="pop-up-container inserting-confirmation-container">
                                <div class="pop-up-content inserting-confirmation-content">
                                    <i class="fa-solid fa-question"></i>
                                    <h1>Are you sure you want register this item?</h1>
                                    <div class="pop-up-buttons logout-buttons">
                                        <button type="button" class="btn-second btnCancel">no</button>
                                        <button type="submit" class="btn-first btnSave">yes</button>
                                    </div>
                                </div>
                            </div> -->
                        </form>                      
                    </div>
                </div>
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
                                            <img src="<?php echo $row['item_image']; ?>" alt="<?php echo $row['item_name']; ?>">
                                        </div>
                                        <div class="menu-cards-group menu-details">
                                            <h1 class="menu-cards-menu-title"><?php echo $row['item_name']; ?></h1>
                                            <p class="menu-cards-menu-desc"><?php echo $row['item_category']; ?></p>
                                        </div>
                                        <div class="menu-cards-buttons">
                                            <a href="edit_menu_entry.php?item_id=<?php echo $row['item_id']; ?>">
                                                <i class="fa-regular fa-pen-to-square btn-edit"></i>
                                            </a>
                                            <a href="#">
                                                <i class="fa-regular fa-trash-can btn-delete"></i>
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
<!-- <script src="../js/popup_confirmations.js"></script> -->
</body>

</html>