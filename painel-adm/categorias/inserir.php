<?php 

require_once("../../conexao.php");

$id = $_POST['id-categoria'];
$nome = $_POST['nome-categoria'];

$antigo = $_POST['antigo-categoria'];

// EVITAR DUPLICIDADE NO NOME
if ($antigo != $nome) {
	
	$query_con = $pdo->prepare("SELECT * FROM categorias WHERE nome = :nome");
	$query_con->bindValue(":nome", $nome);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "Categoria já cadastrada!";
		exit();
	}
}

if ($id == "") {

	$res = $pdo->prepare("INSERT INTO categorias SET nome = :nome");
	$res->bindValue(":nome", $nome);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE categorias SET nome = :nome WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":nome", $nome);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>