<?php

require_once("../../conexao.php");

$id = $_POST['id'];

$query_con = $pdo->query("SELECT * FROM usuarios WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

// BUSCAR A IMAGEM PARA EXCLUIR DA PASTA
$imagem = $res_con[0]['foto'];
if ( $imagem != "sem-foto.jpg" ) {
	unlink('../../img/usuarios/'.$imagem);
}

$query_con = $pdo->query("DELETE FROM usuarios WHERE id = '$id'");
echo "Excluido com Sucesso!";

?>