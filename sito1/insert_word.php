<?php
$servername = "localhost";
$username = "root";
$password = "2uKmEnQbYQKe";
$dbname = "my_demi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_word = $_POST["new_word"];
    $sql = "INSERT INTO parole (parola) VALUES ('$new_word')";

    if ($conn->query($sql) === TRUE) {
        echo "Parola inserita con successo! <a id='back-to-game-link' href='index.html'>Torna al Gioco</a>";
    } else {
        echo "Errore: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>