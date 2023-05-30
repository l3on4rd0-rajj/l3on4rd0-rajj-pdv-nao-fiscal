<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

@session_start();
require_once("../conexao.php");

$id_venda = $_POST['id'];

$id_usuario = @$_SESSION['id_usuario'];
$nome_usuario = @$_SESSION['nome_usuario'];
$cpf_usuario = @$_SESSION['cpf_usuario'];
$hora_atual = date("H:i");


// SELECIONAR O PRODUTOS DA VENDA
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE venda = '$id_venda'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

  for($i=0; $i < $total_reg; $i++){
    foreach ($res[$i] as $key => $value)
    {     }

    $id_produto[$i] = $res[$i]['produto'];
    $qntd_venda[$i] = $res[$i]['quantidade'];

  }

  for($i = 0; $i < $total_reg; $i++) {
    $idProd = $id_produto[$i];
    $qntdVenda = $qntd_venda[$i];
    $query_con2 = $pdo->query("SELECT * FROM produtos WHERE id = '$idProd'");
    $res2 = $query_con2->fetchAll(PDO::FETCH_ASSOC);

    $estoque = $res2[0]['quantidade'];
    $novo_estoque = $estoque + $qntdVenda;

    //ABATER OS PRODUTOS DO ESTOQUE
    $res = $pdo->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = '$idProd'");
    $res->bindValue(":quantidade", $novo_estoque);
    $res->execute();
  }

  $query_v = $pdo->query("SELECT * FROM vendas WHERE id = '$id_venda'");
  $res_v = $query_v->fetchAll(PDO::FETCH_ASSOC);
  $total_venda = $res_v[0]['valor'];


  $descricao_mov = 'Cancelamento / Venda id: ' . $id_venda;
  $res_mov = $pdo->query("INSERT INTO movimentacoes SET tipo = 'Saída', data = curDate(), usuario = '$id_usuario', descricao = '$descricao_mov', valor = '$total_venda', id_mov = '100'");


  // DEFINIR STATUS = CANCELADA
  $res = $pdo->query("UPDATE vendas SET status = 'Cancelada' WHERE id = '$id_venda'");

  echo "Sucesso!";

} else {
  echo 'Nenhum produto encontrado!';
}

