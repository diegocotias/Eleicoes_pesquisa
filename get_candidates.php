<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$prefeitos = [];
$vereadores = [];

// Obter candidatos a prefeito
$sql = "SELECT id, name FROM candidates WHERE position = 'prefeito'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prefeitos[] = $row;
    }
}

// Obter candidatos a vereador
$sql = "SELECT id, name FROM candidates WHERE position = 'vereador'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vereadores[] = $row;
    }
}

echo json_encode(['prefeitos' => $prefeitos, 'vereadores' => $vereadores]);

$conn->close();
?>
