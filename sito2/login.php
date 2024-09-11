<?php
// Impostazioni di connessione al database
$servername = "localhost";
$username = "root";  // Cambia con il tuo nome utente del database
$password = "2uKmEnQbYQKe";      // Cambia con la tua password del database
$dbname = "my_demi";  // Cambia con il nome del tuo database

// Crea la connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati tramite POST (in formato JSON)
$postData = file_get_contents("php://input");
$request = json_decode($postData, true);

$user = $request['username'];
$pass = $request['password'];

// Prepara la query SQL per cercare l'utente
$sql = "SELECT * FROM utenti WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

// Controlla se la query ha restituito risultati
if ($result->num_rows > 0) {
    // Login riuscito
    echo json_encode(array("success" => true));
} else {
    // Login fallito
    echo json_encode(array("success" => false));
}

// Chiude la connessione
$conn->close();
?>
