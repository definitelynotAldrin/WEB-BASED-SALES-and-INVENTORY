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
            <img src="../assets/service.jpg" alt="">
        </div>
        <div class="form-container">
            <h1 class="logo-title">Kan-anan by the sea</h1>
            <form action="../php/service_login.php" method="POST">
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
                    <input type="password" name="password" id="passwordInput">
                    <i class="fas fa-eye" id="showPassword"></i>
                    <i class="fas fa-eye-slash" id="hidePassword"></i>
                </div>
                <div class="form-group">
                    <a href="#" id="forgot-password">forgot password</a>
                </div>
                <div class="button-group">
                    <button type="submit">service login</button>
                </div>
            </form>
        </div>
        <div class="settings-popup-overlay"></div>
        <div class="settings-popup-container security-confirmation">
            <div class="settings-popup-content">
                <div class="settings-popup-header">
                    <h1>Verification</h1>
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
        <script>
                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '#forgot-password', function(e) {
                        e.preventDefault();
                        // Show the custom confirmation popup
                        $('.security-confirmation').fadeIn(); // Show the popup
                        $('.settings-popup-overlay').fadeIn();


                        // Handle confirmation (yes button)
                        $('.verify').off('click').on('click', function(e) {
                            e.preventDefault();

                            const color = $('#favorite-color').val();
                            const pet = $('#favorite-pet').val();
                            const place = $('#expensive-place').val();
                            
                            const account_id = 2;

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
                                        displaySuccessMessage('Password: ' + response.password);
                                        
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

                            // Hide the popup after confirming
                            $('.security-confirmation').fadeOut();
                            $('.settings-popup-overlay').fadeOut();
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
                    }, 3000); // Change the duration as needed
                }
        </script>
    </div>
    <script src="../js/showPass.js"></script>
</body>
</html>