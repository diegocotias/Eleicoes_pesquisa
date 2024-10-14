<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buscar dados de votos para prefeitos
$prefeito_query = "
    SELECT c.name, COUNT(v.id) as votos 
    FROM candidates c 
    JOIN votes v ON c.id = v.candidate_id 
    WHERE c.position = 'prefeito'
    GROUP BY c.name";

$prefeito_result = $conn->query($prefeito_query);
$prefeitos = [];
while ($row = $prefeito_result->fetch_assoc()) {
    $prefeitos[] = ['name' => $row['name'], 'votos' => $row['votos']];
}

// Buscar dados de votos para vereadores
$vereador_query = "
    SELECT c.name, COUNT(v.id) as votos 
    FROM candidates c 
    JOIN votes v ON c.id = v.candidate_id 
    WHERE c.position = 'vereador'
    GROUP BY c.name";

$vereador_result = $conn->query($vereador_query);
$vereadores = [];
while ($row = $vereador_result->fetch_assoc()) {
    $vereadores[] = ['name' => $row['name'], 'votos' => $row['votos']];
}

// Retornar os dados como JSON
echo json_encode([
    'prefeitos' => $prefeitos,
    'vereadores' => $vereadores
]);

$conn->close();
?>
