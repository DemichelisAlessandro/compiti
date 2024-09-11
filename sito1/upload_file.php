<?php
$servername = "localhost";
$username = "root";
$password = "2uKmEnQbYQKe";
$dbname = "my_demi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];
    $fileContent = file($file);

    foreach ($fileContent as $line) {
        $word = trim($line);
        $sql = "INSERT INTO parole (parola) VALUES ('$word')";
        $conn->query($sql);
    }

    echo "Parole caricate con successo!<a id='back-to-game-link' href='index.html'>Torna al Gioco</a>";
}

$conn->close();
?>