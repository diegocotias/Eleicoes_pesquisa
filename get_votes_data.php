<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Função para contar votos por cargo
function countVotes($conn, $position) {
    $sql = "SELECT candidates.name, COUNT(votes.id) as votes
            FROM votes
            JOIN candidates ON votes.candidate_id = candidates.id
            WHERE candidates.position = '$position'
            GROUP BY candidates.id";
    
    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'name' => $row['name'],
                'votes' => $row['votes']
            ];
        }
    }

    return $data;
}

// Obter votos para prefeitos e vereadores
$mayorVotes = countVotes($conn, 'prefeito');
$councilorVotes = countVotes($conn, 'vereador');

echo json_encode([
    'mayors' => $mayorVotes,
    'councilors' => $councilorVotes
]);

$conn->close();
?>
