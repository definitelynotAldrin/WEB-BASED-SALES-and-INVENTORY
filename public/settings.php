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



                            $('.create-accounts').on('click', function() {
                                $('.create-account-popup').fadeIn();
                                $('.settings-popup-overlay').fadeIn();
                            });

                            $('.btnSignup').on('click', function (e) {
                                e.preventDefault();

                                const role = $('#createRole').val();
                                const email = $('#createEmail').val();
                                const username = $('#createUsername').val();
                                const password = $('#passwordInput').val();

                                

                                // Input validation
                                if (!role || !email || !username || !password) {
                                    displayErrorMessage('All fields are required.');
                                    return;
                                }

                                if (!validatePassword(password)) {
                                    displayErrorMessage('Password must be at least 8 characters long and include at least one number, and one special character.');
                                    return;
                                }

                                $('.popup-confirmation-container').fadeIn(); // Show the popup
                                $('.popup-overlay').fadeIn();

                                $('#question').text('Are you sure you want to create this account?');

                                $('.button-confirm').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $.ajax({
                                        url: '../php/create_account.php', // Path to your PHP script
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            role: role,
                                            email: email,
                                            username: username,
                                            password: password
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                displaySuccessMessage(response.message);
                                                // Optionally clear the form
                                                $('form')[0].reset();
                                                $('.popup-confirmation-container').fadeOut();
                                                $('.popup-overlay').fadeOut();
                                                loadAccounts();
                                            } else {
                                                displayErrorMessage(response.message);
                                                $('.popup-confirmation-container').fadeOut();
                                                $('.popup-overlay').fadeOut();
                                            }
                                        },
                                        error: function () {
                                            $('#error-container').text('An error occurred. Please try again.').show();
                                        }
                                    });
                                });

                                function validatePassword(password) {
                                    const minLength = 8;
                                    const hasNumber = /[0-9]/.test(password);
                                    const hasSpecialChar = /[\W_]/.test(password);

                                    return password.length >= minLength && hasNumber && hasSpecialChar;
                                }
                                // AJAX request

                            });

                            // Show/hide password toggle
                            $('#hidePassword').on('click', function () {
                                $('#passwordInput').attr('type', 'text');
                                $('#hidePassword').hide();
                                $('#showPassword').show();
                            });

                            $('#showPassword').on('click', function () {
                                $('#passwordInput').attr('type', 'password');
                                $('#showPassword').hide();
                                $('#hidePassword').show();
                            });

                            $('.btnCancel').off('click').on('click', function(e) {
                                e.preventDefault(); // Prevent default link behavior
                                $('.popup-confirmation-container').fadeOut();
                                $('.popup-overlay').fadeOut();
                            });




                            $(document).on('click', '.button-active', function(e) {
                                e.preventDefault();

                                const username = $(this).data('account-username'); 
                                const account_id = $(this).data('account-id'); 
                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text(`Are you sure you want to set this account name ${username.toUpperCase()} as active?`);

                                // console.log(username);
                                // console.log(account_id);

                                $('.button-confirm').off('click').on('click', function(e) {
                                    $.ajax({
                                        url: '../php/account_set_as_active.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('.popup-confirmation-container').fadeOut();
                                                loadAccounts();
                                                displaySuccessMessage(response.message);
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

                            $(document).on('click', '.manage-accounts', function(e) {
                                e.preventDefault();

                                $('.manage-account-popup').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.button-inactive').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const account_id = $(this).data('account-id');
                                    const username = "<?php echo $username; ?>";
                                    // console.log(account_id);

                                    $('.popup-confirmation-container').fadeIn();
                                    $('#question').text('Are you sure you want set this account as inactive?');
                                    
                                    $('.button-confirm').off('click').on('click', function(e) {
                                        
                                        $.ajax({
                                            url: '../php/account_status_security_code.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                account_id: account_id,
                                                username: username
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.manage-account-popup').fadeOut();
                                                    $('.email-verification-status').fadeIn();
                                                    $('.popup-confirmation-container').fadeOut();
                                                    $('#email-address-status').text(response.email);
                                                    $('.settings-header-title').text('Check email to an account you want to update.');
                                                        
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


                                $('.button-delete').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    const account_id = $(this).data('account-id');
                                    const username = "<?php echo $username; ?>";
                                    // console.log(account_id);

                                    $('.popup-confirmation-container').fadeIn();
                                    $('#question').text('Are you sure you want to delete this account?');
                                    
                                    $('.button-confirm').off('click').on('click', function(e) {
                                        
                                        $.ajax({
                                            url: '../php/account_delete_security_code.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                account_id: account_id,
                                                username: username
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.manage-account-popup').fadeOut();
                                                    $('.email-verification-deletion').fadeIn();
                                                    $('.popup-confirmation-container').fadeOut();
                                                    $('#email-address-deletion').text(response.email);
                                                    $('.settings-header-title').text('Check email to an account you want to update.');
                                                        
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
                                    
                            });

                            $(document).on('click', '.verify-code-status', function(e) {
                                e.preventDefault();

                                const security_code = $('#security-code-status').val();
                                // console.log(security_code);

                                $.ajax({
                                    url: '../php/security_code_verification_account_status.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        security_code: security_code
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.email-verification-status').fadeOut();
                                            $('.settings-popup-overlay').fadeOut();
                                            loadAccounts();
                                            displaySuccessMessage(response.message);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                            });


                            $(document).on('click', '.verify-code-deletion', function(e) {
                                e.preventDefault();

                                const security_code = $('#security-code-deletion').val();
                                // console.log(security_code);

                                $.ajax({
                                    url: '../php/security_code_verification_account_deletion.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        security_code: security_code
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.email-verification-deletion').fadeOut();
                                            $('.delete-account-popup').fadeIn();
                                            loadAccounts();
                                            displaySuccessMessage(response.message);
                                            $('#security-code-deletion').val('');
                                            $('#delete-account-id').val(response.account_id);
                                            $('#email-address-deletion').text(response.email);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                            });


                            $(document).on('click', '.delete-account-button', function (e) {
                                e.preventDefault();

                                const password = $('#delete-account-password').val();
                                const account_id = $('#delete-account-id').val();

                                $.ajax({
                                    url: '../php/delete_account.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        password: password,
                                        account_id: account_id
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            if (response.logout) {
                                                // If logout is required (user deleted their own account)
                                                $('.delete-account-popup').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                $('#delete-account-id').val('');
                                                displaySuccessMessage(response.message);
                                                setTimeout(function () {
                                                    window.location.href = '../public/login_panel.php'; // Redirect after 3 seconds
                                                }, 3000);
                                                
                                            } else {
                                                // Normal deletion behavior for other accounts
                                                $('.delete-account-popup').fadeOut();
                                                $('.settings-popup-overlay').fadeOut();
                                                $('#delete-account-id').val('');
                                                displaySuccessMessage(response.message);
                                            }
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                            });

                            

                            function loadAccounts() {
                                $.ajax({
                                    url: '../php/fetch_accounts.php',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            let tableBody = '';
                                            response.data.forEach((account) => {
                                                // Check account status and set the appropriate button visibility
                                                const isActive = account.account_status === "active";
                                                const activeClass = isActive ? "hidden" : ""; // Show active button if inactive
                                                const inactiveClass = isActive ? "" : "hidden"; // Show inactive button if active

                                                tableBody += `
                                                    <tr>
                                                        <td class="truncate">${account.email}</td>
                                                        <td>${account.account_username}</td>
                                                        <td>${account.account_status}</td>
                                                        <td>${account.date} ${account.time}</td>
                                                        <td class="table-action">
                                                            <i class="fas fa-eye-slash button-active ${activeClass}" data-account-id="${account.account_id}" data-account-username="${account.account_username}"></i>
                                                            <i class="fa-regular fa-eye button-inactive ${inactiveClass}"
                                                                data-account-id="${account.account_id}"></i>
                                                            <i class="fa-regular fa-trash-can button-delete"
                                                                data-account-id="${account.account_id}" data-account-email="${account.email}"></i>
                                                        </td>
                                                    </tr>
                                                `;
                                            });
                                            $('.manage-account-popup tbody').html(tableBody);
                                        } else {
                                            alert(response.error);
                                        }
                                    },
                                    error: function () {
                                        console.error("Failed to fetch account data");
                                    }
                                });
                            }


                            loadAccounts();

                    // -----------------------------------------Update Password--------------------------------  


                            $(document).on('click', '.change-password', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-admin').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-password').fadeIn();
                                    $('.settings-header-title').text('Enter Admin Credential for password reset');
                                    
                                    const user_role = $('.role-admin').data('user-role');

                                    $('.verify-credentials-password').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-password').val();
                                        const username = $('#username-credential-password').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_password.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-password').fadeIn();
                                                    $('.credentials-verification-password').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-password').text(response.email);
                                                    
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
                                    
                            });


                            $(document).on('click', '.change-password', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-service').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-password').fadeIn();
                                    $('.settings-header-title').text('Enter Service Credential for password reset');
                                    
                                    const user_role = $('.role-service').data('user-role');

                                    $('.verify-credentials-password').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-password').val();
                                        const username = $('#username-credential-password').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_password.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-password').fadeIn();
                                                    $('.credentials-verification-password').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-password').text(response.email);
                                                    
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
                                    
                            });


                            $(document).on('click', '.change-password', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-kitchen').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-password').fadeIn();
                                    $('.settings-header-title').text('Enter Kitchen Credential for password reset');
                                    
                                    const user_role = $('.role-kitchen').data('user-role');

                                    $('.verify-credentials-password').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-password').val();
                                        const username = $('#username-credential-password').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_password.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-password').fadeIn();
                                                    $('.credentials-verification-password').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-password').text(response.email);
                                                    
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
                                    
                            });


                            $(document).on('click', '.verify-code-password', function(e) {
                                e.preventDefault();

                                const security_code = $('#security-code-password').val();
                                // console.log(security_code);

                                $.ajax({
                                    url: '../php/security_code_verification_password.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        security_code: security_code
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.change-password-popup').fadeIn();
                                            $('.email-verification-password').fadeOut();
                                            $('#email-credential-password').val('');
                                            $('#username-credential-password').val('');

                                            $('#update-password-id').val(response.account_id);
                                            displaySuccessMessage(response.message);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                            });



                            $(document).on('click', '.update-password-button', function(e) {
                                e.preventDefault();

                                const current_password = $('#current-password').val();
                                const new_password = $('#new-password').val();
                                const retype_password = $('#retype-new-password').val();
                                const account_id = $('#update-password-id').val();

                                // console.log(account_id);


                                if (!current_password || !new_password || !retype_password) {
                                    displayErrorMessage('All fields are required.');
                                    return;
                                }

                                if (!validatePassword(new_password)) {
                                    displayErrorMessage('Password must be at least 8 characters long and include at least one number, and one special character.');
                                    return;
                                }

                                if (new_password != retype_password) {
                                    displayErrorMessage("New password and retype password do not match.");
                                    return;
                                }

                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text('Are you sure you continue?');

                                $('.button-confirm').off('click').on('click', function(e) {

                                    $.ajax({
                                        url: '../php/process_update_password.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            current_password: current_password,
                                            new_password: new_password,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('.change-username-popup').fadeOut();

                                                $('#update-username-id').val('');
                                                displaySuccessMessage(response.message);
                                                $('.popup-confirmation-container').fadeOut();
                                                $('.change-password-popup').fadeOut();
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });

                                function validatePassword(password) {
                                    const minLength = 8;
                                    const hasNumber = /[0-9]/.test(password);
                                    const hasSpecialChar = /[\W_]/.test(password);

                                    return password.length >= minLength && hasNumber && hasSpecialChar;
                                }
                                
                            });


                        // -----------------------------------------Update Username--------------------------------    


                            $(document).on('click', '.change-username', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-admin').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-username').fadeIn();
                                    $('.settings-header-title').text('Enter Admin Credential for username reset');
                                    
                                    const user_role = $('.role-admin').data('user-role');

                                    $('.verify-credentials-username').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-username').val();
                                        const username = $('#username-credential-username').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_username.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-username').fadeIn();
                                                    $('.credentials-verification-username').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-username').text(response.email);
                                                    
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
                                    
                            });


                            $(document).on('click', '.change-username', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-service').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-username').fadeIn();
                                    $('.settings-header-title').text('Enter Service Credential for username reset');
                                    
                                    const user_role = $('.role-service').data('user-role');

                                    $('.verify-credentials-username').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-username').val();
                                        const username = $('#username-credential-username').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_username.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-username').fadeIn();
                                                    $('.credentials-verification-username').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-username').text(response.email);
                                                    
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
                                    
                            });

                            $(document).on('click', '.change-username', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-kitchen').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification-username').fadeIn();
                                    $('.settings-header-title').text('Enter Service Credential for username reset');
                                    
                                    const user_role = $('.role-kitchen').data('user-role');

                                    $('.verify-credentials-username').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential-username').val();
                                        const username = $('#username-credential-username').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification_change_username.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification-username').fadeIn();
                                                    $('.credentials-verification-username').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address-username').text(response.email);
                                                    
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
                                    
                            });


                            $(document).on('click', '.verify-code-username', function(e) {
                                e.preventDefault();

                                const security_code = $('#security-code-username').val();
                                // console.log(security_code);

                                $.ajax({
                                    url: '../php/security_code_verification_username.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        security_code: security_code
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.change-username-popup').fadeIn();
                                            $('.email-verification-username').fadeOut();
                                            $('#email-credential-username').val('');
                                            $('#username-credential-username').val('');

                                            $('#update-username-id').val(response.account_id);
                                            displaySuccessMessage(response.message);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                            });


                            $(document).on('click', '.update-username-button', function(e) {
                                e.preventDefault();

                                const new_username = $('#username-update').val();
                                const curr_password = $('#username-current-password').val();
                                const account_id = $('#update-username-id').val();

                                // console.log(account_id);

                                $('.popup-confirmation-container').fadeIn();
                                $('#question').text('Are you sure you continue?');

                                $('.button-confirm').off('click').on('click', function(e) {

                                    $.ajax({
                                        url: '../php/update_username.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            new_username: new_username,
                                            password: curr_password,
                                            account_id: account_id
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('.change-username-popup').fadeOut();

                                                $('#update-username-id').val('');
                                                displaySuccessMessage(response.message);
                                                $('.popup-confirmation-container').fadeOut();
                                            } else {
                                                displayErrorMessage('Failed to verify: ' + response.error);
                                                $('.popup-confirmation-container').fadeOut();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log('Error: ' + textStatus, errorThrown);
                                        }
                                    });

                                });
                                
                            });



            // -------------------------------------ROLE SERVICE CHANGE EMAIL-------------------------------------

                            $(document).on('click', '.change-email', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-admin').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification').fadeIn();
                                    $('.settings-header-title').text('Enter Admin Credential');
                                    
                                    const user_role = $('.role-admin').data('user-role');

                                    $('.verify-credentials').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential').val();
                                        const username = $('#username-credential').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification').fadeIn();
                                                    $('.credentials-verification').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address').text(response.email);
                                                    
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
                                    
                            });

                            // -------------------------------------ROLE SERVICE CHANGE EMAIL-------------------------------------

                            $(document).on('click', '.change-email', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-service').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification').fadeIn();
                                    $('.settings-header-title').text('Enter Service Credential');
                                    
                                    const user_role = $('.role-service').data('user-role');

                                    $('.verify-credentials').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential').val();
                                        const username = $('#username-credential').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification').fadeIn();
                                                    $('.credentials-verification').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address').text(response.email);
                                                    
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
                                    
                            });


                            // -------------------------------------ROLE Kitchen Change Email-------------------------------------

                            $(document).on('click', '.change-email', function(e) {
                                e.preventDefault();
                                // $('.changing-email-popup').fadeIn();
                                $('.role-verification').fadeIn();
                                $('.settings-popup-overlay').fadeIn();

                                
                                $('.role-kitchen').off('click').on('click', function(e) {
                                    e.preventDefault();

                                    $('.credentials-verification').fadeIn();
                                    $('.settings-header-title').text('Enter Service Credential');
                                    
                                    const user_role = $('.role-kitchen').data('user-role');

                                    $('.verify-credentials').off('click').on('click', function(e) {
                                        e.preventDefault();

                                        const email = $('#email-credential').val();
                                        const username = $('#username-credential').val();
                                        // console.log(user_role);
                                        // console.log(email);
                                        // console.log(username);
                                        displaySuccessMessage('Please wait for response.');

                                        $.ajax({
                                            url: '../php/credentials_verification.php', 
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                email: email,
                                                username: username,
                                                user_role: user_role
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    $('.email-verification').fadeIn();
                                                    $('.credentials-verification').fadeOut();
                                                    $('.settings-header-title').text('Check your email');
                                                    $('#email-address').text(response.email);
                                                    
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
                                    
                            });



                            $(document).on('click', '.verify-code', function(e) {
                                e.preventDefault();

                                const security_code = $('#security-code').val();
                                // console.log(security_code);

                                $.ajax({
                                    url: '../php/security_code_verification.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        security_code: security_code
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.change-email-popup').fadeIn();
                                            $('.email-verification').fadeOut();
                                            $('#email-credential').val('');
                                            $('#username-credential').val('');

                                            $('#update-email-id').val(response.account_id);
                                            displaySuccessMessage(response.message);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                            });

                            $(document).on('click', '.update-email-button', function(e) {
                                e.preventDefault();

                                const new_email = $('#email-update').val();
                                const account_id = $('#update-email-id').val();

                                $.ajax({
                                    url: '../php/update_email.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        new_email: new_email,
                                        account_id: account_id
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('.change-email-popup').fadeOut();

                                            $('#update-email-id').val('');
                                            displaySuccessMessage(response.message);
                                        } else {
                                            displayErrorMessage('Failed to verify: ' + response.error);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('Error: ' + textStatus, errorThrown);
                                    }
                                });
                                
                                
                            });

                            // Handle cancellation (no button)
                            $('.popup-close-button').off('click').on('click', function(e) {
                                e.preventDefault(); // Prevent default link behavior
                                // Hide the popup if "no" is clicked
                                $('.settings-popup-overlay').fadeOut();
                                $('.role-verification').fadeOut();
                                $('.manage-account-popup').fadeOut();
                                $('.delete-account-popup').fadeOut();
                                $('.update-tables-popup').fadeOut();
                                $('.create-account-popup').fadeOut();
                                
                            });

                            $('.popup-close-button-2').off('click').on('click', function(e) {
                                e.preventDefault(); 

                                $('.credentials-verification').fadeOut();
                                $('.credentials-verification-username').fadeOut();
                                $('.credentials-verification-password').fadeOut();
                                $('.change-email-popup').fadeOut();
                                $('.change-username-popup').fadeOut();
                                $('.change-password-popup').fadeOut();
                                $('.delete-account-popup').fadeOut();
                                $('#email-credential').val('');
                                $('#username-credential').val('');
                                $('#email-credential-username').val('');
                                $('#username-credential-username').val('');
                                $('#email-credential-password').val('');
                                $('#username-credential-password').val('');
                                $('#security-code').val('');
                                
                            });

                            $('.button-cancel').off('click').on('click', function(e) {
                                e.preventDefault(); // Prevent default link behavior
                                $('.popup-confirmation-container').fadeOut();
                            });
                        });

                        $(document).on('click', '.manage-tables', function(e) {
                                e.preventDefault();
                                $('.update-tables-popup').fadeIn();
                                $('.settings-popup-overlay').fadeIn();
                        });

                        $(document).ready(function () {
                            // Fetch and Populate Table Numbers
                            function fetchTables() {
                                $.ajax({
                                    url: "../php/get_table_numbers_count.php", // PHP file to fetch table count
                                    method: "GET",
                                    dataType: "json",
                                    success: function (data) {
                                        // Update the input field with the total table count
                                        $('#current-table').val(data.table); 
                                    },
                                    error: function (error) {
                                        console.error("Error fetching table count:", error);
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
                                        // displaySuccessMessage(response);
                                        fetchTables();
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
                                        // displaySuccessMessage(response);
                                        fetchTables();
                                    }
                                });
                            });
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
                        <h1>Email & Security Details</h1>
                        <p>Manage your email, username and password.</p>
                    </div>
                    <div class="settings-main-content">
                        <div class="settings-groups change-email">
                            <h3>Change Email</h3>
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
                        <div class="settings-groups manage-accounts">
                            <h3>manage Account</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups create-accounts">
                            <h3>create Account</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups manage-tables">
                            <h3>manage tables</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-popup-overlay"></div>

              <!-- ----------------------- Change Email Popup ---------------------- -->

            <div class="settings-popup-container update-tables-popup">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="update-tables-title">Manage Table</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group table-number-group">
                            <i class="fa-regular fa-square-minus numberDecrease"></i>
                            <input type="number" id="current-table" disabled>
                            <i class="fa-regular fa-square-plus numberIncrease"></i>
                        </div>
                        <!-- <div class="settings-popup-button">
                            <i class="fa-regular fa-square-minus numberDecrease"></i>
                            <i class="fa-regular fa-square-plus numberIncrease"></i>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- ----------------------- Change Email Popup ---------------------- -->

            <div class="settings-popup-container change-email-popup">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Email</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <input type="hidden" id="update-email-id">
                        <div class="settings-popup-form-group">
                            <label>New email</label>
                            <input type="email" id="email-update">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="update-email-button">change email</button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ----------------------- Change username Popup ---------------------- -->

            <div class="settings-popup-container change-username-popup">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Username</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <input type="hidden" id="update-username-id">
                        <div class="settings-popup-form-group">
                            <label>New username</label>
                            <input type="text" id="username-update">
                        </div>
                        <div class="settings-popup-form-group">
                            <label>current password</label>
                            <input type="text" id="username-current-password">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="update-username-button">change username</button>
                        </div>
                    </div>
                </div>
            </div>

   <!-- ----------------------- Change password popup ---------------------- -->

            <div class="settings-popup-container change-password-popup">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Change Password</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <input type="hidden" id="update-password-id">
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
                            <button type="button" class="update-password-button">Change Password</button>
                        </div>
                    </div>

                </div>
            </div>

    <!-- ----------------------- Delete account validation ---------------------- -->

            <div class="settings-popup-container delete-account-popup">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Enter Password </h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <input type="hidden" id="delete-account-id">
                        <div class="settings-popup-form-group">
                            <label for="current_password">Password</label>
                            <input type="password" id="delete-account-password">
                            <i class="fas fa-eye showHidePassword"></i>
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="delete-account-button">Submit</button>
                        </div>
                    </div>

                </div>
            </div>


            <!-- ----------------------- Credentials Verification for updating password ---------------------- -->

            <div class="settings-popup-container credentials-verification-password">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email-credential-password">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="username">username</label>
                            <input type="text" id="username-credential-password">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-credentials-password">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

    <!-- ----------------------- Credentials Verification for updating username ---------------------- -->

            <div class="settings-popup-container credentials-verification-username">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email-credential-username" name="email">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="username">username</label>
                            <input type="text" id="username-credential-username">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-credentials-username">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- ----------------------- Credentials Verification for Updating Email ---------------------- -->

            <div class="settings-popup-container credentials-verification">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button-2"></i>
                        </div>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email-credential" name="email">
                        </div>
                        <div class="settings-popup-form-group">
                            <label for="username">username</label>
                            <input type="text" id="username-credential">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-credentials">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- ----------------------- Email verification for updating email ---------------------- -->

            <div class="settings-popup-container email-verification">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <!-- <i class="fa-regular fa-circle-xmark popup-close-button-2"></i> -->
                        </div>
                        <p>Enter the code we sent to <strong><span id="email-address"></span></strong></p>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Code</label>
                            <input type="number" id="security-code">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-code">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- ----------------------- Email Verification for Update Username ---------------------- -->

            <div class="settings-popup-container email-verification-username">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <!-- <i class="fa-regular fa-circle-xmark popup-close-button-2"></i> -->
                        </div>
                        <p>Enter the code we sent to <strong><span id="email-address-username"></span></strong></p>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Code</label>
                            <input type="number" id="security-code-username">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-code-username">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ----------------------- Email Verification for Update Password ---------------------- -->

            <div class="settings-popup-container email-verification-password">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <!-- <i class="fa-regular fa-circle-xmark popup-close-button-2"></i> -->
                        </div>
                        <p>Enter the code we sent to <strong><span id="email-address-password"></span></strong></p>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Code</label>
                            <input type="number" id="security-code-password">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-code-password">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- ----------------------- Email Verification for Account Status ---------------------- -->

            <div class="settings-popup-container email-verification-status">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <!-- <i class="fa-regular fa-circle-xmark popup-close-button-2"></i> -->
                        </div>
                        <p>Enter the code we sent to <strong><span id="email-address-status"></span></strong></p>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Code</label>
                            <input type="number" id="security-code-status">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-code-status">Verify</button>
                        </div>
                    </div>
                </div>
            </div>


<!-- ----------------------- Email Verification for Account Deletion ---------------------- -->

            <div class="settings-popup-container email-verification-deletion">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1 class="settings-header-title"></h1>
                            <!-- <i class="fa-regular fa-circle-xmark popup-close-button-2"></i> -->
                        </div>
                        <p>Enter the code we sent to <strong><span id="email-address-deletion"></span></strong></p>
                    </div>
                    <div class="settings-popup-form">
                        <div class="settings-popup-form-group">
                            <label for="email">Code</label>
                            <input type="number" id="security-code-deletion">
                        </div>
                        <div class="settings-popup-button">
                            <button type="button" class="verify-code-deletion">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- -----------------------Create Accounts ------------------------>

            <div class="form-container create-account-popup">
                <div class="form-container-header">
                    <h1>Create Account</h1>
                    <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                </div>
                <form action="" method="POST">
                    <div class="form-group">
                        <select name="role" id="createRole">
                            <option value="" hidden>select role</option>
                            <option value="user_admin">admin</option>
                            <option value="user_service">service</option>
                            <option value="user_kitchen">kitchen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" name="email" placeholder="example@gmail.com" id="createEmail">
                    </div>
                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" name="username" id="createUsername">
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" name="password" id="passwordInput">
                        <i class="fas fa-eye" id="showPassword"></i>
                        <i class="fas fa-eye-slash" id="hidePassword"></i>
                    </div>
                    <div class="button-group">
                        <button type="button" class="btnSignup">Sign up</button>
                    </div>
                </form>
            </div>

<!-- -----------------------View Accounts ------------------------>

            <div class="popup-table-container manage-account-popup">
                <h1>Manage account</h1>
                <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                <div class="popup-table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>email</th>
                                <th>username</th>
                                <th>status</th>
                                <th>date & time</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>

<!-- ----------------------- Role Verification ---------------------- -->

            <div class="settings-popup-container role-verification">
                <div class="settings-popup-content">
                    <div class="settings-popup-header">
                        <div class="header-authentication">
                            <h1>Roles</h1>
                            <i class="fa-regular fa-circle-xmark popup-close-button"></i>
                        </div>
                    </div>
                    <div class="settings-main-content">
                        <div class="settings-groups role-admin" data-user-role="user_admin">
                            <h3>User Admin</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups role-service" data-user-role="user_service">
                            <h3>User Service</h3>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="settings-groups role-kitchen" data-user-role="user_kitchen">
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