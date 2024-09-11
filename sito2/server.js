const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

// Configurazione del database
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '2uKmEnQbYQKe',
    database: 'my_demi'
});

db.connect(err => {
    if (err) {
        console.error('Errore di connessione al database:', err);
    } else {
        console.log('Connesso al database!');
    }
});

// Middleware
app.use(bodyParser.json());

// Endpoint per il login
app.post('/login', (req, res) => {
    const { username, password } = req.body;

    if (!username || !password) {
        return res.status(400).json({ success: false, message: 'Nome utente e password sono richiesti.' });
    }

    const query = 'SELECT * FROM utenti WHERE username = ? AND password = ?';
    db.query(query, [username, password], (err, results) => {
        if (err) {
            console.error('Errore nella query:', err);
            return res.status(500).json({ success: false, message: 'Errore nel server.' });
        }

        if (results.length > 0) {
            res.json({ success: true });
        } else {
            res.json({ success: false });
        }
    });
});

// Avvio del server
app.listen(port, () => {
    console.log(`Server avviato sulla porta ${port}`);
});
