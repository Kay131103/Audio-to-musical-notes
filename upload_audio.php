<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login1.php');
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["audio_file"]) && $_FILES["audio_file"]["error"] == 0) {
        $upload_dir = "uploads/";
        $file_name = basename($_FILES["audio_file"]["name"]);
        $file_path = $upload_dir . uniqid() . "_" . $file_name;

        if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $file_path)) {
            $file_path = str_replace('"', '', $file_path);
            $file_path = str_replace('/', '\\', $file_path);

            $command = "python abc_1.py \"" . $file_path . "\"";
            $output = shell_exec($command);

            if ($output === null) {
                echo "Error executing Python script. Command: $command";
            } else {
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>MeloMaster</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin Slab:wght@600;700&display=swap">
                    <style>
                        /* Your custom styles here */
                        body {
                            font-family: \'Josefin Slab\';
                            margin: 0;
                            padding: 0;
                            background-color: #F4F1EB; /* Light beige background color */
                            background-image: url(\'https://i.pinimg.com/originals/cf/dd/ff/cfddff3e2d2556a6a3cebce1e12c9859.jpg\'); /* Soft-themed background image */
                            background-size: cover;
                            background-position: center;
                        }
                        .audio-player {
                            text-align: center;
                            margin-top: 40px;
                        }
                        .audio-player progress {
                            background-color: rgba(255, 248, 220, 0.8);
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
                            font-family: \'Josefin Slab\'; /* Arial font */
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
                        .welcome-msg {
                            color: #FFF8EC; /* Dark gray text color */
                            font-weight: bold;
                            font-family: \'Josefin Slab\';
                            font-size: 1.5rem; /* Larger font size */
                            margin-bottom: 20px;
                            text-align: center;
                            margin-top: 80px;
                        }
                        .content {
                            max-width: 800px;
                            margin: auto;
                            padding: 20px;
                            background-color: rgba(255, 248, 220, 0.8); /* Cream semi-transparent content background */
                            border-radius: 20px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        .content pre {
                            white-space: pre-wrap;
                            word-wrap: break-word;
                            text-align: left;
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
                            font-family: \'Josefin Slab\'; /* Arial font */
                            color: #5C5766; /* Dark gray text color */
                        }
                        .footer-content {
                            font-size: 0.9rem; /* Adjusted font size */
                        }
                    </style>
                </head>
                <body>
                    
                    <div class="navbar">
                        <a href="index.php">MeloMaster</a>';
                if (isset($_SESSION['username'])) {
                    echo '<a href="index.php?logout=\'1\'" class="logout">Logout</a>';
                }
                echo '</div>';
                if (isset($_SESSION['username'])) {
                    echo '<div class="welcome-msg">Musical Notes</div>
                    <div class="audio-player">
                    <audio controls id="audioPlayer">
                        <source src="' . $file_path . '" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <div id="notesContainer"></div>
                </div>
                        <div class="content">
                            <pre>' . htmlentities($output) . '</pre>
                        </div>';
                }
                echo '<footer>
                        <div class="footer-content">
                            <p>&copy; MeloMaster 2024. All rights are preserved.</p>
                        </div>
                    </footer>
                </body>
                <script>
                    // Function to highlight notes based on timestamp
                    function highlightNotes(timestamp) {
                        // Get all note elements
                        var notes = document.querySelectorAll(\'.note\');
                        // Remove active class from all notes
                        notes.forEach(function(note) {
                            note.classList.remove(\'active\');
                        });
                        // Get the note corresponding to the timestamp
                        var noteElement = document.querySelector(\'[data-timestamp="\'+ timestamp +\'"]\');
                        // Add active class to the note element
                        if (noteElement) {
                            noteElement.classList.add(\'active\');
                        }
                    }
                    // Get audio element
                    var audioPlayer = document.getElementById(\'audioPlayer\');
                    // Listen for time update event
                    audioPlayer.addEventListener(\'timeupdate\', function() {
                        // Call highlightNotes function with current playback time
                        highlightNotes(audioPlayer.currentTime);
                    });
                </script>
                </html>';
            }
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Error uploading audio file.";
    }
} else {
    header("location: index.php");
}
?>
