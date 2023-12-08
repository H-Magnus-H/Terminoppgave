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
        session_start(); 

        // Database tilkoblingsparametere
        $servername = "localhost";
        $username = "root";
        $password = "IMKuben1337";
        $database = "test"; 
        $tableName = "users"; 

        // Sjekk om brukeren er logget inn 
        if(isset($_SESSION['username'])) {
            $loggedInUsername = $_SESSION['username']; // Hent brukernavnet til den innloggede brukeren fra sesjonen

            // Opprett en tilkobling til databasen
            $conn = new mysqli($servername, $username, $password, $database);

            // Sjekk tilkoblingen
            if ($conn->connect_error) {
                die("Tilkobling mislyktes: " . $conn->connect_error);
            }

            // Spørring for å velge poengsummen for den innloggede brukeren
            $sql = "SELECT score FROM $tableName WHERE username = '$loggedInUsername'";

            // Utfør spørringen
            $result = $conn->query($sql);

            // Sjekk om spørringen var vellykket
            if ($result->num_rows > 0) {
                // Hent data fra første rad 
                $row = $result->fetch_assoc();
                // Vis poengsummen
                echo "Highscore for $loggedInUsername: " . $row["score"];
            } else {
                echo "Ingen resultater funnet for brukernavn: $loggedInUsername";
            }

            // Lukk tilkoblingen
            $conn->close();
        } else {
            // Videresend til innloggingssiden hvis brukeren ikke er logget inn
            header("Location: login.php");
            exit();
        }
    ?>
</body>
<script src="script.js">
</script>
</html>
