<html>
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>PHP registrering</title>
</head>
<body>
<div class="container">
    <p>Opprett ny bruker:</p>
    <form method="post">
        <label for="brukernavn">Brukernavn:</label>
        <input type="text" name="brukernavn" /><br />
        <label for="passord">Passord:</label>
        <input type="password" name="passord" /><br />

        <input type="submit" value="Lag ny bruker" name="submit" />
    </form>   
    <p>Eller trykk <a href=index.html>her</a> for å logge inn</p>
</div> 
</body>
<?php
    if(isset($_POST['submit'])){
        // Konverterer POST-data til variabler
        $username = $_POST['brukernavn'];
        $password = md5($_POST['passord']);
        
        // Kobler til databasen
        $dbc = mysqli_connect('localhost', 'root', 'IMKuben1337!', 'test')
          or die('Feil ved tilkobling til MySQL-serveren.');
        
        // Forbereder SQL-strengen
        $query = "INSERT INTO users (username, password, score) VALUES ('$username','$password', 0)";
        
        // Utfører spørringen
        $result = mysqli_query($dbc, $query)
          or die('Feil ved spørring til databasen.');
        
        // Kobler fra databasen
        mysqli_close($dbc);

        if($result){
            // Gyldig pålogging
            echo "Takk for at du lagde bruker! Trykk <a href='index.html'>her</a> for å logge inn";
        }else{
            // Ugyldig pålogging
            echo "Noe gikk galt, prøv igjen!";
        }
    }
?>
</html>

