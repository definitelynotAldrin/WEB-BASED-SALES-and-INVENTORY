<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Code via Email</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Simple form with email input and send button -->
    <input type="email" id="email" placeholder="Enter your email" required>
    <button id="sendCodeBtn">Send Code</button>

    <script>
        $(document).ready(function() {
            $('#sendCodeBtn').click(function(e) {
                e.preventDefault();

                // Get the email value
                const email = $('#email').val();

                if (email) {
                    $.ajax({
                        url: '../tests/send_code.php', // Path to your PHP script
                        type: 'POST',
                        data: {
                            email: email,
                            code: generateRandomCode() // Generate a random code
                        },
                        success: function(response) {
                            alert(response); // Display success message
                        },
                        error: function() {
                            alert("There was an error sending the email.");
                            
                        }
                    });
                } else {
                    alert("Please enter a valid email address.");
                }
            });

            // Generate a 6-digit random code
            function generateRandomCode() {
                return Math.floor(100000 + Math.random() * 900000);
            }
        });
    </script>
</body>
</html>
