-- TABELLA UTENTI
CREATE TABLE Utenti (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    cognome TEXT NOT NULL,
    telefono TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    consenso1 BOOLEAN NOT NULL,
    consenso2 BOOLEAN,
    data_iscrizione DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- TABELLA TENTATIVI
CREATE TABLE Tentativi_Accesso (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    utente_id INTEGER NOT NULL,
    indirizzo_ip TEXT NOT NULL,
    data_ora DATETIME DEFAULT CURRENT_TIMESTAMP,
    tentativi INTEGER DEFAULT 0,
    bloccato INTEGER DEFAULT 0,
    FOREIGN KEY (utente_id) REFERENCES Utenti (id)
);