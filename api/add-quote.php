<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Metode tidak diizinkan.']);
    exit;
}

require_once __DIR__ . '/../config/database.php';

$message = trim((string) ($_POST['message'] ?? ''));
$sender = trim((string) ($_POST['sender'] ?? ''));

if (mb_strlen($message) < 3 || mb_strlen($message) > 500 || mb_strlen($sender) > 80) {
    http_response_code(422);
    echo json_encode(['error' => 'Pesan harus berisi 3–500 karakter, dan nama maksimal 80 karakter.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $connection = database();
    $statement = $connection->prepare('INSERT INTO quotes (message, sender) VALUES (?, ?)');
    $statement->bind_param('ss', $message, $sender);
    $statement->execute();
    echo json_encode(['success' => true, 'message' => 'Afeksimu sudah dibagikan. Terima kasih.'], JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    http_response_code(503);
    echo json_encode(['error' => 'Pesan belum dapat disimpan. Pastikan MySQL Laragon sedang berjalan.'], JSON_UNESCAPED_UNICODE);
}
