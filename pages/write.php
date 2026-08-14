<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Afeksi — Afeksi Harian</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body class="subpage">
    <main class="page-shell">
        <a class="back-link" href="../index.php">← Kembali ke afirmasi</a>
        <form class="form-card" id="quote-form">
            <div class="field"><label for="message">Kalimat afeksi</label><textarea id="message" name="message" maxlength="500" required placeholder="Contoh: Kamu tidak sendirian, ya. Aku bangga melihatmu bertahan."></textarea><span class="hint"><span id="character-count">0</span>/500</span></div>
            <div class="field"><label for="sender">Dari siapa? <em>(opsional)</em></label><input id="sender" name="sender" type="text" maxlength="80" placeholder="Seseorang yang peduli"></div>
            <button class="submit-button" type="submit">Bagikan afeksi</button>
            <p class="form-status" id="form-status" role="status"></p>
        </form>
    </main>
    <script>
        const form = document.querySelector('#quote-form');
        const message = document.querySelector('#message');
        const count = document.querySelector('#character-count');
        const status = document.querySelector('#form-status');
        message.addEventListener('input', () => count.textContent = message.value.length);
        form.addEventListener('submit', async event => {
            event.preventDefault(); status.textContent = 'Mengirim…';
            try {
                const response = await fetch('../api/add-quote.php', { method: 'POST', body: new FormData(form) });
                const data = await response.json();
                if (!response.ok) throw new Error(data.error);
                status.textContent = data.message; form.reset(); count.textContent = '0';
            } catch (error) { status.textContent = error.message || 'Terjadi kendala saat mengirim pesan.'; }
        });
    </script>
</body>
</html>
