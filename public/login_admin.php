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
                <div class="button-group">
                    <button type="submit">admin login</button>
                </div>
            </form>
        </div>
    </div>
<script src="../js/showPass.js"></script>
</body>
</html>