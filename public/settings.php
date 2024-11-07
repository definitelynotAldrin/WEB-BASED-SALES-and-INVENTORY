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
    <link rel="stylesheet" href="../css/settings.css">
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
                            <a href="../public/index">
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
            <div class="alert error-message" id="error-container"></div>
            <div class="success success-message" id="success-container"></div>
            <div class="content-header">
                <div class="header-text">
                    <h1>Settings / Admin Profile<span></span></h1>
                    <h4></h4>
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
                            // When the confirm button is clicked
                            $(document).on('click', '.change-security-passwords', function(e) {
                                e.preventDefault();
                                // Show the custom confirmation popup
                                $('.settings-popup-overlay').fadeIn();
                                $('.change-security-password').fadeIn();
                                $('.security-confirmation').fadeIn();


                                // Handle confirmation (yes button)
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    
                                    const account_id = 1;

                                    $.ajax({
                                        url: '../php/security_verification.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                               
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                                console.log(color);
                                                console.log(pet);
                                                console.log(place);
                                                console.log(account_id);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.update-security-button', function(e) {
                                e.preventDefault();

                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text('Are you sure about the changes that going to be made?');

                                // Handle confirmation (yes button)
                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#change-favorite-color').val();
                                    const pet = $('#change-favorite-pet').val();
                                    const place = $('#change-expensive-place').val();

                                    $.ajax({
                                        url: '../php/security_change_password.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                
                                                displaySuccessMessage(response.message);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#change-favorite-color').val('');
                                                $('#change-favorite-pet').val('');
                                                $('#change-expensive-place').val('');

                                                $('.popup-confirmation-container').fadeOut();
                                                $('.change-security-password').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                
                                            } else {
                                                displayErrorMessage('Failed to update: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-username', function(e) {
                                e.preventDefault();

                                $('.change-username-details').fadeIn();
                                $('.settings-popup-overlay').fadeIn();
                                // Handle confirmation (yes button)
                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#change-favorite-color').val();
                                    const pet = $('#change-favorite-pet').val();
                                    const place = $('#change-expensive-place').val();

                                    $.ajax({
                                        url: '../php/security_change_password.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                
                                                displaySuccessMessage(response.message);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#change-favorite-color').val('');
                                                $('#change-favorite-pet').val('');
                                                $('#change-expensive-place').val('');

                                                $('.popup-confirmation-container').fadeOut();
                                                $('.change-security-password').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                
                                            } else {
                                                displayErrorMessage('Failed to update: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-admin-username', function(e) {
                                e.preventDefault();
                                $('.changing-username').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-admin-username').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });


                            $(document).on('click', '.change-service-username', function(e) {
                                e.preventDefault();
                                $('.changing-username').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-service-username').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-kitchen-username', function(e) {
                                e.preventDefault();
                                $('.changing-username').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-kitchen-username').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-account-username-button', function(e) {
                                e.preventDefault();

                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text('Are you sure about the changes that going to be made?');

                                // Handle confirmation (yes button)
                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const currentUsername = $('#current-username').val();
                                    const newUsername = $('#new-username').val();
                                    const retypeNew = $('#retype-new-username').val();
                                    const account_id = $('#hidden-account-id').val();

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/update_username.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            current_username: currentUsername,
                                            new_username: newUsername,
                                            retypeNew_username: retypeNew,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                
                                                displaySuccessMessage(response.message);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#current-username').val('');
                                                $('#new-username').val('');
                                                $('#retype-new-username').val('');
                                                $('#hidden-account-id').val('');

                                                $('.popup-confirmation-container').fadeOut();
                                                $('.changing-username').fadeOut();
                                                $('.change-username-details').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                
                                                $('#hidden-account-id').val('');
                                            } else {
                                                displayErrorMessage('Failed to update: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-password', function(e) {
                                e.preventDefault();

                                $('.change-password-details').fadeIn();
                                $('.settings-popup-overlay').fadeIn();
                                // Handle confirmation (yes button)
                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#change-favorite-color').val();
                                    const pet = $('#change-favorite-pet').val();
                                    const place = $('#change-expensive-place').val();

                                    $.ajax({
                                        url: '../php/security_change_password.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                
                                                displaySuccessMessage(response.message);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#change-favorite-color').val('');
                                                $('#change-favorite-pet').val('');
                                                $('#change-expensive-place').val('');

                                                $('.popup-confirmation-container').fadeOut();
                                                $('.change-security-password').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                
                                            } else {
                                                displayErrorMessage('Failed to update: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-admin-password', function(e) {
                                e.preventDefault();
                                $('.changing-password').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-admin-password').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-service-password', function(e) {
                                e.preventDefault();
                                $('.changing-password').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-service-password').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-kitchen-password', function(e) {
                                e.preventDefault();
                                $('.changing-password').fadeIn();
                                $('.security-confirmation').fadeIn();

                                
                                $('.verify').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const color = $('#favorite-color').val();
                                    const pet = $('#favorite-pet').val();
                                    const place = $('#expensive-place').val();
                                    

                                    const account_id = $('.change-kitchen-password').data('account-id');

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/security_verification_update.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            fav_color: color,
                                            fav_pet: pet,
                                            place: place,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#hidden-account-id').val(account_id);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#favorite-color').val('');
                                                $('#favorite-pet').val('');
                                                $('#expensive-place').val('');
                                                
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            $(document).on('click', '.change-account-password-button', function(e) {
                                e.preventDefault();

                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text('Are you sure about the changes that going to be made?');

                                // Handle confirmation (yes button)
                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const currentPassword = $('#current-password').val();
                                    const newPassword = $('#new-password').val();
                                    const retypeNew = $('#retype-new-password').val();
                                    const account_id = $('#hidden-account-id').val();

                                    console.log(account_id);

                                    $.ajax({
                                        url: '../php/update_password.php', 
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            current_password: currentPassword,
                                            new_password: newPassword,
                                            retypeNew_password: retypeNew,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                
                                                displaySuccessMessage(response.message);
                                                $('.security-confirmation').fadeOut();
                                                
                                                $('#current-password').val('');
                                                $('#new-password').val('');
                                                $('#retype-new-password').val('');
                                                $('#hidden-account-id').val('');

                                                $('.popup-confirmation-container').fadeOut();
                                                $('.changing-username').fadeOut();
                                                $('.change-username-details').fadeOut();
                                                $('.change-password-details').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                
                                                $('#hidden-account-id').val('');
                                            } else {
                                                displayErrorMessage('Failed to update: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });

                            // Handle cancellation (no button)
                            $('.popup-close-button').off('click').on('click', function(e) {
                                e.preventDefault(); // Prevent default link behavior
                                // Hide the popup if "no" is clicked
                                $('.change-security-password').fadeOut();
                                $('.security-confirmation').fadeOut();
                                $('.settings-popup-overlay').fadeOut();
                                $('.change-username-details').fadeOut();
                                $('.change-password-details').fadeOut();
                                $('.changing-username').fadeOut();
                                $('.changing-password').fadeOut();
                                
                            });

                            $('.button-cancel').off('click').on('click', function(e) {
                                e.preventDefault(); // Prevent default link behavior
                                $('.popup-confirmation-container').fadeOut();
                            });
                        });


                        function displaySuccessMessage(message1) {
                            // Create a div to hold the success message
                            const messageDiv = $('<div class="success-message"></div>').text(message1);
                                
                            // Append the message to a specific container in your HTML
                            $('#success-container').html(messageDiv);
                            $('#success-container').fadeIn();

                            // Optionally, remove the message after a few seconds
                            setTimeout(() => {
                                $('#success-container').fadeOut(); // Fade out the message
                            }, 2000); // Change the duration as needed
                        }

                        function displayErrorMessage(message2) {
                            // Create a div to hold the success message
                            const messageDiv = $('<div class="error-message"></div>').text(message2);
                                
                            // Append the message to a specific container in your HTML
                            $('#error-container').html(messageDiv);
                            $('#error-container').fadeIn();

                            // Optionally, remove the message after a few seconds
                            setTimeout(() => {
                                $('#error-container').fadeOut(); // Fade out the message
                            }, 2000); // Change the duration as needed
                        }

                        
                    </script>
                    <div class="profile">
                        <img src="../assets/me.jpg" class="admin-profile">
                    </div>
                    <i class="fa-solid fa-bars nav-bar"></i>
                </div>
            </div>
            <div class="settings-container">
                <div class="settings-content">
                        <div class="settings-header">
                            <h1>Account Information</h1>
                        </div>
                        <div class="settings-small-header">
                            <h1>Password & Security Details</h1>
                            <p>Manage your passwords, username and security confirmation.</p>
                        </div>
                        <div class="settings-main-content">
                            <div class="settings-groups change-security-passwords">
                                <h3>Change Security Authentication</h3>
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                            <div class="settings-groups change-username">
                                <h3>Change Username</h3>
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                            <div class="settings-groups change-password">
                                <h3>Change Password</h3>
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        </div>
                </div>
            </div>
            <div class="settings-popup-overlay"></div>


            <div class="settings-popup-container changing-username">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Username</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                        <!-- <p>Your password must be at least 6 characters.</p> -->
                    </div>
                    <div class="settings-popup-form">
                        <input type="hidden" name="hidden_account_id" id="hidden-account-id">
                        <div class="settings-popup-form-group">
                            <label for="current_password">current username</label>
                            <input type="text" id="current-username">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="new_password">new username</label>
                            <input type="text" id="new-username">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="retype_password">retype username</label>
                            <input type="text" id="retype-new-username">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="change-account-username-button">change username</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-popup-container changing-password">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Password</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current-password">
                            <i class="fas fa-eye showHidePassword"></i>
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new-password">
                            <i class="fas fa-eye showHidePassword"></i>
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="retype_password">Retype Password</label>
                            <input type="password" id="retype-new-password">
                            <i class="fas fa-eye showHidePassword"></i>
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="change-account-password-button">Change Password</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="settings-popup-container change-security-password">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Security</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                        <!-- <p>Your password must be at least 6 characters.</p> -->
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="date_establish">Favorite Color</label>
                            <input type="text" id="change-favorite-color">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="new_password">Favorite Pet</label>
                            <input type="text" id="change-favorite-pet">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="retype_password">Name one expensive place you visit?</label>
                            <input type="text" id="change-expensive-place">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="update-security-button">update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-popup-container security-confirmation">
                <div class="settings-popup-content">
                    <div class="settings-popup-header header-authentication">
                        <h1>Verification</h1>
                        <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="date_establish">Favorite Color</label>
                            <input type="text" id="favorite-color">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="new_password">Favorite Pet</label>
                            <input type="text" id="favorite-pet">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="retype_password">Name one expensive place you visit?</label>
                            <input type="text" id="expensive-place">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify">verify answers</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-popup-container change-username-details">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Roles</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                        
                    </div>
                    <div class="settings-main-content">
                        <div class="settings-groups change-admin-username" data-account-id="1">
                            <h3>User Admin</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups change-service-username" data-account-id="2">
                            <h3>User Service</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups change-kitchen-username" data-account-id="3">
                            <h3>User Kitchen</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-popup-container change-password-details">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Roles</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                        
                    </div>
                    <div class="settings-main-content">
                        <div class="settings-groups change-admin-password" data-account-id="1">
                            <h3>User Admin</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups change-service-password" data-account-id="2">
                            <h3>User Service</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups change-kitchen-password" data-account-id="3">
                            <h3>User Kitchen</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pop-up-container popup-confirmation-container">
                <div class="pop-up-content popup-confirmation-content">
                    <i class="fa-solid fa-question"></i>
                    <h1 id="question"></h1>
                    <div class="pop-up-buttons logout-buttons">
                        <a href="#" class="btn-second button-cancel">no</a>
                        <a href="#" class="btn-first button-confirm">yes</a>
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
<script src="../js/hyperlinks_nav.js"></script>
<script src="../js/logout.js"></script>
<!-- <script src="../js/alert_disappear.js"></script> -->
 <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Select all icons with class 'showHidePassword'
    const toggles = document.querySelectorAll('.showHidePassword');

    toggles.forEach(toggle => {
        // Add event listener to each toggle icon
        toggle.addEventListener('click', function() {
            const passwordInput = toggle.previousElementSibling; // Get the input field right before the icon

            // Toggle between password and text type
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        });
    });
});



 </script>
</body>

</html>