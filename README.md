# ThomasMarchiotti.github.io

# App di Registrazione e Accesso

Progetto di registrazione e accesso scritto in PHP e utilizzando SQLite (Usato come server mysql per comodità) come database. L'app consente agli utenti di registrarsi, effettuare l'accesso e accedere a una home page personalizzata.

## Funzionalità

- Registrazione degli utenti con validazione dei campi obbligatori.
- Accesso agli utenti con gestione degli errori di accesso e blocco IP.
- Home page personalizzata dopo l'accesso.
- Sessioni per la gestione dell'accesso.
- Demoni per lo sblocco degli IP bloccati dopo 5 minuti

## Requisiti

- Server web con supporto PHP. (Usare il comando da terminale 'php -S localhost:8000')
- Estensione SQLite abilitata in PHP. (Dovrebbe essere abilitata di default)
- Bootstrap v5.3.0 (incluso via CDN) per l'aspetto del frontend.

## Installazione

1. Clona questo repository o scarica i file.
2. Assicurati di avere un server web con PHP e SQLite abilitati. (Guarda punto sopra, usare quel comando nella cartella dove clonato il progetto)
3. Apri `index.php` nel tuo browser per accedere all'app.

## Configurazione

Puoi configurare l'app modificando il file `server.php`. Ad esempio, puoi personalizzare il percorso del database SQLite o regolare il numero di tentativi di accesso errati consentiti prima del blocco dell'IP. ($tentativiErrati)