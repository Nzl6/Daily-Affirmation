const fallbackAffirmations = window.fallbackAffirmations || [];

async function getQuote(query = "") {
    const url = new URL("api/get-quotes.php", window.location.href);
    url.searchParams.set(query ? "q" : "action", query || "random");
    const response = await fetch(url, { headers: { Accept: "application/json" } });
    if (!response.ok) throw new Error("Afirmasi belum dapat dimuat.");
    return response.json();
}

function showRandomFallback() {
    if (!fallbackAffirmations.length) return;
    const quote = fallbackAffirmations[Math.floor(Math.random() * fallbackAffirmations.length)];
    document.querySelector(".affirmation").textContent = quote;
    document.querySelector(".quote-source").textContent = "";
}

async function loadRandomAffirmation() {
    try {
        const data = await getQuote();
        if (!data.quote) throw new Error("Tidak ada afirmasi.");
        document.querySelector(".affirmation").textContent = data.quote.message;
        document.querySelector(".quote-source").textContent = data.quote.sender ? `— ${data.quote.sender}` : "";
    } catch (_) {
        showRandomFallback();
    }
}

const newNoteButton = document.querySelector(".new-note");
if (newNoteButton) {
    newNoteButton.addEventListener("click", loadRandomAffirmation);
    loadRandomAffirmation();
}
