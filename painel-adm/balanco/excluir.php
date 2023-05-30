<?php

require_once("../../conexao.php");

$id = $_POST['id'];

$query_con = $pdo->query("DELETE FROM itens_balanco WHERE id = '$id'");
echo "Excluido com Sucesso!";

?>