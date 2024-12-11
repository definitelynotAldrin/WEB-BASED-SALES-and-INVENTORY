<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

include_once "../includes/connection.php";

$mysqli = new mysqli("localhost", "root", "", "campano_db");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$sql = "SELECT * FROM accounts
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    header('Location: ../public/login_panel.php');
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    header('Location: ../public/login_panel.php');
    
}

?>
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
            <h1 class="logo-title">Reset password</h1>
            <form method="POST">
                <?php if(isset($_GET['error'])){ ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>
                <div class="alert error-message" id="error-container"></div>
                <div class="success success-message" id="success-container"></div>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" id="token">
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password">
                    <i class="fas fa-eye hide-password" id="showPassword"></i>
                    <i class="fas fa-eye-slash show-password" id="hidePassword"></i>
                </div>
                <div class="form-group">
                    <label for="password">repeat-password</label>
                    <input type="password" name="repeat_password" id="repeat-password">
                    <i class="fas fa-eye hide-password" id="showPassword"></i>
                    <i class="fas fa-eye-slash show-password" id="hidePassword"></i>
                </div>
                <div class="button-group">
                    <button type="submit" id="button-confirm">confirm reset</button>
                </div>
            </form>
        </div>
        
        <div class="popup-overlay"></div>
        <div class="pop-up-container popup-confirmation-container">
            <div class="pop-up-content popup-confirmation-content">
                <i class="fa-solid fa-question"></i>    
                <h1 id="question"></h1>
                <div class="pop-up-buttons logout-buttons">
                    <a href="#" class="btn-second btnCancel">no</a>
                    <a href="#" class="btn-first btnConfirm">yes</a>
                </div>
            </div>
        </div>

        <script>
                $(document).ready(function() {
                    // When the confirm button is clicked
                    $(document).on('click', '#button-confirm', function(e) {
                        e.preventDefault();
                      
                        $('.popup-confirmation-container').fadeIn(); 
                        $('.popup-overlay').fadeIn();
                        $('#question').text('Confirmation for reset password.');

                        // Handle confirmation (yes button)
                        $('.btnConfirm').off('click').on('click', function (e) {
                            e.preventDefault();

                            const password = $('#password').val();
                            const repeat_password = $('#repeat-password').val();
                            const token = $('#token').val();

                            // console.log(token);

                            $.ajax({
                                url: '../php/process_reset_password.php',
                                type: 'POST',
                                dataType: 'json', // Expect JSON response
                                data: {
                                    password: password,
                                    repeat_password: repeat_password, 
                                    token: token
                                },
                                success: function (response) {
                                    if (response.success) {
                                        displaySuccessMessage(response.message); 
                                        $('#password').val('');
                                        $('#repeat-password').val('');
                                        $('#token').val('');

                                        $('.popup-confirmation-container').fadeOut(); 
                                        $('.popup-overlay').fadeOut();
                                        window.location.href = '../public/settlement_panel.php';
                                    } else {
                                        displayErrorMessage(response.error); 
                                        $('.popup-confirmation-container').fadeOut(); 
                                        $('.popup-overlay').fadeOut();
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    displayErrorMessage('Error: ' + textStatus + ', ' + errorThrown);
                                }
                            });
                        });



                        // Handle cancellation (no button)
                        $('.btnCancel').off('click').on('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            // Hide the popup if "no" is clicked
                            $('.popup-confirmation-container').fadeOut(); 
                            $('.popup-overlay').fadeOut();
                        });
                    });
                });

                $(document).ready(function() {
                    // Toggle password visibility for individual input fields
                    $('.form-group').on('click', '.hide-password, .show-password', function() {
                        const $icon = $(this); // The clicked icon
                        const $input = $icon.closest('.form-group').find('input'); // The corresponding input field

                        if ($icon.hasClass('show-password')) {
                            // Show password
                            $input.attr('type', 'text');
                            $icon.hide(); // Hide the "hide-password" icon
                            $icon.siblings('.hide-password').show(); // Show the "show-password" icon
                        } else {
                            // Hide password
                            $input.attr('type', 'password');
                            $icon.hide(); // Hide the "show-password" icon
                            $icon.siblings('.show-password').show(); // Show the "hide-password" icon
                        }
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
<script src="../js/alert_disappear.js"></script>
</script>
</body>
</html>