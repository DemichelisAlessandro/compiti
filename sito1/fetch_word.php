<?php
$servername = "localhost";
$username = "root";
$password = "2uKmEnQbYQKe";
$dbname = "my_demi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT parola FROM parole ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["word" => $row["parola"]]);
} else {
    echo json_encode(["word" => ""]);
}

$conn->close();
?>