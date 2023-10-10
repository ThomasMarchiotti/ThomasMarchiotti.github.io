<?php
try {
    $db = new SQLite3('database.sqlite');

    if (isset($_POST['action'])) { //controllo l'azione inviata in post
        $action = $_POST['action']; 

        switch ($action) { //in base ad $action faccio diverse azioni nello switchcase
            case 'registrazione':
                if (
                    isset($_POST['nome']) && isset($_POST['cognome']) &&
                    isset($_POST['telefono']) && isset($_POST['password']) &&
                    isset($_POST['consenso1'])
                ) {
                    $nome = $_POST['nome'];
                    $cognome = $_POST['cognome'];
                    $telefono = $_POST['telefono'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $consenso1 = $_POST['consenso1'];
                    $consenso2 = isset($_POST['consenso2']) ? 1 : 0; //ternaria per verificare se è selezionato

                    //query di inserimento utente prepare + bind valori
                    $query_inserimento = $db->prepare("INSERT INTO Utenti (nome, cognome, telefono, password, consenso1, consenso2) VALUES (:nome, :cognome, :telefono, :password, :consenso1, :consenso2)");
                    $query_inserimento->bindValue(':nome', $nome, SQLITE3_TEXT);
                    $query_inserimento->bindValue(':cognome', $cognome, SQLITE3_TEXT);
                    $query_inserimento->bindValue(':telefono', $telefono, SQLITE3_TEXT);
                    $query_inserimento->bindValue(':password', $password, SQLITE3_TEXT);
                    $query_inserimento->bindValue(':consenso1', $consenso1, SQLITE3_INTEGER);
                    $query_inserimento->bindValue(':consenso2', $consenso2, SQLITE3_INTEGER);

                    if ($query_inserimento->execute()) {
                        // Registrazione riuscita
                        echo "Registrazione completata con successo!";
                    } else {
                        echo "Errore durante la registrazione: " . $db->lastErrorMsg();
                    }
                } else {
                    echo "Compila tutti i campi obbligatori.";
                }
                break;

            case 'accesso':
                if (isset($_POST['telefono']) && isset($_POST['password'])) {
                    $telefono = $_POST['telefono'];
                    $password = $_POST['password'];
            
                    //VERIFICO SE L'INDIRIZZO IP DELL'UTENTE è BLOCCATO
                    $indirizzoIp = $_SERVER['REMOTE_ADDR'];
                    $select_indirizzo = $db->prepare("SELECT * FROM Tentativi_Accesso WHERE indirizzo_ip = :indirizzoIp AND bloccato = 1");
                    $select_indirizzo->bindValue(':indirizzoIp', $indirizzoIp, SQLITE3_TEXT);
                    $result = $select_indirizzo->execute();
            
                    if ($result->fetchArray(SQLITE3_ASSOC)) {
                        echo "Il tuo indirizzo IP è stato bloccato a causa di tentativi di accesso errati. Riprova tra 5 minuti.";
                    } else { //recupero i dati dell'utente dal db
                        $dati_utente = $db->prepare("SELECT * FROM Utenti WHERE telefono = :telefono");
                        $dati_utente->bindValue(':telefono', $telefono, SQLITE3_TEXT);
                        $result = $dati_utente->execute();
            
                        if ($row = $result->fetchArray(SQLITE3_ASSOC)) { //verifico se esiste già un record di accesso
                            $record_errato = $db->prepare("SELECT * FROM Tentativi_Accesso WHERE utente_id = :utenteId");
                            $record_errato->bindValue(':utenteId', $row['id'], SQLITE3_INTEGER);
                            $result = $record_errato->execute();
                            $tentativiErrati = 0;
            
                            //controllo nel ciclo le chiavi bloccato, tendenzialmente dovrebbero essere tutte a 1
                            while ($tentativo = $result->fetchArray(SQLITE3_ASSOC)) {
                                if ($tentativo['bloccato'] == 1) {
                                    echo "L'utente è stato bloccato a causa di tentativi di accesso errati. Riprova tra 5 minuti";
                                    exit;
                                }
                                $tentativiErrati = $tentativo['tentativi'];
                            }
            
                            if (password_verify($password, $row['password'])) {
                                //se va tutto a buon fine inizio la sessione e setto le variabili utilizzabili nel frontend
                                session_start();
                                $_SESSION['user_id'] = $row['id'];
                                $_SESSION['user_name'] = $row['nome'];
                                $_SESSION['user_cognome'] = $row['cognome'];
                                $_SESSION['loggedin'] = true;

                                //scrivo log
                                $logMessage = "Accesso riuscito per l'utente con telefono: " . $telefono . " - Indirizzo IP: " . $indirizzoIp . " - Data e ora: " . date("Y-m-d H:i:s");
                                file_put_contents("access_log.log", $logMessage . PHP_EOL, FILE_APPEND);
                                // accesso riuscito
                                echo "Accesso riuscito! Benvenuto, " . $_SESSION['nome'] . " " . $_SESSION['cognome'];
            
                                // reindirizzo a index.html
                                echo '<script>window.location.href = "index.php";</script>';
                            } else {  // registro un tentativo di accesso errato nella tabella Tentativi_Accesso

                                $tentativo_accesso = $db->prepare("INSERT INTO Tentativi_Accesso (utente_id, indirizzo_ip, data_ora, tentativi) VALUES (:utenteId, :indirizzoIp, CURRENT_TIMESTAMP, :tentativi)");
                                $tentativo_accesso->bindValue(':utenteId', $row['id'], SQLITE3_INTEGER);
                                $tentativo_accesso->bindValue(':indirizzoIp', $indirizzoIp, SQLITE3_TEXT);
                                $tentativo_accesso->bindValue(':tentativi', $tentativiErrati + 1, SQLITE3_INTEGER);
                                $tentativo_accesso->execute();

                                //scrivo log
                                $logMessage = "Tentativo di accesso errato per l'utente con telefono: " . $telefono . " - Indirizzo IP: " . $indirizzoIp . " - Data e ora: " . date("Y-m-d H:i:s");
                                file_put_contents("access_log.log", $logMessage . PHP_EOL, FILE_APPEND);

            
                                echo "Password errata.";
            
                                if ($tentativiErrati >= 2) { // valore per numero tentativi 2 = 3, 3 = 4 ecc
                                    //bvlocco l'utente
                                    $stmt = $db->prepare("UPDATE Tentativi_Accesso SET bloccato = 1 WHERE utente_id = :utenteId");
                                    $stmt->bindValue(':utenteId', $row['id'], SQLITE3_INTEGER);
                                    $stmt->execute();
            
                                    $logMessage = "Bloccato utente con numero di telefono: " . $telefono . " - Indirizzo IP: " . $indirizzoIp . " - Data e ora: " . date("Y-m-d H:i:s");
                                    file_put_contents("access_log.log", $logMessage . PHP_EOL, FILE_APPEND);
                                    echo "L'utente è stato bloccato a causa di tentativi di accesso errati. Tra 5 minuti potrai riprovare a fare la login.";
                                }
                            }
                        } else {
                            echo "Utente non trovato.";
                        }
                    }
                } else {
                    echo "Compila tutti i campi obbligatori.";
                }
                break;
                
                
            default:
                echo "Azione sconosciuta: " . $action;
                break;
        }
    } else {
        echo "Nessuna azione specificata nella richiesta POST.";
    }

    $db->close(); //chiudo connessione
} catch (Exception $e) {
    die("Errore durante la connessione al database: " . $e->getMessage());
}
?>
