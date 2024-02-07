<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "crime_game";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all savepoint_numbers from the database
$query = "SELECT DISTINCT savepoint_number FROM page_savepoint";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<h1><img id="logo" src="logo.png" alt="Logo"></h1>';
    echo '<div class="savepoints-container">'; // New container for all savepoint containers
    while ($row = $result->fetch_assoc()) {
        $savepointNumber = $row['savepoint_number'];

        // Fetch data for the current savepoint_number
        $query = "SELECT picture_name, page_description, page_number FROM page_savepoint WHERE savepoint_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $savepointNumber);
        $stmt->execute();
        $stmt->bind_result($pictureName, $pageDescription, $pageNumber);
        $stmt->fetch();
        $stmt->close();

        // Display savepoint-container with a button
        echo '
        <div class="savepoint-container">
            <div class="left-container">
                <img src="' . $pictureName . '" alt="Page Image">
            </div>
            <div class="right-container">
                <p>' . $pageDescription . '</p>
                <a href="' . $pageNumber . '.html" class="btn-inside-small">Go</a>
            </div>
        </div>';
    }
    echo '</div>'; // Close the savepoints-container
} else {
    echo "No savepoint yet.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Game</title>
    <style>
         body {
            background-image: url('bggif.gif');
            background-size: cover;
            background-position: center;
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
        }

        /* Adjust the style for the right container */
.right-container {
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative; /* Make the position relative for absolute positioning */

}

/* Additional style for the small "Go" button */
.btn-inside-small {
    position: absolute;
    bottom: 10px;
    right: 10px;
    padding: 5px 10px;
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

.btn-inside-small:hover {
    background-color: #45a049;
}

        h2 {
            font-size: 36px;
            margin-bottom: 20px;
            max-width: 80%;
            color: #fff;
        }

        #logo {
            width: 90px;
            height: 90px;
            margin-top: 60px;
            
        }

        p {
            font-size: 20px;
            /* margin-bottom: 40px; */
            text-align: center;
            max-width: 80%;
            color: #fff;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            flex-direction: column;
            align-items: center;
            position: absolute;
            top: 50px;
        }

        .btn {
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

        .btn:hover {
            background-color: #45a049;
        }

        .savepoints-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Center the savepoint containers */
            max-height: 600px; /* Set a maximum height for the container */
            overflow-y: auto; /* Enable vertical scrolling when needed */
        }

        /* Container to display picture_name and page_description */
        .savepoint-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            text-decoration: none;
            align-items: stretch; /* Make containers equal in size */
            border: 2px solid #4CAF50;
            height: 200px; /* Set a fixed height for both containers */
        }

        /* Left container styles */
        .left-container {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer; /* Add this to make it look clickable */
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Set the size for the photo in the left container */
        .left-container img {
            max-width: 200px; /* Make the image fill the container */
            height: auto;
        }

        /* Right container styles */
        .right-container {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer; /* Add this to make it look clickable */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Button style */
        .btn-inside {
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

        .btn-inside:hover {
            background-color: #45a049;
        }
    </style>
     
</head>
<body>
    <!-- Your existing button container -->
    <div class="btn-container">
        <a href="hays.html" class="btn">Exit</a>
    </div>
    
</body>

</html>
