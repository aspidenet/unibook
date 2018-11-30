
CREATE TABLE dbo.BOOK_DDU(
	codice_categoria varchar(50) NULL,
	categoria varchar(150) NULL,
	codice_ddu varchar(50) NOT NULL,
	ddu varchar(1000) NOT NULL
) 
CREATE TABLE dbo.BOOK_Edifici(
	codice_edificio varchar(50) NOT NULL,
	edificio varchar(1000) NOT NULL,
	indirizzo varchar(3054) NULL,
	latitudine numeric(12, 8) NULL,
	longitudine numeric(12, 8) NULL
) 
CREATE TABLE dbo.BOOK_FiltroRicerca(
	matricola varchar(10) NOT NULL,
	filtro varchar(8000) NOT NULL
) 
CREATE TABLE dbo.BOOK_Foto(
	codice_locale varchar(50) NOT NULL,
	foto varchar(50) NOT NULL,
	pubblica char(1) NOT NULL,
	principale char(1) NOT NULL,
	dt datetime NULL
)
CREATE TABLE dbo.BOOK_Funzioni(
	codefunzione nchar(6) NOT NULL,
	decofunzione nvarchar(100) NOT NULL
) 
CREATE TABLE dbo.BOOK_FunzioniPesi(
	codefunzione varchar(6) NOT NULL,
	peso int NULL
) 
CREATE TABLE dbo.BOOK_IncarichiFunzioni(
	Matricola nchar(6) NOT NULL,
	Cognome nvarchar(100) NULL,
	Nome nvarchar(100) NULL,
	CodeFunzione nchar(6) NOT NULL,
	CodeStruttura nchar(6) NOT NULL,
	InizioIncarico datetime2(7) NULL,
	TermineIncarico datetime2(7) NULL
)
CREATE TABLE dbo.BOOK_Localizzazione(
	matricola nchar(6) NOT NULL,
	codice_locale varchar(50) NOT NULL,
	codice_edificio varchar(50) NOT NULL,
	codice_piano varchar(8000) NULL
)
CREATE TABLE dbo.BOOK_Personale(
	matricola varchar(10) NOT NULL,
	cognome nvarchar(100) NOT NULL,
	nome nvarchar(100) NOT NULL,
	sesso nvarchar(1) NULL,
	coderuolo varchar(10) NOT NULL,
	codetiporuolo varchar(10) NOT NULL,
	codestruttura nvarchar(50) NULL,
	codessd nvarchar(12) NULL,
	decossd nvarchar(100) NULL,
	percpt nvarchar(384) NULL,
	codice_settore varchar(50) NULL,
	settore varchar(1000) NULL,
	codice_servizio varchar(50) NULL,
	servizio varchar(1000) NULL,
	codice_area varchar(50) NULL,
	area varchar(1000) NULL,
	codeprofilo nvarchar(11) NULL,
	profilo nvarchar(100) NULL
)
CREATE TABLE dbo.BOOK_PersonaleContatti(
	matricola varchar(10) NOT NULL,
	email varchar(100) NULL,
	telefonofisso varchar(100) NULL,
	telefonointerno varchar(100) NULL,
	telefoni varchar(1000) NULL,
	emails varchar(250) NULL
) 
CREATE TABLE dbo.BOOK_Ruoli(
	coderuolo nvarchar(10) NOT NULL,
	decoruolo nvarchar(100) NOT NULL,
	numero int NULL,
	peso int NULL
)
CREATE TABLE dbo.BOOK_Spazi(
	codice_edificio varchar(50) NOT NULL,
	edificio varchar(1000) NULL,
	codice_piano varchar(50) NULL,
	piano varchar(1000) NULL,
	codice_locale varchar(50) NOT NULL,
	locale varchar(1000) NULL,
	mq_locale numeric(18, 3) NULL,
	capienza int NULL,
	codestruttura varchar(50) NULL,
	struttura varchar(1000) NULL,
	perc_utilizzo numeric(8, 2) NULL,
	codice_categoria varchar(50) NULL,
	categoria varchar(150) NULL,
	codice_ddu varchar(50) NULL,
	ddu varchar(1000) NULL,
	perc_ddu numeric(5, 2) NULL,
	mq numeric(10, 3) NULL
)
CREATE TABLE dbo.BOOK_SSD(
	codessd nvarchar(12) NOT NULL,
	decossd nvarchar(150) NOT NULL
) 
CREATE TABLE dbo.BOOK_Strutture(
	codestruttura varchar(50) NOT NULL,
	decostruttura varchar(1000) NULL,
	sigla varchar(50) NULL,
	tipo_struttura varchar(1000) NULL,
	livello_struttura int NULL,
	codice_area varchar(50) NULL,
	area varchar(1000) NULL,
	codice_servizio varchar(50) NULL,
	servizio varchar(1000) NULL,
	codice_settore varchar(50) NULL,
	settore varchar(1000) NULL,
	codeclasse varchar(50) NULL
) 
CREATE TABLE dbo.BOOK_StruttureCompetenze(
	codestruttura varchar(10) NOT NULL,
	competenze varchar(8000) NULL
)
CREATE TABLE dbo.BOOK_StruttureRecapiti(
	codestruttura varchar(50) NOT NULL,
	codice_tipo_recapito varchar(15) NOT NULL,
	tipo_recapito varchar(50) NULL,
	recapito varchar(150) NULL,
	indirizzo varchar(1051) NULL,
	cap varchar(25) NULL,
	comune varchar(1000) NULL,
	localita varchar(1000) NULL
)
CREATE TABLE dbo.BOOK_StruttureTipi(
	codice_tipo_struttura varchar(50) NOT NULL,
	tipo_struttura varchar(1000) NULL,
	ordine bigint NULL
) 
CREATE TABLE dbo.BOOK_Vars(
	last_update datetime NULL
) 

