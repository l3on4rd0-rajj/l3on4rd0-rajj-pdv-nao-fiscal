<?php 

@session_start();
require_once("../conexao.php");

$id_usuario = $_SESSION['id_usuario'];


//VERIFICAR SE EXISTEM ITENS DA VENDA PENDENTES
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE usuario = '$id_usuario' and venda = 0 order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 
	echo 'Existe uma venda em andamento, exclua os itens da venda para Fechar o Caixa!';
	exit();
}

$query = $pdo->query("SELECT * from caixa where operador = '$id_usuario' and status = 'Aberto' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){
$valor_abertura = $res[0]['valor_ab'];
$id_abertura = $res[0]['id'];
}

$valor_vendido = 0;
$valor_sang = 0;

// $query = $pdo->query("SELECT * from vendas where operador = '$id_usuario' and abertura = '$id_abertura' ");
// $res = $query->fetchAll(PDO::FETCH_ASSOC);
// $total_reg = @count($res);
// if($total_reg > 0){
// 	for($i=0; $i < $total_reg; $i++){
// 		foreach ($res[$i] as $key => $value){	}

// 			$valor_vendido += $res[$i]['valor'];
// 	}
// }



	// //CALCULAR TOTAL DE SANGRIAS
	// $valor_sang = 0;
	// $query = $pdo->query("SELECT * from sangrias where id_caixa = '$id_abertura' ");
	// $res = $query->fetchAll(PDO::FETCH_ASSOC);
	// $total_reg = @count($res);
	// if($total_reg > 0){
	// 	for($i=0; $i < $total_reg; $i++){
	// 		foreach ($res[$i] as $key => $value){	}

	// 			$valor_sang += $res[$i]['valor'];
	// 	}
	// }


$res = $pdo->prepare("UPDATE caixa SET data_fec = curDate(), hora_fec = curTime(), valor_vendido = :valor_vendido, status = 'Fechado', valor_sangrias = '$valor_sang' WHERE operador = '$id_usuario' and status = 'Aberto'");

$res->bindValue(":valor_vendido", $valor_vendido);

$res->execute();


echo "Fechado com Sucesso!";

?>