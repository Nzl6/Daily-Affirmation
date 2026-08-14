<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Afeksi — Afeksi Harian</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body class="subpage">
    <main class="page-shell">
        <a class="back-link" href="../index.php">← Kembali ke afirmasi</a>
        <form class="search-form" id="search-form">
            <input type="text" id="search-query" placeholder="Cari kata atau nama pengirim…" aria-label="Cari pesan">
            <button class="submit-button" type="submit">Cari</button>
        </form>
        <section class="quote-list" id="search-results" aria-live="polite"><p class="empty-state">Memuat pesan afeksi…</p></section>
    </main>
    <script>
        const results = document.querySelector('#search-results');
        const searchForm = document.querySelector('#search-form');
        const searchInput = document.querySelector('#search-query');
        const escapeHtml = text => text.replace(/[&<>'\"]/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[char]));
        function renderQuotes(quotes, emptyMessage) {
            results.innerHTML = quotes.length
                ? quotes.map(item => `<article class="note sent-note"><p class="greeting">${item.sender ? `DARI ${escapeHtml(item.sender).toUpperCase()}` : ''}</p><p class="affirmation">${escapeHtml(item.message)}</p></article>`).join('')
                : `<p class="empty-state">${emptyMessage}</p>`;
        }
        async function loadQuotes(query = '') {
            try {
                results.innerHTML = '<p class="empty-state">Memuat pesan afeksi…</p>';
                const url = query ? `../api/get-quotes.php?q=${encodeURIComponent(query)}` : '../api/get-quotes.php?action=list';
                const response = await fetch(url); const data = await response.json();
                if (!response.ok) throw new Error(data.error);
                renderQuotes(data.quotes, query ? 'Belum ada pesan yang cocok.' : 'Belum ada afeksi yang dikirim.');
            } catch (error) { results.innerHTML = `<p class="empty-state">${escapeHtml(error.message || 'Pesan belum dapat dimuat.')}</p>`; }
        }
        searchForm.addEventListener('submit', event => {
            event.preventDefault();
            loadQuotes(searchInput.value.trim());
        });
        loadQuotes();
    </script>
</body>
</html>
