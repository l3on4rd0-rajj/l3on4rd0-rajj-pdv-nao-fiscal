<?php 

@session_start();
require_once('../../conexao.php');
require_once('../verificar-permissao.php');

$codigo = $_POST['codigo'];


// SELECIONAR O PRODUTO DIGITADO
$query_con = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){

	$id = $res[0]['id'];

	echo $id;

	// if($estoque < $quantidade){
	// 	echo 'Quantidade de produtos não disponivel em estoque!';
	// 	exit();
	// }

	// // SE O PRODUTO JÁ FOI CONFERIDO UMA VEZ...
	// $query_con2 = $pdo->query("SELECT * FROM itens_venda WHERE produto = '$id'");
	// $res2 = $query_con2->fetchAll(PDO::FETCH_ASSOC);
	// if(@count($res2) > 0){

	// 	$nova_quantidade = $res2[0]['quantidade'] + $quantidade;
	// 	$valor_total = $valor * $nova_quantidade;
	// 	$valor_totalF =  number_format($valor_total, 2, ',', '.');

	// 	$res2 = $pdo->prepare("UPDATE itens_venda SET quantidade = :quantidade, valor_total = :valor_total WHERE produto = '$id'");
	// 	$res2->bindValue(":quantidade", $nova_quantidade);
	// 	$res2->bindValue(":valor_total", $valor_total);
	// 	$res2->execute();
	// } else {

	// 	$valor_total = $valor * $quantidade;
	// 	$valor_totalF =  number_format($valor_total, 2, ',', '.');

	// 	//INSERIR NA TABELA ITENS VENDAS
	// 	$res = $pdo->prepare("INSERT INTO itens_venda SET produto = :produto, valor_unitario = :valor, usuario = :usuario, venda = '0', quantidade = :quantidade, valor_total = :valor_total");
	// 	$res->bindValue(":produto", $id);
	// 	$res->bindValue(":valor", $valor);
	// 	$res->bindValue(":usuario", $id_usuario);
	// 	$res->bindValue(":quantidade", $quantidade);
	// 	$res->bindValue(":valor_total", $valor_total);

	// 	$res->execute();

	// }


	// //ABATER OS PRODUTOS DO ESTOQUE
	// $novo_estoque = $estoque - $quantidade;
	// $res = $pdo->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = '$id'");
	// $res->bindValue(":quantidade", $novo_estoque);
	// $res->execute();



} else {
	echo 'Produto não cadastrado!';
}

?>
