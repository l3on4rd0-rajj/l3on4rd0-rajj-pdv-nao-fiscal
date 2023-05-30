<?php 

require_once("../../conexao.php");

$id = $_POST['id-produto'];
$codigo = $_POST['codigo'];
$nome = $_POST['nome-produto'];
$apresentacao = $_POST['apresentacao'];
$fabricante = $_POST['fabricante'];
$categoria = $_POST['categoria'];

$custo = $_POST['custo'];
$custo = str_replace(',', '.', $custo);

$venda = $_POST['venda'];
$venda = str_replace(',', '.', $venda);

$antigo = $_POST['antigo-produto'];

// EVITAR DUPLICIDADE NO CÓDIGO
if ($antigo != $codigo) {
	
	$query_con = $pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
	$query_con->bindValue(":codigo", $codigo);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "Código de barras já cadastrado!";
		exit();
	}
}

if ($id == "") {

	$res = $pdo->prepare("INSERT INTO produtos SET codigo = :codigo, nome = :nome, apresentacao = :apresentacao, fabricante = :fabricante, categoria = :categoria, custo = :custo, venda = :venda ");
	$res->bindValue(":codigo", $codigo);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":apresentacao", $apresentacao);
	$res->bindValue(":fabricante", $fabricante);
	$res->bindValue(":categoria", $categoria);
	$res->bindValue(":custo", $custo);
	$res->bindValue(":venda", $venda);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE produtos SET codigo = :codigo, nome = :nome, apresentacao = :apresentacao, fabricante = :fabricante, categoria = :categoria, custo = :custo, venda = :venda WHERE id = :id ");
	$res->bindValue(":id", $id);
	$res->bindValue(":codigo", $codigo);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":apresentacao", $apresentacao);
	$res->bindValue(":fabricante", $fabricante);
	$res->bindValue(":categoria", $categoria);
	$res->bindValue(":custo", $custo);
	$res->bindValue(":venda", $venda);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>