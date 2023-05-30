<?php 

require_once("../../conexao.php");

$id = $_POST['id'];

//RECUPERAR O PRODUTO DO ITEM DESTA VENDA
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE id = '$id'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$id_prod = $res[0]['produto'];
	$quantidade = $res[0]['quantidade'];

}

//DEVOLVER OS PRODUTOS AO ESTOQUE
$query_con = $pdo->query("SELECT * FROM produtos WHERE id = '$id_prod'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$estoque = $res[0]['quantidade'];

	//DEVOLVER OS PRODUTOS AO ESTOQUE
	$novo_estoque = $estoque + $quantidade;
	$res = $pdo->prepare("UPDATE produtos SET quantidade = :estoque WHERE id = '$id_prod'");
	$res->bindValue(":estoque", $novo_estoque);
	$res->execute();

}

$query_con = $pdo->query("DELETE from itens_venda WHERE id = '$id'");

echo 'Excluído com Sucesso!';

?>