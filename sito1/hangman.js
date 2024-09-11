document.addEventListener("DOMContentLoaded", () => {
    const wordElement = document.getElementById("word");
    const keyboardElement = document.getElementById("keyboard");
    let currentWord = "";
    let guessedLetters = [];
    let mistakes = 0;

    // Funzione per creare la tastiera virtuale
    function createKeyboard() {
        const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
        alphabet.forEach(letter => {
            const button = document.createElement("button");
            button.classList.add("key");
            button.textContent = letter;
            button.addEventListener("click", () => handleGuess(letter));
            keyboardElement.appendChild(button);
        });
    }

    // Funzione per gestire l'estrazione della parola dal server
    function fetchWord() {
        fetch("fetch_word.php")
            .then(response => response.json())
            .then(data => {
                currentWord = data.word.toUpperCase();
                guessedLetters = Array(currentWord.length).fill("_");
                updateWordDisplay();
            })
            .catch(error => console.error("Errore nel recupero della parola:", error));
    }

    // Funzione per aggiornare la visualizzazione della parola
    function updateWordDisplay() {
        wordElement.textContent = guessedLetters.join(" ");
    }

    // Funzione per gestire i tentativi
    function handleGuess(letter) {
        const buttons = document.querySelectorAll(".key");
        buttons.forEach(button => {
            if (button.textContent === letter) {
                button.disabled = true;
            }
        });

        if (currentWord.includes(letter)) {
            currentWord.split("").forEach((char, index) => {
                if (char === letter) {
                    guessedLetters[index] = letter;
                }
            });
        } else {
            mistakes++;
        }

        updateWordDisplay();
        checkWinOrLose();
    }

    // Funzione per verificare la vittoria o la sconfitta
    function checkWinOrLose() {
        if (guessedLetters.join("") === currentWord) {
            alert("Hai vinto!");
            resetGame();
        } else if (mistakes >= 6) {
            alert(`Hai perso! La parola era: ${currentWord}`);
            resetGame();
        }
    }

    // Funzione per resettare il gioco
    function resetGame() {
        guessedLetters = [];
        mistakes = 0;
        keyboardElement.innerHTML = "";
        fetchWord();
        createKeyboard();
    }

    // Inizializzazione del gioco
    fetchWord();
    createKeyboard();
});