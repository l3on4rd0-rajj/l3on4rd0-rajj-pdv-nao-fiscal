<?php 

@session_start();
require_once("../conexao.php");

$id_usuario = $_SESSION['id_usuario'];

$caixa = $_POST['caixa'];
$valor_ab = $_POST['valor_ab'];
$valor_ab = str_replace(',', '.', $valor_ab);


// VERIFICAR SE O CAIXA ESTÁ ABERTO
$query_con = $pdo->prepare("SELECT * from caixa WHERE caixa = :caixa AND status = 'Aberto' ");
$query_con->bindValue(":caixa", $caixa);
$query_con->execute();
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

if(@count($res_con) > 0){

	echo 'Este caixa já está aberto!';
	exit();
}

$query = $pdo->prepare("INSERT INTO caixa SET data_ab = curDate(), hora_ab = curTime(), valor_ab = :valor_ab, caixa = :caixa, operador = '$id_usuario', status = 'Aberto'");
$query->bindValue(":valor_ab", $valor_ab);
$query->bindValue(":caixa", $caixa);
$query->execute();

echo "Aberto com Sucesso!";

?>