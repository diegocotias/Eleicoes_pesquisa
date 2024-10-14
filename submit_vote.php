<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capturar os dados do formulário
$city = $_POST['city'];
$neighborhood = $_POST['neighborhood'];
$gender = $_POST['gender'];
$mayor = $_POST['mayor'];
$councilor = $_POST['councilor'];

// Verificar se prefeito é NS/NR ou Branco/Nulo
if ($mayor == 'nsnr') {
    $mayor = 'NS/NR';
} elseif ($mayor == 'branco_nulo') {
    $mayor = 'Branco/Nulo';
}

// Verificar se vereador é NS/NR ou Branco/Nulo
if ($councilor == 'nsnr') {
    $councilor = 'NS/NR';
} elseif ($councilor == 'branco_nulo') {
    $councilor = 'Branco/Nulo';
}

// Inserir os dados no banco de dados
$stmt = $conn->prepare("INSERT INTO votes (city, neighborhood, gender, mayor, councilor) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $city, $neighborhood, $gender, $mayor, $councilor);

if ($stmt->execute()) {
    echo "Voto registrado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
