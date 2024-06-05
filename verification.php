<?php 
    include ('./conn/conn.php');
    session_start();

    if (isset($_SESSION['user_verification_id'])) {
        $userVerificationID = $_SESSION['user_verification_id'];
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with Email Verification</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("image1.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            height: 100vh;
            height: 100vh;
    margin: 0; /* Add this line to remove any default margin */
    padding: 0;
        }

        .verification-form {
            backdrop-filter: blur(100px);
            color: rgb(255, 255, 255);
            padding: 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #F6BCA6;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #F6BCA6;
            border-radius: .25rem;
            border-color: #F7B2AB;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, background-color .5s;
        }

        .form-control:hover {
            border-color: #FFB6C1;
        }

        .form-control:focus {
            border-color: #FFB6C1;
            box-shadow: 0 0 0 0.2rem rgba(255, 182, 193, 0.25);
        }

        .form-control:valid {
            color: #F4B0A3;
        }

        .form-control::placeholder {
            color: #F4B0A3;
        }

        .form-control:focus,
        .form-control:valid {
            background-color: #F8F8F8; /* Light Gray */
        }

        .btn-secondary {
            color: #fff;
            background-color: #D5767C;
            border-color: #D5767C;
        }

        .btn-secondary:hover {
            background-color: #FFB6C1;
            border-color: #FFB6C1;
        }
    </style>
</head>
<body>
    
    <div class="main">

        <!-- Email Verification Area -->

        <div class="verification-container">

            <div class="verification-form" id="loginForm">
                <h2 class="text-center">Email Verification</h2>
                <p class="text-center">Please check your email for verification code.</p>
                <form action="./endpoint/add-user.php" method="POST">
                    <input type="text" name="user_verification_id" value="<?= $userVerificationID ?>" hidden>
                    <input type="text" class="form-control text-center" id="verificationCode" name="verification_code">
                    <button type="submit" class="btn btn-secondary login-btn form-control mt-4" name="verify">Verify</button>
                </form>
            </div>

        </div>

    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        // JavaScript to change background color as characters are typed
        document.getElementById('verificationCode').addEventListener('input', function() {
            var input = this.value;
            if (input.length > 0) {
                this.style.backgroundColor = '#F8F8F8'; // Light Gray
            } else {
                this.style.backgroundColor = '#fff'; // White
            }
        });
    </script>
</body>
</html>
