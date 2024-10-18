<?php
include '../includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'message' => 'Method Not Allowed',
    ]);
    exit;
}

$data = file_get_contents('php://input');

$data = json_decode($data, true);
$username = $data['username'];
$password = $data['password'];

$query = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    header('Content-Type: application/json');
    if (password_verify($password, $result['password'])) {
        http_response_code(200);
        echo json_encode([
            'message' => 'Login successful',
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            'message' => 'Unauthorized',
        ]);
    }
} else {
    http_response_code(401);
    echo json_encode([
        'message' => 'Unauthorized',
    ]);
}
