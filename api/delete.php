<?php
include '../includes/db_config.php';

// set to method DELETE
header('Access-Control-Allow-Methods: DELETE');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode([
        'message' => 'Method Not Allowed',
    ]);
    exit;
}

// get from json body request post
$data = file_get_contents('php://input');

if (empty($data)) {
    http_response_code(400);
    echo json_encode([
        'message' => 'Bad Request',
    ]);
    exit;
}

$data = json_decode($data, true);
$query = "DELETE FROM movies WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $data['id']);

header('Content-Type: application/json');
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode([
        'code' => 200,
        'data' => null,
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'message' => 'Failed to delete data',
    ]);
}
