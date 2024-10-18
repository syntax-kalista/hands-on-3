<?php

include '../includes/db_config.php';

// Ambil parameter dari DataTables
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

// Query untuk menghitung total data tanpa filter
$totalQuery = "SELECT COUNT(*) as total FROM movies";
$totalStmt = $pdo->prepare($totalQuery);
$totalStmt->execute();
$totalData = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Query dasar untuk mengambil data user
$query = "SELECT * FROM movies";

// Jika ada pencarian, tambahkan filter pencarian
if (!empty($searchValue)) {
    $query .= " WHERE title LIKE :search OR overview LIKE :search"; // Sesuaikan kolom pencarian
}

// Ambil jumlah data setelah filter pencarian
$filteredStmt = $pdo->prepare($query);
if (!empty($searchValue)) {
    $filteredStmt->bindValue(':search', '%' . $searchValue . '%');
}
$filteredStmt->execute();
$totalFilteredData = $filteredStmt->rowCount();

// Tambahkan pagination ke query
$query .= " LIMIT :start, :length";

// Eksekusi query dengan limit dan offset
$stmt = $pdo->prepare($query);
if (!empty($searchValue)) {
    $stmt->bindValue(':search', '%' . $searchValue . '%');
}
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':length', $length, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    "draw" => intval($draw),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFilteredData),
    "data" => $result
];

// Mengembalikan data dalam bentuk JSON
header('Content-Type: application/json');

echo json_encode($response);
