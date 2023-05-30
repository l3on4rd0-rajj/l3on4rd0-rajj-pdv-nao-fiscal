<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

@session_start();
require_once("../conexao.php");

$id_usuario = @$_SESSION['id_usuario'];
$nome_usuario = @$_SESSION['nome_usuario'];
$cpf_usuario = @$_SESSION['cpf_usuario'];
$hora_atual = date("H:i");

$id_cliente = $_POST['cliente'];
$forma_pgto = $_POST['forma_pgto'];


//TRAZER OS DADOS DO CLIENTE
$cpf_cliente = @$_SESSION['cpf_usuario'];
$res = $pdo->query("SELECT * from clientes where id = '$id_cliente'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome = @$dados[0]['nome'];
$cpf = @$dados[0]['cpf'];
$endereco = @$dados[0]['endereco'];

//TRAZER DADOS DA VENDA
$total_venda = 0;
$total_vendaF = '0,00';
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE venda = 0 order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $valor_total_item = $res[$i]['valor_total'];
    $valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

    $total_venda += $valor_total_item;
    $total_vendaF =  number_format($total_venda, 2, ',', '.');
  }

  //INSERIR NA TABELA VENDAS
  $res = $pdo->prepare("INSERT INTO vendas SET valor = :total_venda, data = curDate(), hora = '$hora_atual', operador = :id_usuario, forma_pgto = :forma_pgto, cliente = :cliente, status = 'Concluída'");
  $res->bindValue(":total_venda", $total_venda);
  $res->bindValue(":id_usuario", $id_usuario);
  $res->bindValue(":forma_pgto", $forma_pgto);
  $res->bindValue(":cliente", $id_cliente);
  $res->execute();
  $id_venda = $pdo->lastInsertId();

  //RELACIONAR OS ITENS DA VENDA COM A NOVA VENDA
	$query_con = $pdo->query("UPDATE itens_venda SET venda = '$id_venda' WHERE usuario = '$id_usuario' and venda = 0");


  if ($forma_pgto != 5) {
    $descricao_mov = 'Venda de Mercadoria / id: ' . $id_venda;
    $res_mov = $pdo->query("INSERT INTO movimentacoes SET tipo = 'Entrada', data = curDate(), usuario = '$id_usuario', descricao = '$descricao_mov', valor = '$total_venda', id_mov = '100'");
  } else {
    $res_prazo = $pdo->query("INSERT INTO contas_receber SET vencimento = (DATE_ADD(CURDATE(), INTERVAL 30 DAY)), pago = 'Não', data = curDate(), usuario = '$id_usuario', descricao = 'À prazo / Cliente : $nome / Venda: $id_venda', valor = '$total_venda', arquivo = 'sem-foto.jpg'");
  }

  echo 'Venda Salva!&-/z'.$id_venda;

} else {
  echo 'Nenhum produto na venda!';
}
