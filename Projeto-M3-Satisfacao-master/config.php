<?php 

// humor período de manhã
define('HUMOR_INICIAL_INI', 6);
define('HUMOR_INICIAL_FIM', 12);

// humor período de tarde
define('HUMOR_FINAL_INI', 13);
define('HUMOR_FINAL_FIM', 21);

// Define o fuso horário para o de São Paulo/América
date_default_timezone_set('America/Recife');

// Inicia a sessão, caso não tenha sido iniciado
if (!isset($_SESSION)) {
    session_start();
}

DEFINE('DBMYSQL', 'mysql');
DEFINE('DBSQLITE', 'sqlite');

DEFINE('DATABASE', DBMYSQL);

?>