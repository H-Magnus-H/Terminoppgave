<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sjekk pålogging</title>
</head>
<body>
<?php
session_start(); // Starter økten for å få tilgang til sesjonsvariabler

if(isset($_POST['submit'])){
    // Konverterer POST-data til variabler
    $username = $_POST['brukernavn'];
    $password = md5($_POST['passord']);
    
    // Kobler til databasen
    $dbc = mysqli_connect('localhost', 'root', 'IMKuben1337!', 'test')
      or die('Feil ved tilkobling til MySQL-serveren.');
    // Spørring for å hente bruker-ID basert på påloggingsinformasjon
    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $userID = $dbc->query($sql);

    if ($userID->num_rows > 0) {
        // Bruker autentisert
        $row = $userID->fetch_assoc();

        // Lagrer bruker-ID i en sesjonsvariabel
        $_SESSION['user_id'] = $row['id'];
    }
    // Forbereder SQL-strengen
    $query = "SELECT username, password from users where username='$username' and password='$password'";
    
    // Utfører spørringen
    $result = mysqli_query($dbc, $query)
      or die('Feil ved spørring til databasen.');
    
    // Sjekker om spørringen gir resultater
    if($result->num_rows > 0){
        // Gyldig pålogging
        $_SESSION['username'] = $username; // Lagrer brukernavn i sesjonsvariabel
        header('location: birb.php');
    } else {
        // Ugyldig pålogging
        header('location: index.html');
        echo "<script>alert('Feil brukernavn eller passord');</script>";    
        
      }

    // Kobler fra databasen
    mysqli_close($dbc);
}
?>
</body>
</html>
