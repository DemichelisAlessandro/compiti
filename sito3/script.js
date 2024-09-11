// Funzione per ottenere i dati dei comuni
async function getComuni() {
    const response = await fetch('https://axqvoqvbfjpaamphztgd.functions.supabase.co/comuni?format=json&onlyname=true');
    const comuni = await response.json();
    return comuni;
}

// Funzione per ottenere 15 comuni casuali
function getRandomComuni(comuni, num = 15) {
    const shuffled = comuni.sort(() => 0.5 - Math.random());
    return shuffled.slice(0, num);
}

// Funzione per ottenere le coordinate di un comune usando Nominatim
async function getCoordinates(comune) {
    const response = await fetch(`https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(comune)}&country=Italy&format=json&limit=1`);
    const data = await response.json();

    if (data.length > 0) {
        return {
            lat: parseFloat(data[0].lat),
            lon: parseFloat(data[0].lon)
        };
    } else {
        // Se non troviamo coordinate, ritorniamo null
        return null;
    }
}

// Funzione per creare la mappa e visualizzare i comuni
async function createMap() {
    // Centrare la mappa su Roma
    const map = L.map('map').setView([41.9028, 12.4964], 6);

    // Aggiungere il layer di OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ottieni i comuni
    const comuni = await getComuni();

    // Seleziona 15 comuni casuali
    const selectedComuni = getRandomComuni(comuni);

    // Aggiungi i marker per i comuni selezionati
    for (const comune of selectedComuni) {
        // Ottieni le coordinate del comune
        const coords = await getCoordinates(comune);

        if (coords) {
            // URL Wikipedia
            const wikiUrl = `https://it.wikipedia.org/wiki/${comune}`;

            // Crea un marker per il comune
            const marker = L.marker([coords.lat, coords.lon]).addTo(map);

            // Aggiungi un popup al marker
            marker.bindPopup(`<b>${comune}</b><br><a href="${wikiUrl}" target="_blank">Wikipedia</a>`);
        } else {
            console.log(`Coordinate non trovate per il comune: ${comune}`);
        }
    }
}

// Inizializza la mappa quando la pagina è pronta
createMap();