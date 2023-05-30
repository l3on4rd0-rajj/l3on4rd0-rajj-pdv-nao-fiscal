<?php 

// Carregas as variáveis de configuração.
require_once('config.php');

date_default_timezone_set('America/Sao_Paulo');	

// Faz a conexão com o banco de dados
// Utiliza as vaiáveis presentes no arquivo config.php
try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
	echo '<h3>Ocorreu algum erro ao tentar conectar com o banco de dados.</h3>';
}

?>