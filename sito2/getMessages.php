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

// Ottieni i parametri dalla query string
$mittente = $_GET['mittente'];
$destinatario = $_GET['destinatario'];

// Recupera i messaggi tra il mittente e il destinatario
$sql = "SELECT * FROM messaggi WHERE (mittente = ? AND destinatario = ?) OR (mittente = ? AND destinatario = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $mittente, $destinatario, $destinatario, $mittente);
$stmt->execute();
$result = $stmt->get_result();

// Crea un array di messaggi da inviare al frontend
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$conn->close();
?>
