<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

try {
    $connection = database();
    $query = trim((string) ($_GET['q'] ?? ''));
    $action = (string) ($_GET['action'] ?? '');

    if ($action === 'list') {
        $result = $connection->query('SELECT id, message, sender, created_at FROM quotes ORDER BY created_at DESC LIMIT 50');
        echo json_encode(['quotes' => $result->fetch_all(MYSQLI_ASSOC)], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($query !== '') {
        $statement = $connection->prepare('SELECT id, message, sender, created_at FROM quotes WHERE message LIKE ? OR sender LIKE ? ORDER BY created_at DESC LIMIT 30');
        $like = '%' . $query . '%';
        $statement->bind_param('ss', $like, $like);
        $statement->execute();
        $quotes = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['quotes' => $quotes], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result = $connection->query('SELECT id, message, sender, created_at FROM quotes ORDER BY RAND() LIMIT 1');
    $quote = $result->fetch_assoc();
    $defaults = [
        'Kamu sudah melakukan yang terbaik dengan kemampuanmu hari ini.',
        'Pelan-pelan juga tetap sebuah kemajuan.',
        'Perasaanmu valid, dan kamu berhak beristirahat.'
    ];
    if (!$quote) {
        $quote = ['message' => $defaults[array_rand($defaults)], 'sender' => ''];
    }
    echo json_encode(['quote' => $quote], JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    http_response_code(503);
    echo json_encode(['error' => 'Layanan afirmasi sedang tidak tersedia.'], JSON_UNESCAPED_UNICODE);
}
