<?php
// Koble til databasen din
$servername = "localhost";
$username = "root";
$password = "IMKuben1337";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sjekk tilkoblingen
if ($conn->connect_error) {
    die("Tilkobling mislyktes: " . $conn->connect_error);
}

session_start();
if(isset($_SESSION['user_id'])) {
    $loggedInUserId = $_SESSION['user_id'];

    // Hent poengsummen fra AJAX-forespørselen
    $score = $_POST['score'];

    // Oppdater poengsummen i databasen 
    $sql = "UPDATE users SET score = $score WHERE id = $loggedInUserId";

    if ($conn->query($sql) === TRUE) {
        echo "Poengsum oppdatert vellykket";
    } else {
        echo "Feil ved oppdatering av poengsum: " . $conn->error;
    }
} else {
    echo "Brukeren er ikke logget inn";
}

$conn->close();
?>
