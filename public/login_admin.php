<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kan-anan by the Sea</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" href="../assets/Sea Sede (200 x 200 px).png" type="image/x-icon">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Platypi:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/39d1af4576.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../libs/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <a href="../public/login_panel.php" class="btnBack">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
        <div class="image-container">
            <img src="../assets/img_bg.jpg" alt="">
        </div>
        <div class="form-container">
            <h1 class="logo-title">Kan-anan by the sea</h1>
            <form action="../php/admin_login.php" method="POST">
                <?php if(isset($_GET['error'])){ ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>
                <div class="alert error-message" id="error-container"></div>
                <div class="success success-message" id="success-container"></div>
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" value="<?php echo (isset($_GET['username']))?$_GET['username']:"" ?>">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" id="passwordInput" value="<?php echo (isset($_GET['[password]']))?$_GET['password']:"" ?>">
                    <i class="fas fa-eye" id="showPassword"></i>
                    <i class="fas fa-eye-slash" id="hidePassword"></i>
                </div>
                <div class="form-group account-form">
                    <a href="#" id="forgot-password">forgot password</a>
                    <a href="../public/create_account.php" id="create-account">create account</a>
                </div>
                <div class="button-group">
                    <button type="submit">admin login</button>
                </div>
            </form>
        </div>
        <div class="settings-popup-overlay"></div>
        <div class="settings-popup-container security-confirmation">
            <div class="settings-popup-content">
                <div class="settings-popup-header">
                    <h1>Verify it using your email.</h1>
                </div>
                <div class="settings-popup-form">
                    <div class="settings-popup-form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="settings-popup-form-group">
                        <label for="username">username</label>
                        <input type="text" id="username">
                    </div>
                    <div class="settings-popup-button">
                        <button type="button" class="verify">send</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '#forgot-password', function(e) {
                        e.preventDefault();
                        // Show the custom confirmation popup
                        $('.security-confirmation').fadeIn(); // Show the popup
                        $('.settings-popup-overlay').fadeIn();


                        // Handle confirmation (yes button)
                        $('.verify').off('click').on('click', function (e) {
                            e.preventDefault();

                            const email = $('#email').val();
                            const username = $('#username').val();
                            const user_role = 'user_admin';

                            $.ajax({
                                url: '../php/email_verification.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    email: email,
                                    user_role: user_role,
                                    username: username
                                },
                                success: function (response) {
                                    if (response.success) {
                                        displaySuccessMessage(response.message); // Use the success message
                                        $('#email').val('');
                                        $('#username').val('');
                                        $('.security-confirmation').fadeOut();
                            $('.settings-popup-overlay').fadeOut();
                                    } else {
                                        displayErrorMessage('Verification failed: ' + response.error);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    displayErrorMessage('Error: ' + textStatus, errorThrown);
                                }
                            });

                            // Hide the popup after confirming
                            // $('.security-confirmation').fadeOut();
                            // $('.settings-popup-overlay').fadeOut();
                        });


                        // Handle cancellation (no button)
                        $('.settings-popup-overlay').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.security-confirmation').fadeOut(); // Show the popup
                            $('.settings-popup-overlay').fadeOut();
                        });
                    });
                });


                function displaySuccessMessage(message1) {
                    // Create a div to hold the success message
                    const messageDiv = $('<div class="success-message"></div>').text(message1);
                        
                    // Append the message to a specific container in your HTML
                    $('#success-container').html(messageDiv);
                    $('#success-container').fadeOut();
                    $('#success-container').fadeIn();

                    // Optionally, remove the message after a few seconds
                    setTimeout(() => {
                        $('#success-container').fadeOut(); // Fade out the message
                    }, 5000); // Change the duration as needed
                }

                function displayErrorMessage(message2) {
                    // Create a div to hold the success message
                    const messageDiv = $('<div class="error-message"></div>').text(message2);
                        
                    // Append the message to a specific container in your HTML
                    $('#error-container').html(messageDiv);
                    $('#error-container').fadeOut();
                    $('#error-container').fadeIn();

                    // Optionally, remove the message after a few seconds
                    setTimeout(() => {
                        $('#error-container').fadeOut(); // Fade out the message
                    }, 5000); // Change the duration as needed
                }
        </script>
    </div>
<script src="../js/showPass.js"></script>
<script src="../js/alert_disappear.js"></script>
</body>
</html>