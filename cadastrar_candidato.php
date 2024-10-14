<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$party = $_POST['party'];
$candidateNumber = $_POST['candidateNumber'];
$position = $_POST['position'];
$photo = $_FILES['photo'];

// Verificar se todos os campos foram preenchidos
if (!empty($name) && !empty($party) && !empty($candidateNumber) && !empty($position) && !empty($photo)) {

    // Processar o upload da foto
    $photo_dir = "uploads/";
    $photo_name = time() . '_' . basename($photo['name']);
    $photo_path = $photo_dir . $photo_name;

    if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
        // Inserir candidato no banco de dados
        $sql = "INSERT INTO candidates (name, party, candidate_number, position, photo) 
                VALUES ('$name', '$party', '$candidateNumber', '$position', '$photo_name')";

        if ($conn->query($sql) === TRUE) {
            echo "Candidato cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar candidato: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da foto.";
    }
} else {
    echo "Por favor, preencha todos os campos.";
}

$conn->close();
?>
