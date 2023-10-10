<?php
date_default_timezone_set('UTC');


//ho usato un while true per 'comodità' l'ideale sarebbe inserire a crontab o usare un process management
// MAI USARE WHILE(TRUE)
while (true) {
    $db = new SQLite3('database.sqlite');

    //recupero gli utenti bloccati
    $utenti_bloccati = $db->prepare("SELECT DISTINCT utente_id FROM Tentativi_Accesso WHERE bloccato = 1");
    $result = $utenti_bloccati->execute();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $utenteId = $row['utente_id'];

        //recupero l'tultimo tentativo di accesso 
        $ultimo_tentativo = $db->prepare("SELECT * FROM Tentativi_Accesso WHERE bloccato = 1 AND utente_id = :utenteId ORDER BY data_ora DESC LIMIT 1");
        $ultimo_tentativo->bindValue(':utenteId', $utenteId, SQLITE3_INTEGER);
        $result = $ultimo_tentativo->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        if ($row !== false) {
            $dataOraUltimoAccesso = strtotime($row['data_ora']);

            //controllo se sono passati 5 minuti
            if (time() - $dataOraUltimoAccesso >= 300) {

                //sblocco l'utente
                $stmt = $db->prepare("UPDATE Tentativi_Accesso SET bloccato = 0 WHERE utente_id = :utenteId");
                $stmt->bindValue(':utenteId', $utenteId, SQLITE3_INTEGER);
                $stmt->execute();

                echo "Utente sbloccato: $utenteId\n";
            }
        }
    }

    $db->close();

    sleep(60);
}
