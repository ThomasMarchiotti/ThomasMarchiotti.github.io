import sqlite3
import time


def sblocca_utenti():
    while True:
        try:
            conn = sqlite3.connect('database.sqlite')
            cursor = conn.cursor()

            #utenti bloccati
            cursor.execute("SELECT DISTINCT utente_id FROM Tentativi_Accesso WHERE bloccato = 1")
            utenti_bloccati = cursor.fetchall()

            for utente_id in utenti_bloccati:
                utente_id = utente_id[0]

                # ultimo tentativo di accesso errato
                cursor.execute("SELECT data_ora FROM Tentativi_Accesso WHERE bloccato = 1 AND utente_id = ? ORDER BY data_ora DESC LIMIT 1", (utente_id,))
                ultimo_accesso = cursor.fetchone()

                if ultimo_accesso:
                    data_ora_ultimo_accesso = time.mktime(time.strptime(ultimo_accesso[0], '%Y-%m-%d %H:%M:%S'))

                    #sblocco utente dopo 5 minuti
                    if time.time() - data_ora_ultimo_accesso >= 300:
                        cursor.execute("UPDATE Tentativi_Accesso SET bloccato = 0 WHERE utente_id = ?", (utente_id,))
                        conn.commit()
                        print(f"Utente sbloccato: {utente_id}")

            conn.close()

            time.sleep(60)

        except Exception as e:
            print(f"Errore: {e}")

if __name__ == "__main__":
    sblocca_utenti()
