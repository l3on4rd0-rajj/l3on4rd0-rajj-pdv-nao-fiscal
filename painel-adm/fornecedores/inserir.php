<?php 

require_once("../../conexao.php");

$id = $_POST['id-fornecedor'];
$nome = $_POST['nome-fornecedor'];
$cnpj = $_POST['cnpj-fornecedor'];
$telefone = $_POST['telefone-fornecedor'];
$email = $_POST['email-fornecedor'];
$endereco = $_POST['endereco-fornecedor'];

$antigo = $_POST['antigo-fornecedor'];

// EVITAR DUPLICIDADE NO CNPJ
if ($antigo != $cnpj) {
	
	$query_con = $pdo->prepare("SELECT * FROM fornecedores WHERE cnpj = :cnpj");
	$query_con->bindValue(":cnpj", $cnpj);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "CNPJ já cadastrado!";
		exit();
	}
}

if ($id == "") {

	$res = $pdo->prepare("INSERT INTO fornecedores SET nome = :nome, cnpj = :cnpj, telefone = :telefone, email = :email, endereco = :endereco");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cnpj", $cnpj);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE fornecedores SET nome = :nome, cnpj = :cnpj, telefone = :telefone, email = :email, endereco = :endereco WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cnpj", $cnpj);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>