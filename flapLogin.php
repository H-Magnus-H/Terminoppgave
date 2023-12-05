<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sjekk pålogging</title>
</head>
<body>
<?php
session_start(); // Start the session to access session variables

if(isset($_POST['submit'])){
    //Gjøre om POST-data til variabler
    $username = $_POST['brukernavn'];
    $password = md5($_POST['passord']);
    
    //Koble til databasen
    $dbc = mysqli_connect('localhost', 'root', '', 'test')
      or die('Error connecting to MySQL server.');
    // Query to retrieve user ID based on login credentials
    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $userID = $dbc->query($sql);

    if ($userID->num_rows > 0) {
        // User authenticated
        $row = $userID->fetch_assoc();

        // Store the user ID in a session variable
        $_SESSION['user_id'] = $row['id'];
    }
    //Gjøre klar SQL-strengen
    $query = "SELECT username, password from users where username='$username' and password='$password'";
    
    //Utføre spørringen
    $result = mysqli_query($dbc, $query)
      or die('Error querying database.');
    
    //Sjekke om spørringen gir resultater
    if($result->num_rows > 0){
        //Gyldig login
        $_SESSION['username'] = $username; // Store username in session variable
        header('location: birb.php');
    } else {
        //Ugyldig login
        header('location: index.html');
        echo "<script>alert('Wrong username or password');</script>";    
        
      }

    //Koble fra databasen
    mysqli_close($dbc);
}
?>
</body>
</html>
