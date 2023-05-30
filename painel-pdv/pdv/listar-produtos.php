<?php

@session_start();
require_once('../../conexao.php');
require_once('../verificar-permissao.php');
$id_usuario = $_SESSION['id_usuario'];

echo '<ul class="order-list">';

$total_venda = 0;
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE venda = 0 order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){	}

		$id_item = $res[$i]['id'];
		$produto = $res[$i]['produto'];
		$unitario = $res[$i]['valor_unitario'];
		$quantidade = $res[$i]['quantidade'];
		$valor_total_item = $res[$i]['valor_total'];
		$valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

		$total_venda += $valor_total_item;
		$total_vendaF =  number_format($total_venda, 2, ',', '.');

		$query_p = $pdo->query("SELECT * FROM produtos WHERE id = '$produto'");
		$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
		$nome_produto = $res_p[0]['nome'];
		$valor_produto = $res_p[0]['venda'];



		echo '<tr><td class="text-center">'.$quantidade.'</td><td class="text-uppercase">'.$nome_produto.'</td><td class="text-center">'.$unitario.'</td><td class="text-center">'.$valor_total_itemF.'</td><td><a href="#" onclick="modalExcluir('.$id_item.')" title="Excluir Item"><i class="fa fa-times"></i></a></td></tr>';



	}
}

?>
