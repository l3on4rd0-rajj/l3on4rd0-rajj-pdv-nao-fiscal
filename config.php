<?php 

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// VARIÁVEIS PARA CONEXÃO COM O BANCO DE DADOS LOCAL
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'omni';

// CONFIGURAÇÕES DO SISTEMA
define('SISTEMA', 'ERP');
define('ROOT_URL', 'http://localhost/sistema/');
$relatorio_pdf = 'SIM';
$cabecalho_img_rel = 'SIM';
$rodape_relatorios = " Sistema de Gestão e PDV - Desenvolvido por rajjesh.";
$desconto_porcentagem = "SIM";

// INFORMAÇÕES DO CLIENTE
define('NOME_EMPRESA', 'rajj erp');
define('CNPJ_EMPRESA', '00.000.000/0001-00');
define('ENDERECO_EMPRESA', 'Rua Principal, 000, Bairro Novo - CACHOEIRINHA - RS');
define('TELEFONE_EMPRESA', '(00) 00000-0000');



?>
