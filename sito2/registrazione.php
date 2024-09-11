<?php
// Connessione al database
$servername = "localhost";
$username = "root";  // Cambia con il tuo nome utente del database
$password = "2uKmEnQbYQKe";      // Cambia con la tua password del database
$dbname = "my_demi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni i dati inviati tramite POST
$postData = file_get_contents("php://input");
$request = json_decode($postData, true);

$username = $request['username'];
$password = $request['password'];

// Verifica se l'username esiste già nel database
$sql = "SELECT * FROM utenti WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se l'utente esiste già, invia un messaggio di errore
    echo json_encode(array("success" => false, "message" => "Username già in uso."));
} else {
    // Se l'username non esiste, registra il nuovo utente

    // Cripta la password prima di salvarla nel DB
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "Errore durante la registrazione."));
    }
}

$conn->close();
?>
