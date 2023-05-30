<?php

require_once("../../conexao.php");

$id = $_POST['id-cliente'];

$query_con = $pdo->query("SELECT * FROM clientes WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

$query_con = $pdo->query("DELETE FROM clientes WHERE id = '$id'");
echo "Excluido com Sucesso!";

?>