<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "election_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$candidateId = $_GET['candidateId'];

$sql = "SELECT name, party, candidate_number, photo FROM candidates WHERE id = '$candidateId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $candidate = $result->fetch_assoc();
    echo json_encode($candidate);
} else {
    echo json_encode([]);
}

$conn->close();
?>
