<?php

require_once("../../conexao.php");

$id = $_POST['id'];

$query_con = $pdo->query("SELECT * FROM contas_pagar WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

// BUSCAR A IMAGEM PARA EXCLUIR DA PASTA
$imagem = $res_con[0]['arquivo'];
if ( $imagem != "sem-foto.jpg" ) {
	unlink('../../img/contas_pagar/'.$imagem);
}

$query_con = $pdo->query("DELETE FROM contas_pagar WHERE id = '$id'");
echo "Excluido com Sucesso!";

?>