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

$mittente = $request['mittente'];
$destinatario = $request['destinatario'];
$messaggio = $request['messaggio'];

// Inserisci il nuovo messaggio nel database
$sql = "INSERT INTO messaggi (mittente, destinatario, messaggio) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $mittente, $destinatario, $messaggio);
$stmt->execute();

echo json_encode(array("success" => true));

$conn->close();
?>
