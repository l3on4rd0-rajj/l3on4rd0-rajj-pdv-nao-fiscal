<?php 

require_once("../../conexao.php");

$id = $_POST['id_busca'];
$quantidade = $_POST['quantidade_busca'];

$query_con = $pdo->query("SELECT * FROM produtos WHERE id = '$id'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);

// SE O PRODUTO CONFERIDO JÁ É CADASTRADO...
if(@count($res) > 0){

    $nome = $res[0]['nome'];
	$custo = $res[0]['custo'];

	$query_con2 = $pdo->query("SELECT * FROM itens_entrada WHERE id_produto = '$id'");
	$res2 = $query_con2->fetchAll(PDO::FETCH_ASSOC);

	// SE O PRODUTO JÁ FOI CONFERIDO UMA VEZ...
	if(@count($res2) > 0){

		$nova_quantidade = $res2[0]['qntd_conferida'] + $quantidade;

		$res2 = $pdo->prepare("UPDATE itens_entrada SET qntd_conferida = :quantidade WHERE id_produto = '$id'");
		$res2->bindValue(":quantidade", $nova_quantidade);
		$res2->execute();

	} else{
		//INSERIR NA TABELA ITENS CHECK IN
		$res = $pdo->prepare("INSERT INTO itens_entrada SET id_produto = :id, nome = :nome, custo = :custo, qntd_conferida = :quantidade");
		$res->bindValue(":id", $id);
		$res->bindValue(":nome", $nome);
		$res->bindValue(":custo", $custo);
		$res->bindValue(":quantidade", $quantidade);
		$res->execute();
	}

	echo "Check";

} else {

	echo "Produto não cadastrado!";

}

?>