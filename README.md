# Karaoke Web App

Questa applicazione fornisce una semplice interfaccia web per gestire una serata karaoke.
Si basa su PHP, MySQL e HTML/JS.

## Setup

1. Creare un database MySQL chiamato `karaoke` e importare il file `schema.sql`:
   ```bash
   mysql -u root -p karaoke < schema.sql
   ```
2. Modificare le credenziali nel file `webapp/includes/config.php` secondo la propria installazione.
3. Copiare la cartella `webapp` su un server Apache con PHP abilitato.
4. Accedere a `login.php` per autenticarsi. L'utente admin deve creare gli altri utenti tramite la sezione **Utenti**.

## Funzionalità principali

- Gestione degli utenti con ruoli `admin`, `gestore`, `cliente`, `giudice`.
- Inserimento di nuove canzoni con link YouTube o ricerca veloce.
- Coda delle richieste riordinabile manualmente tramite pulsanti Su/Giù.
- Votazioni del pubblico per le canzoni eseguite.
- Inserimento dei voti della giuria con diversi criteri (coinvolgimento, divertimento, tonalità, ritmo, tempo).
- Gestione categorie di esibizione.

Il progetto è pensato come base di partenza e può essere esteso a seconda delle esigenze.
