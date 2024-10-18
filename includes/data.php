<?php

include 'db_config.php';

// query untuk mengambil data user
$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// mengembalikan data dalam bentuk json
header('Content-Type: application/json');

// mengembalikan data dalam bentuk json
echo json_encode($result);
