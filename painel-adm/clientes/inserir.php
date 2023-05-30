<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("../../conexao.php");

$id = $_POST['id-cliente'];
$nome = $_POST['nome-cliente'];
$doc = $_POST['doc-cliente'];
$telefone = $_POST['telefone-cliente'];
$email = $_POST['email-cliente'];
$endereco = $_POST['endereco-cliente'];

$antigo = $_POST['antigo-cliente'];

// EVITAR DUPLICIDADE NO doc
if ($antigo != $doc) {
	
	$query_con = $pdo->prepare("SELECT * FROM clientes WHERE doc = :doc");
	$query_con->bindValue(":doc", $doc);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "CPF ou CNPJ já cadastrado!";
		exit();
	}
}

if ($id == "") {

	$res = $pdo->prepare("INSERT INTO clientes SET nome = :nome, doc = :doc, telefone = :telefone, email = :email, endereco = :endereco");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":doc", $doc);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE clientes SET nome = :nome, doc = :doc, telefone = :telefone, email = :email, endereco = :endereco WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":doc", $doc);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>