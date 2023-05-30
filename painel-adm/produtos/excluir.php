<?php

require_once("../../conexao.php");

$id = $_POST['id-produto'];

$query_con = $pdo->query("SELECT * FROM produtos WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

$query_con = $pdo->query("DELETE FROM produtos WHERE id = '$id'");
echo "Excluido com Sucesso!";

?>