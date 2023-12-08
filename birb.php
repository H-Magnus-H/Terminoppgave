<!DOCTYPE html>
<html lang="en" onclick="jump()">
<head>
    <meta charset="UTF-8">
    <title>Flappy Bird</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="game">
        <div id="block"></div>
        <div id="hole"></div>
        <div id="character"></div>
    </div>
    <div id="score">Score: 0</div>
    <?php
        session_start(); // Start the session to access session variables

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "IMKuben1337!";
        $database = "test"; // Database name, replace it with your actual database name
        $tableName = "users"; // Replace it with your actual table name

        // Check if the user is logged in (replace 'username' with the actual session variable name)
        if(isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username']; // Get the logged-in username from the session

            // Create a connection to the database
            $conn = new mysqli($servername, $username, $password, $database);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to select the score for the logged-in user
            $sql = "SELECT score FROM $tableName WHERE username = '$loggedInUsername'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result->num_rows > 0) {
                // Output data of the first row (assuming username is unique)
                $row = $result->fetch_assoc();
                // Display the score
                echo "Highscore for $loggedInUsername: " . $row["score"];
            } else {
                echo "No results found for username: $loggedInUsername";
            }

        // Close the connection
        $conn->close();
        } else {
        // Redirect to login page if user is not logged in
        header("Location: login.php");
        exit();
        }
    ?>
</body>
<script src="script.js">
</script>
</html>
