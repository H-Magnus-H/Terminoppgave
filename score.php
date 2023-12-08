<?php
// Connect to your database (replace these values with your database credentials)
$servername = "localhost";
$username = "root";
$password = "IMKuben1337!";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session variable storing the user ID after login
session_start();
if(isset($_SESSION['user_id'])) {
    $loggedInUserId = $_SESSION['user_id'];

    // Get the score from the AJAX request
    $score = $_POST['score'];

    // Update the score in the database (replace 'users', 'score', 'id' with your actual table and column names)
    $sql = "UPDATE users SET score = $score WHERE id = $loggedInUserId";

    if ($conn->query($sql) === TRUE) {
        echo "Score updated successfully";
    } else {
        echo "Error updating score: " . $conn->error;
    }
} else {
    echo "User not logged in";
}

$conn->close();
?>
