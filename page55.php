<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "crime_game";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $checkSql = $conn->prepare("SELECT * FROM page_savepoint WHERE savepoint_number = ?");
    $checkSql->bind_param("s", $_POST['savepoint_number']);
    $checkSql->execute();
    $result = $checkSql->get_result();

    // Check if data for the specific savepoint number already exists
    if ($result->num_rows > 0) {
        echo "";

        // Add JavaScript script to redirect after displaying the message
        echo '<script>
                setTimeout(function() {
                    window.location.href = "page56.html";
                }, 0);
              </script>';
    } else {
        // Data does not exist, proceed with the insertion
        $insertSql = $conn->prepare("INSERT INTO page_savepoint (picture_name, page_number, page_description, savepoint_number) VALUES (?, ?, ?, ?)");
        $insertSql->bind_param("sssi", $_POST['picture_name'], $_POST['page_number'], $_POST['page_description'], $_POST['savepoint_number']);

        if ($insertSql->execute()) {
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "page56.html";
                    }, 0); // Redirect immediately after saving data
                  </script>';
        } else {
            echo "Error: " . $insertSql->error;
        }

        // Close the connection
        $insertSql->close();
    }

    // Close the connection
    $checkSql->close();
    $conn->close();
}
?>





<!-- page55.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Game - Page 3</title>
    <style>
        body {
            background-image: url('blueebg.png');
            background-color: #111;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        #logo {
            width: 120px;
            height: auto;
        }

        #logout-btn {
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #logout-btn:hover {
            background-color: #45a049;
        }

        #image-container {
            width: 30%;
            height: 300px;
            background-image: url('question.jpg');
            background-size: cover;
            background-position: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #story-box p{
            text-align: justify;
            max-width: 100%;
            margin-bottom: 5px;
            margin-top: auto;
        }
        .btn-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: #000; /* Set text color to black */
            background-color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        #story-box {
            max-width: 60%;
            padding: 20px;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            box-sizing: border-box;
            margin: 0 auto;
        }

        #mute-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 5px;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #mute-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <audio controls autoplay loop style="display: none;" id="bg-music">
        <source src="bgmusic.mp3" type="audio/mp3">
        Your browser does not support the audio tag.
    </audio>

    <div id="header">
        <img id="logo" src="logo.png" alt="Logo">
        <a href="hays.html" id="logout-btn">Exit</a>
    </div>
    <div id="timer" style="color: #fff; font-size: 20px; margin-bottom: 10px;">00:30</div>
    <div id="image-container"></div>
    <div id="story-box">
    <p>What is the output of the following Python code snippet?<br>
            <br>def some_function(x, y=2, z=3):
            <br>return x * y + z<br>
            <br>result1 = some_function(4)
            <br>result2 = some_function(4, z=5)
            <br>result3 = some_function(2, y=3, z=1)<br>
            <br> max_sum = max(max_sum, current_max)<br>
            <br>print(result1, result2, result3)

        </p>
        <div class="btn-container">
            <button class="btn" onclick="selectOption('A')">A) 11 18 9</button>
            <button class="btn" onclick="selectOption('B')">B) 11 13 7</button>
            <button class="btn" onclick="selectOption('C')">C) 14 22 11</button>
            <button class="btn" onclick="selectOption('D')">D) 11 17 9</button>
        </div>
    </div>

    <button id="mute-btn" onclick="toggleMute()">Mute</button>

    <form id="save-form" style="display: none;" method="POST">
    <input type="hidden" id="picture_name" name="picture_name">
    <input type="hidden" id="page_number" name="page_number">
    <input type="hidden" id="page_description" name="page_description">
    <input type="hidden" id="savepoint_number" name="savepoint_number" value="56"> <!-- Set default savepoint_number -->
</form>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var questionTimer;
            var timeLeft = 30; 

            
            function startTimer() {
                questionTimer = setInterval(function () {
                    document.getElementById('timer').innerText = formatTime(timeLeft);
                    if (timeLeft <= 0) {
                        
                        window.history.back();
                    }
                    timeLeft--;
                }, 1000);
            }

            
            function formatTime(seconds) {
                var minutes = Math.floor(seconds / 60);
                var remainingSeconds = seconds % 60;
                return minutes + ":" + (remainingSeconds < 10 ? "0" : "") + remainingSeconds;
            }

            
            function stopTimer() {
                clearInterval(questionTimer);
            }

            startTimer();
        });
        function toggleMute() {
            var audio = document.getElementById('bg-music');
            audio.muted = !audio.muted;
            var muteBtn = document.getElementById('mute-btn');
            muteBtn.innerHTML = audio.muted ? 'Unmute' : 'Mute';
        }

        function selectOption(option) {
        if (option === 'B') {
            // Save data to the database
            saveToDatabase('page56.jpg', 'page56', 'While waiting downstairs, Patricia received an email from Angel.', 56);
            alert('Your answer is correct!');
        } else {
            // You can add logic here for other options
            window.location.href = 'http://localhost/IT%20Elective/page39.html';
            alert('Your answer is incorrect!');
        }
        stopTimer(); 
    }

    function saveToDatabase(pictureName, pageNumber, pageDescription, savepointNumber) {
        // Set values in the hidden form
        document.getElementById('picture_name').value = pictureName;
        document.getElementById('page_number').value = pageNumber;
        document.getElementById('page_description').value = pageDescription;
        document.getElementById('savepoint_number').value = savepointNumber;

        // Submit the form
        document.getElementById('save-form').submit();
    }
    </script>
</body>

</html>



