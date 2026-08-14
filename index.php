<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Afirmasi harian">
    <title>Afeksi Harian</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <main class="container">
        <section class="note" aria-live="polite">
            <a class="search-icon" href="pages/search.php" aria-label="Cari pesan afeksi" title="Cari pesan afeksi">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
            </a>
            <a class="write-icon" href="pages/write.php" aria-label="Tulis kalimat untuk orang lain" title="Tulis kalimat untuk orang lain">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            </a>
            <p class="greeting">For You Today</p>
            <p class="affirmation">Kamu sudah melakukan yang terbaik dengan kemampuanmu hari ini.</p>
            <p class="quote-source"></p>
            <button class="new-note" type="button">Lainnya</button>
        </section>
    </main>
    <script src="js/quotes.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
