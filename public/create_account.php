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
        <div class="alert error-message" id="error-container"></div>
        <div class="success success-message" id="success-container"></div>
            <h1 class="logo-title">Create Account</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <select name="role" id="user-role">
                        <option value="" hidden>select role</option>
                        <option value="user_admin">admin</option>
                        <option value="user_service">service</option>
                        <option value="user_kitchen">kitchen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" name="email" placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" value="">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" id="passwordInput" value="">
                    <i class="fas fa-eye" id="showPassword"></i>
                    <i class="fas fa-eye-slash" id="hidePassword"></i>
                </div>
                <div class="button-group">
                    <button type="button" class="btnSignup">Sign up</button>
                </div>
            </form>
        </div>
        <script>
            $(document).ready(function () {
                $('.btnSignup').on('click', function (e) {
                    e.preventDefault();

                    const role = $('#user-role').val();
                    const email = $('input[name="email"]').val().trim();
                    const username = $('input[name="username"]').val().trim();
                    const password = $('input[name="password"]').val().trim();

                    // Clear previous messages
                    $('#error-container').text('').hide();
                    $('#success-container').text('').hide();

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

                    $('.btnConfirm').off('click').on('click', function(e) {
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
                $('#showPassword').on('click', function () {
                    $('#passwordInput').attr('type', 'text');
                    $('#showPassword').hide();
                    $('#hidePassword').show();
                });

                $('#hidePassword').on('click', function () {
                    $('#passwordInput').attr('type', 'password');
                    $('#hidePassword').hide();
                    $('#showPassword').show();
                });

                $('.btnCancel').off('click').on('click', function(e) {
                    e.preventDefault(); // Prevent default link behavior
                    $('.popup-confirmation-container').fadeOut();
                    $('.popup-overlay').fadeOut();
                });
            });


            function displaySuccessMessage(message1) {
                        
                const messageDiv = $('<div class="success-message"></div>').text(message1);
                        
                $('#success-container').html(messageDiv);
                $('#success-container').fadeIn();

                       
                setTimeout(() => {
                            $('#success-container').fadeOut();
                }, 3000); 
            }

            function displayErrorMessage(message2) {
                  
                const messageDiv = $('<div class="error-message"></div>').text(message2);
                        
                    
                $('#error-container').html(messageDiv);
                $('#error-container').fadeIn();

                
                setTimeout(() => {
                    $('#error-container').fadeOut(); // Fade out the message
                }, 3000);
            }
            

        </script>
        <div class="popup-overlay"></div>
        <div class="pop-up-container popup-confirmation-container">
            <div class="pop-up-content popup-confirmation-content">
                <i class="fa-solid fa-question"></i>
                <h1 id="question">Confirmation for creating this account.</h1>
                <div class="pop-up-buttons logout-buttons">
                    <a href="#" class="btn-second btnCancel">cancel</a>
                    <a href="#" class="btn-first btnConfirm">confirm</a>
                </div>
            </div>
        </div>
    </div>
<!-- <script src="../js/alert_disappear.js"></script> -->
</body>
</html>