# UniBook

**UniBook** è la *Rubrica di Ateneo* e permette la navigazione tra i dati del personale e del patrimonio edilizio di un Università o di un Ente in genere.

## Pre-requisiti
UniBook è una webapp e necessita di un webserver funzionante, PHP ed un database (il codice sorgente è scritto per Microsoft SQL Server ma con piccolissime correzioni è possibile usare qualsiasi database in quanto il codice usato è SQL standard al 99%).
Supponiamo che il webserver sia Apache e sia già istallato e configurato assieme a PHP e al database.

## Istallazione

Copiare i sorgenti in una cartella del server (PATH-UNIBOOK). 
Abilitare, se già non fosse abilitato, il modulo di Apache mod_rewrite.
Creare in Apache un Virtualhost che punti alla cartella PATH-UNIBOOK/www (www è la cartella che contiene le pagine pubbliche della webapp).
Infine, sempre nel Virtualhost appena creato, inserire la seguente direttiva:

    <Directory PATH-UNIBOOK/www>
        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule . index.php [L]
    </Directory>
    
Sul database, lanciare lo script che crea le tabelle (src/dbscript.sql).

## Configurazione
Rinominare il file src/customs-dist.inc.php in src/customs.inc.php.
In questo file sono presenti le costanti che la webapp utilizzerà.

- APPNAME: nome dell'applicazione. (UniBook)
- BASE_DIR: path della cartella dei sorgenti. Coincide con PATH-UNIBOOK.
- APP_BASE_URL: è il path relativo tra il dominio e la root (/) della app. Se l'URL della app fosse per esempio: https://unibook.DOMINIO/ questo valore deve essere vuoto. Se invece l'URL fosse https://DOMIONIO/altropath/unibook/ allora questo parametro va impostato a "altropath/unibook".

- DB_TYPE: driver del database. E' un valore tra quelli supportati dalla libreria ADODB che viene utilizzata per accedere ai dati. Maggiori informazioni a riguardo su [ADODB](http://adodb.org) e su [Microsoft PHP driver per SQL Server](https://docs.microsoft.com/it-it/sql/connect/php/microsoft-php-driver-for-sql-server?view=sql-server-2017).
- DB_HOST_SERVER: indirizzo del server database. Il suo formato (IP o nome dell'istanza) dipende dalla configurazione del driver per accedere al database.
- DB_USERNAME: nome dell'utente per accedere al database. Deve essere codificato in base64.
- DB_PASSWORD: password dell'utente per accedere al database. Deve essere codificata in base64.
- DB_NAME: nome del database dove sono state create le tabelle tramite lo script src/dbscript.sql.

## Demo
E' possibile collegarsi all'indirizzo https://unibook.aspide.net per visualizzare una demo dell'applicazione.