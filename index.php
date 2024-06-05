<?php 

session_start(); 

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login1.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login1.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeloMaster</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Josefin Slab:wght@600;700&display=swap"
    >
    <style>
        /* Your custom styles here */
        body {
            font-family:'Josefin Slab';
            margin: 0;
            padding: 0;
            background-color: #F4F1EB; /* Light beige background color */
            background-image: url('https://i.pinimg.com/originals/cf/dd/ff/cfddff3e2d2556a6a3cebce1e12c9859.jpg'); /* Soft-themed background image */
            background-size: cover;
            background-position: center;
        }

        .navbar {
            background-color: rgba(255, 248, 220, 0.6); /* Cream semi-transparent navbar */
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            z-index: 2;
            backdrop-filter: blur(5px); /* Soft blur effect */
        }

        .navbar a {
            float: left;
            display: block;
            color: #5C5766; /* Dark gray text color */
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-family: 'Josefin Slab'; /* Arial font */
            font-size: 1.2rem; /* Larger font size */
            transition: background-color 0.3s, color 0.3s;
            border-radius: 30px; /* Rounded corners */
        }

        .navbar a:hover {
            background-color: rgba(255, 248, 220, 0.8); /* Cream semi-transparent on hover */
            color: #8F8DA2; /* Soft purple text color on hover */
        }

        .navbar .logout {
            float: right;
            margin-right: 20px; /* Adjusted margin to shift the button to the left */
        }

        .container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            padding: 30px;
            margin-top: 90px;
        }

        .welcome-msg {
            color: #FFF8EC; /* Dark gray text color */
            font-weight: bold;
            font-family: 'Josefin Slab';
            font-size: 1.5rem; /* Larger font size */
            margin-bottom: 20px;
            margin-top:80px
        }

        .paragraph {
            color: #FFF8EC; /* Dark gray text color */
            font-family: 'Josefin Slab';
            font-size: 1rem; /* Font size */
            line-height: 1.6;
            max-width: 300px;
        }

        .content {
            max-width: 200px;
            margin-left: 250px;
            margin-top: 60px;
            padding: 60px;
            background-color: rgba(255, 248, 220, 0.8); /* Cream semi-transparent content background */
            border-radius: 100px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Upload form styles */
        .upload-form {
            margin-top: 20px;
            background-color: rgba(255, 248, 220, 0.8); /* Cream semi-transparent background color */
            padding: 20px;
            border-radius: 20px;
            max-width: 80%; /* Adjusted width */
            text-align: center;
            overflow: auto;
            margin-left: auto;
            margin-right: auto; /* Centered horizontally */
        }

        .upload-form input[type="file"] {
            display: none;
        }

        .upload-form label {
            display: inline-block;
            background-color: #E69A8D; /* Soft orange button background */
            color: #FDFDFD; /* White text color */
            padding: 10px 20px;
            border-radius: 40px;
            cursor: pointer;
            margin-bottom: 10px;
            transition: background-color 0.3s;
            font-family: 'Josefin Slab'; /* Arial font */
        }

        .upload-form label:hover {
            background-color: #CB756B; /* Darker orange on hover */
        }

        .upload-form button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #E69A8D; /* Soft orange button background */
            color: #FDFDFD; /* White text color */
            border: none;
            border-radius: 40px;
            cursor: pointer;
            margin-top: 7px;
            transition: background-color 0.3s;
            font-family: 'Josefin Slab'; /* Arial font */
        }

        .upload-form button:hover {
            background-color: #CB756B; /* Darker orange on hover */
        }

        .file-info {
            margin-top: 10px;
            font-size: 1rem; /* Adjusted font size */
            color: #5C5766; /* Dark gray text color */
            text-align: left; /* Align the text to the left */
            padding-left: 10px; /* Add left padding */
        }

        /* Footer styles */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 248, 220, 0.6); /* Cream semi-transparent background */
            padding: 20px 0;
            text-align: center;
            font-family: 'Josefin Slab'; /* Arial font */
            color: #5C5766; /* Dark gray text color */
         }

        .footer-content {
         font-size: 0.9rem; /* Adjusted font size */
        }

    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">MeloMaster</a>
        <?php if (isset($_SESSION['username'])) : ?>
            <a href="index.php?logout='1'" class="logout">Logout</a>
        <?php endif ?>
    </div>
    <?php if (isset($_SESSION['username'])) : ?>
        <div class="container">
            <div class="left-content">
                <div class="welcome-msg">Welcome, <?php echo $_SESSION['username']; ?></div>
                <div class="paragraph">
                    For amateur musicians and students aspiring for a musical career, MeloMaster is an invaluable website that facilitates the conversion of audio into musical notes, aiding users in better understanding their compositions.
                </div>
            </div>
            <div class="content">
                <form action="upload_audio.php" method="post" class="upload-form" enctype="multipart/form-data">
                    <label for="audio_file">
                        <i class="fas fa-music"></i> Choose Music
                    </label>
                    <input type="file" id="audio_file" name="audio_file" accept="audio/*">
                    <div class="file-info" id="fileInfo"></div> <!-- File info div -->
                    <button type="submit">Upload</button>
                </form>
            </div>
        </div>
    <?php endif ?>

    <script>
        document.getElementById('audio_file').addEventListener('change', function() {
            var fileInput = this;
            var fileInfo = document.getElementById('fileInfo');
            if (fileInput.files.length > 0) {
                var fileSize = fileInput.files[0].size / (1024 * 1024); // Convert bytes to MB
                if (fileSize > 9){
                    alert("Size shouldn't exceed 9Mb");
                    return
                }
                var fileName = fileInput.files[0].name;
                fileInfo.innerHTML = 'Selected File: ' + fileName + ' (' + fileSize.toFixed(2) + ' MB)';
            } else {
                fileInfo.innerHTML = '';
            }
        });
    </script>
      <footer>
        <div class="footer-content">
            <p>&copy; MeloMaster 2024. All rights are preserved.</p>
        </div>
    </footer>
</body>
</html>
