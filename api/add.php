<?php
include '../includes/db_config.php';

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
$query = "INSERT INTO movies (title, overview, release_date, popularity, vote_average, vote_count) VALUES (:title, :overview, :release_date, :popularity, :vote_average, :vote_count)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':title', $data['title']);
$stmt->bindParam(':overview', $data['overview']);
$stmt->bindParam(':release_date', $data['release_date']);
$stmt->bindParam(':popularity', $data['popularity']);
$stmt->bindParam(':vote_average', $data['vote_average']);
$stmt->bindParam(':vote_count', $data['vote_count']);

header('Content-Type: application/json');
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode([
        'code' => 200,
        'data' => [
            'id' => $pdo->lastInsertId(),
            'title' => $data['title'],
            'overview' => $data['overview'],
            'release_date' => $data['release_date'],
            'popularity' => $data['popularity'],
            'vote_average' => $data['vote_average'],
            'vote_count' => $data['vote_count'],
        ],
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'message' => 'Failed to add data',
    ]);
}
