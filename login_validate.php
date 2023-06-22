<?php
// auteur: RD
function ConnectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de PDO-foutmodus in op uitzondering
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        echo "Verbonden met de database";
        return $conn;
    } 
    catch(PDOException $e) {
        echo "Verbinding mislukt: " . $e->getMessage();
        return null;
    }
}

session_start();

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Maak een databaseverbinding
    $conn = ConnectDb();

    if ($conn) {
        try {
            // Bereid de SQL-query voor om gebruikersgegevens op te halen
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            // Voer de query uit
            $stmt->execute();

            // Controleer of er een gebruiker bestaat met de opgegeven gebruikersnaam en wachtwoord
            if ($stmt->rowCount() > 0) {
                // Authenticatie succesvol
                $_SESSION['username'] = $username;
                echo "Je bent ingelogd met,  
                gebruikersnaam: $username
                wachtwoord: $password";
            } else {
                // Authenticatie mislukt
                echo "Login is mislukt";
            }
        } catch (PDOException $e) {
            echo "Fout tijdens het inloggen: " . $e->getMessage();
        }
    }
}
?>