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

// Ottieni l'username dell'utente loggato tramite la query string
$loggedUser = $_GET['username'];

// Recupera tutti gli utenti escluso l'utente loggato
$sql = "SELECT username FROM utenti WHERE username != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedUser);
$stmt->execute();
$result = $stmt->get_result();

// Crea un array di utenti da inviare al frontend
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row['username'];
}

echo json_encode($users);

$conn->close();
?>
