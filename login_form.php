<?php
// auteur: PatronRD
// Functie om verbinding te maken met de database
function ConnectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de PDO-foutmodus in op exception
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

// Controleren of de gebruiker is ingelogd
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Gebruiker is ingelogd, redirect naar de homepage
    header("Location: login_form.php");
    exit;
} else 
    session_start();
    
    // Controleer of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Controleer de gebruikersnaam en het wachtwoord
        $gebruikersnaam = $_POST["gebruikersnaam"];
        $wachtwoord = $_POST["wachtwoord"];
    
        if ($gebruikersnaam === "rohan" && $wachtwoord === "PatronRD") {
    
            $_SESSION["gebruikersnaam"] = $gebruikersnaam;
            
            // Redirect naar index.php
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    }
?>

<html>
<title>Login pagina</title>
</head>
<body>
    <h1>login here...</h1>
    <form action="login_validate.php" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="login">
    </form>
    <a href="register.php">register</a>
</html>
