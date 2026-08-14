<?php
declare(strict_types=1);

/** Mengembalikan koneksi MySQL Laragon dan menyiapkan tabel pesan. */
function database(): mysqli
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $user = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    $databaseName = getenv('DB_NAME') ?: 'afeksi_harian';

    if (!preg_match('/^[A-Za-z0-9_]+$/', $databaseName)) {
        throw new RuntimeException('Nama database tidak valid.');
    }

    try {
        $connection = new mysqli($host, $user, $password);
        $connection->set_charset('utf8mb4');
        $connection->query("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $connection->select_db($databaseName);
        $connection->query(
            'CREATE TABLE IF NOT EXISTS quotes (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                message TEXT NOT NULL,
                sender VARCHAR(80) NOT NULL DEFAULT \'\',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );
        return $connection;
    } catch (mysqli_sql_exception $exception) {
        throw new RuntimeException('Koneksi database belum tersedia.', 0, $exception);
    }
}
